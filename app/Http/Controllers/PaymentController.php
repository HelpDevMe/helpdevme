<?php

namespace App\Http\Controllers;

use App\Post;
use App\Question;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        return view('payments.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function payWithPaypal(Request $request)
    {
        $id = $request->id;
        $title = $request->title;
        $budget = $request->budget;

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item = new Item();
        $item->setName($title)
            ->setCurrency('BRL')
            ->setQuantity(1)
            ->setDescription('Esta é a descrição do item')
            ->setPrice($budget);

        $itemList = new ItemList();
        $itemList->setItems([$item]);

        $amount = new Amount();
        $amount->setCurrency('BRL')
            ->setTotal($budget);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription('Comprando algo do meu site')
            ->setInvoiceNumber(uniqid());

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('payments.paypal.status', ['id' => $id]))
            ->setCancelUrl(route('payments.paypal.canceled', ['id' => $id]));

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

    public function status(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $this->authorize('status', $post);

        if (empty($request->input('PayerID')) || empty($request->input('token')))
        {
            return redirect()->route('home')->with('error', 'Pagamento Falhou');
        }

        $paymentId = $request->get('paymentId');
        $payment = Payment::get($paymentId, $this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));
        $result = $payment->execute($execution, $this->apiContext);

        if ($result->getState() == 'approved')
        {
            $question = $post->talk->question;
            $question->status = Question::PAYMENT;
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

        return redirect()->route('home')->with('error', 'Payment failed');
    }
    
    public function canceled()
    {
        return redirect()->route('home')->with('error', 'Pagamento Cancelado');
    }
}
