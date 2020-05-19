<?php

namespace App\Billing;

class CreditPaymentGateway implements PaymentGatewayContractI
{
	private $currency;
	private $discount;

	public function __construct($currency)
    {
    	$this->currency = $currency;
    	$this->discount = 0;
    }

    public function setDiscount($discount) {
    	$this->discount = $discount;
    }
	
	public function charge($amount) {
		
		return [
			'amount' => $amount,
			'confirmation_number' => '1234',
			'curency' => $this->currency,
			'discount' => $this->discount,
			'card_number' => '12311233'
		];

	}
}