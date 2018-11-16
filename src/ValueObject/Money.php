<?php

namespace App\ValueObject;

class Money
{
    /**
     * @var float
     */
    private $amount;
    /**
     * @var Currency
     */
    private $currency;

    public function __construct(float $amount, Currency $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }
}