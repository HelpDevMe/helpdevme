<?php

namespace App\Http\Controllers;

use App\Post;
use App\Question;
use App\Finance;
use App\User;
use Illuminate\Http\Request;
use App\Events\PrivatePostSent;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;
use App\Http\Requests\MoneyValidationFormRequest;

class PaymentController extends Controller
{
    private $secret;
    private $clientId;
    private $apiContext;

    public function __construct()
    {
        if (config('paypal.settings.mode') == 'live') {
            $this->secret = config('paypal.live.secret');
            $this->clientId = config('paypal.live.client_id');
        } else {
            $this->secret = config('paypal.sandbox.secret');
            $this->clientId = config('paypal.sandbox.client_id');
        }

        $this->apiContext = new ApiContext(new OAuthTokenCredential($this->clientId, $this->secret));
        $this->apiContext->setConfig(config('paypal.settings'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);

        $this->authorize('payment', $post);

        return view('payments.show', compact('post'));
    }

    protected function paypal($config)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item = new Item();
        $item->setName($config['item']['title'])
            ->setCurrency('BRL')
            ->setQuantity(1)
            ->setDescription($config['item']['description'])
            ->setPrice($config['item']['budget']);

        $itemList = new ItemList();
        $itemList->setItems([$item]);

        $amount = new Amount();
        $amount->setCurrency('BRL')
            ->setTotal($config['item']['budget']);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription($config['transaction']['description'])
            ->setInvoiceNumber(uniqid());

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($config['redirects']['return'])
            ->setCancelUrl($config['redirects']['cancel']);

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

        try {
            $payment->create($this->apiContext);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            die($ex);
        }

        $paymentLink = $payment->getApprovalLink();

        return redirect($paymentLink);
    }

    public function pay(Request $request)
    {
        $post = Post::findOrFail($request->id);

        /**
         * Histórico de transação do pagador
         */
        $finance = new Finance;
        $finance->user_id = auth()->id();
        $finance->receiver_id = $post->talk->user_id;
        $finance->type = Finance::types['payment'];
        $finance->budget = number_format($request->budget, 2, '.', '');
        $finance->post_id = $post->id;
        $finance->confirmed = 0;
        $finance->save();

        $config = [
            'item' => [
                'title' => $request->title,
                'budget' => $request->budget,
                'description' => 'Pagamento para o desenvolvedor Fulano'
            ],
            'transaction' => [
                'description' => 'Ele já pode começar a lhe dar suporte em seu bug!'
            ],
            'redirects' => [
                'return' => route('payments.paypal.status', ['id' => $finance->id]),
                'cancel' => route('payments.paypal.canceled', ['id' => $finance->id])
            ]
        ];

        return $this->paypal($config);
    }

    public function statusPay(Request $request, $id)
    {
        $finance = Finance::find($id);
        $post = Post::findOrFail($finance->post->id);

        $this->authorize('status', $post);

        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
            Finance::destroy($id);
            return redirect()->route('home')->with('error', 'Pagamento falhou :(');
        }

        $paymentId = $request->get('paymentId');
        $payment = Payment::get($paymentId, $this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));
        $result = $payment->execute($execution, $this->apiContext);

        if ($result->getState() == 'approved') {

            $finance->confirmed = 1;
            $finance->update();

            /**
             * Histórico de transação do recebedor
             */
            $financeReceiver = new Finance;
            $financeReceiver->user_id = $post->talk->user_id;
            $financeReceiver->receiver_id = auth()->id();
            $financeReceiver->type = Finance::types['received'];
            $financeReceiver->budget = number_format($finance->budget, 2, '.', '');
            $financeReceiver->post_id = $post->id;
            $financeReceiver->confirmed = 1;
            $financeReceiver->save();

            $question = $post->talk->question;
            $question->status = Question::status['payment'];
            $question->update();

            $post->status = Post::status['payment'];
            $post->update();

            $alert = new Post;
            $alert->talk_id = $post->talk->id;
            $alert->user_id = auth()->id();
            $alert->body = 'Pagamento Efetuado';
            $alert->type = Post::types['alert'];
            $alert->status = Post::status['payment'];
            $alert->save();

            broadcast(new PrivatePostSent($alert));

            return redirect()->route('talks.show', $post->talk)->with('success', 'Pagamento Feito! Trabalhem na sua pergunta ;)');
        }

        Finance::destroy($id);
        return redirect()->route('home')->with('error', 'Pagamento falhou :(');
    }

    public function canceledPay(Request $request, $id)
    {
        return redirect()->route('home')->with('error', 'Pagamento Cancelado');
    }

    /**
     * Método para adicionar saldo a conta
     */
    public function fund(MoneyValidationFormRequest $request)
    {
        $finance = auth()->user()->finances()->create([
            'user_id' => auth()->id(),
            'receiver_id' => auth()->id(),
            'type' => Finance::types['fund'],
            'budget' => number_format($request->budget, 2, '.', ''),
            'confirmed' => 0
        ]);

        $config = [
            'item' => [
                'title' => 'Recarga de saldo Help Dev',
                'budget' => $request->budget,
                'description' => 'Tendo saldo positivo na sua conta, você poderá solucionar seus bugs rapidinhos!'
            ],
            'transaction' => [
                'description' => 'Recarga de saldo Help Dev'
            ],
            'redirects' => [
                'return' => route('payments.paypal.fund.status', ['id' => $finance->id]),
                'cancel' => route('payments.paypal.fund.canceled', ['id' => $finance->id])
            ]
        ];

        /**
         * Vai até o PayPal e volta com o retorno de lá
         */
        $payment = $this->paypal($config);

        return $payment;
    }

    public function statusFund(Request $request, $id)
    {
        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
            Finance::destroy($id);
            return redirect()->route('finances.index')->with('error', 'Pagamento falhou :(');
        }

        $paymentId = $request->get('paymentId');
        $payment = Payment::get($paymentId, $this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));
        $result = $payment->execute($execution, $this->apiContext);

        if ($result->getState() == 'approved') {
            $finance = Finance::find($id);
            $finance->confirmed = 1;
            $finance->update();

            /**
             * Update amount column user with balance
             */
            $user = auth()->user();
            $user->amount += $finance->budget;
            $user->update();

            return redirect()->route('finances.index')->with('success', 'Créditos adicionados com sucesso!');
        }

        Finance::destroy($id);
        return redirect()->route('finances.index')->with('error', 'Pagamento falhou :(');
    }

    public function canceledFund(Request $request, $id)
    {
        Finance::destroy($id);
        return redirect()->route('finances.index')->with('error', 'Pagamento Cancelado');
    }
}
