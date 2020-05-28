<?php

namespace BelkinDom\DTO\Product;

class ProductsTotals
{
    /**
     * @var ProductsTotalsItem[]
     */
    private $items;

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * @return array|ProductsTotalsItem[]
     */
    public function items(): array
    {
        return $this->items;
    }

    /**
     * @param string $key
     *
     * @return ProductsTotalsItem|null
     */
    public function getItemByKey(string $key): ?ProductsTotalsItem
    {
        $result = array_filter($this->items, function (ProductsTotalsItem $item) use ($key) {
            return $item->key() === $key;
        });

        return array_shift($result);
    }
}
