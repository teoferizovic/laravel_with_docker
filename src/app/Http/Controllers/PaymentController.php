<?php

namespace App\Http\Controllers;

use PayPal\Api\Item;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\ItemList;
use PayPal\Api\WebProfile;
use PayPal\Api\InputFields;
use PayPal\Api\Transaction;
use Illuminate\Http\Request;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;
use PayPal\Rest\ApiContext;
use URL;
use Redirect;
use PayPal\Auth\OAuthTokenCredential;
use App\Billing\BankPaymentGateway;
use App\Orders\OrderDetail;
use App\Billing\PaymentGatewayContractI;

class PaymentController extends Controller
{
    private $apiContext;

    public function __construct()
    {
        /** PayPal api context **/
        $paypalConf = \Config::get('paypal');
        $this->apiContext = new ApiContext(new OAuthTokenCredential(
            $paypalConf['client_id'],
            $paypalConf['secret'])
        );
        $this->apiContext->setConfig($paypalConf['settings']);

    }

    public function createPayment(Request $request) {

    	$payer = new Payer();
	    $payer->setPaymentMethod("paypal");

	    $item1 = new Item();
	    $item1->setName('Ground Coffee 40 oz')
	        ->setCurrency('USD')
	        ->setQuantity(1)
	        ->setSku("123123") // Similar to `item_number` in Classic API
	        ->setPrice(7.5);

	    $item2 = new Item();
	    $item2->setName('Granola bars')
	        ->setCurrency('USD')
	        ->setQuantity(5)
	        ->setSku("321321") // Similar to `item_number` in Classic API
	        ->setPrice(2);

	    $itemList = new ItemList();
	    $itemList->setItems(array($item1, $item2));

	    $details = new Details();
	    $details->setShipping(1.2)
	           ->setTax(1.3)
	           ->setSubtotal(17.50);

	    $amount = new Amount();
	    $amount->setCurrency("USD")
	           ->setTotal(20)
	           ->setDetails($details);

	    $transaction = new Transaction();
	    $transaction->setAmount($amount)
	           		->setItemList($itemList)
	           		->setDescription("Payment description")
	           		->setInvoiceNumber(uniqid());
	    $redirectUrls = new RedirectUrls();
    	$redirectUrls->setReturnUrl(URL::to('/'))
        			 ->setCancelUrl(URL::to('/'));

    	// Add NO SHIPPING OPTION
    	$inputFields = new InputFields();
    	$inputFields->setNoShipping(1);

    	$webProfile = new WebProfile();
    	$webProfile->setName('test' . uniqid())->setInputFields($inputFields);

    	$webProfileId = $webProfile->create($this->apiContext)->getId();

    	$payment = new Payment();
    	$payment->setExperienceProfileId($webProfileId); // no shipping
    	$payment->setIntent("sale")
        		->setPayer($payer)
        		->setRedirectUrls($redirectUrls)
        		->setTransactions(array($transaction));

	    try {
	        $payment->create($this->apiContext);
	    } catch (Exception $ex) {
	        echo $ex;
	        return;
	        //exit(1);
	    }

	    return $payment;       		

    }

    public function executePayment(Request $request) {
    	
    	$paymentId = $request->paymentID;
    	$payment = Payment::get($paymentId, $this->apiContext);

    	$execution = new PaymentExecution();
   		$execution->setPayerId($request->payerID);

   		try {
        	$result = $payment->execute($execution, $this->apiContext);
    	} catch (Exception $ex) {
        	echo $ex;
        	return;
    	}

    	return $result;

    }

    public function mode(OrderDetail $order,PaymentGatewayContractI $paymentGateway) {
        $order->all();
        var_dump($paymentGateway->charge(23));
        die;
    }

}
