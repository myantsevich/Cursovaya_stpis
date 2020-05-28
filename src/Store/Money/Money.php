<?php

namespace BelkinDom\Store\Money;

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

    /**
     * @param float $amount
     *
     * @return Money
     */
    public function increaseAmountBy($amount): Money
    {
        return new self(
            $this->amount() + $amount,
            $this->currency()
        );
    }

    /**
     * @return float
     */
    public function amount(): float
    {
        return $this->amount;
    }

    /**
     * @return Currency
     */
    public function currency(): Currency
    {
        return $this->currency;
    }
}
