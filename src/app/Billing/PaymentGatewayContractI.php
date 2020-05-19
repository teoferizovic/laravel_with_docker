<?php

namespace App\Billing;

interface PaymentGatewayContractI
{
    public function setDiscount($discount);
    public function charge($amount);
}