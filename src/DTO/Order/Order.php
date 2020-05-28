<?php

namespace BelkinDom\DTO\Order;

class Order
{
    /**
     * @var array
     */
    private $orderItems = [];

    /**
     * @var string|null
     */
    private $personName;

    /**
     * @var string|null
     */
    private $personEmail;

    /**
     * @return array
     */
    public function getOrderItems(): array
    {
        return $this->orderItems;
    }

    /**
     * @param array $orderItems
     */
    public function setOrderItems(array $orderItems): void
    {
        $this->orderItems = $orderItems;
    }

    /**
     * @return null|string
     */
    public function getPersonName(): ?string
    {
        return $this->personName;
    }

    /**
     * @param null|string $personName
     */
    public function setPersonName(?string $personName): void
    {
        $this->personName = $personName;
    }

    /**
     * @return null|string
     */
    public function getPersonEmail(): ?string
    {
        return $this->personEmail;
    }

    /**
     * @param null|string $personEmail
     */
    public function setPersonEmail(?string $personEmail): void
    {
        $this->personEmail = $personEmail;
    }
}
