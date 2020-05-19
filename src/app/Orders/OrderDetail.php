<?php
namespace App\Orders;

use App\Billing\BankPaymentGateway;
use App\Billing\PaymentGatewayContractI;

class OrderDetail
{
	
	private $paymentGateway;

	function __construct(PaymentGatewayContractI $paymentGateway)
	{
		$this->paymentGateway = $paymentGateway;
	}

	public function all() {

		$this->paymentGateway->setDiscount(22);

		return [
			'name' => 'John Doe',
			'address' => 'New York',
		];
	}
}