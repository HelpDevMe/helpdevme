<?php

namespace App\Http\Controllers;

use App\Post;
use App\Question;
use App\Finance;
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
        $config = [
            'item' => [
                'title' => $request->title,
                'budget' => $request->budget,
                'description' => 'Esta é a descrição do item'
            ],
            'transaction' => [
                'description' => 'Pagamento na plataforma'
            ],
            'redirects' => [
                'return' => route('payments.paypal.status', ['id' => $request->id]),
                'cancel' => route('payments.paypal.canceled', ['id' => $request->id])
            ]
        ];

        return $this->paypal($config);
    }

    public function fund(MoneyValidationFormRequest $request)
    {
        /**
         * Atualiza o saldo final do usuário
         * Salva e retorna o histórico de transações
         */
        $finance = auth()->user()->deposit($request->budget);
        
        $config = [
            'item' => [
                'title' => 'Créditos para minha conta',
                'budget' => $request->budget,
                'description' => 'Esta é a descrição do item'
            ],
            'transaction' => [
                'description' => 'Pagamento na plataforma'
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
        if (empty($request->input('PayerID')) || empty($request->input('token')))
        {
            Finance::destroy($id);
            return redirect()->route('finances.index')->with('error', 'Pagamento falhou :(');
        }

        $paymentId = $request->get('paymentId');
        $payment = Payment::get($paymentId, $this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));
        $result = $payment->execute($execution, $this->apiContext);

        if ($result->getState() == 'approved')
        {
            $finance = Finance::find($id);
            $finance->confirmed = 1;
            $finance->save();

            return redirect()->route('finances.index')->with('success', 'Créditos adicionados com sucesso!');
        }

        Finance::destroy($id);
        return redirect()->route('finances.index')->with('error', 'Pagamento falhou :(');
    }

    public function statusPay(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $this->authorize('status', $post);

        if (empty($request->input('PayerID')) || empty($request->input('token')))
        {
            return redirect()->route('home')->with('error', 'Pagamento falhou :(');
        }

        $paymentId = $request->get('paymentId');
        $payment = Payment::get($paymentId, $this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));
        $result = $payment->execute($execution, $this->apiContext);

        if ($result->getState() == 'approved')
        {
            $finance = new Finance;
            $finance->user_id = auth()->id();
            $finance->receiver_id = $post->user->id;
            $finance->budget = $post->budget;
            $finance->post_id = $post->id;
            $finance->save();

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

        return redirect()->route('home')->with('error', 'Pagamento falhou :(');
    }
    
    public function canceledPay(Request $request, $id)
    {
        return redirect()->route('home')->with('error', 'Pagamento Cancelado');
    }
    
    public function canceledFund(Request $request, $id)
    {
        Finance::destroy($id);
        return redirect()->route('finances.index')->with('error', 'Pagamento Cancelado');
    }
}
