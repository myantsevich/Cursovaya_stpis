<?php

namespace BelkinDom\DTO\Product;

class ProductsTotalsItem
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var int
     */
    private $amount;

    public function __construct(string $key, int $amount = 0)
    {
        $this->key = $key;
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function key(): string
    {
        return $this->key;
    }

    /**
     * @return int
     */
    public function amount(): int
    {
        return $this->amount;
    }
}
