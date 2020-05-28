<?php

namespace BelkinDom\Store\Order;

use BelkinDom\Store\Money\Money;

class Order
{
    const
        STATUS_PENDING = 'pending',
        STATUS_COMPLETED = 'completed'
    ;

    /**
     * @var OrderUuid
     */
    private $orderUuid;

    /**
     * @var OrderItem[]
     */
    private $orderItems;

    /**
     * @var string
     */
    private $personName;

    /**
     * @var string
     */
    private $personEmail;

    /**
     * @var string
     */
    private $status;

    public function __construct(
        OrderUuid $orderUuid,
        array $orderItems,
        string $personName,
        string $personEmail,
        string $status
    ) {
        $this->orderUuid = $orderUuid;
        $this->orderItems = $orderItems;
        $this->personName = $personName;
        $this->personEmail = $personEmail;
        $this->status = $status;
    }

    public static function generated(
        array $orderItems,
        string $personName,
        string $personEmail,
        string $status
    ): Order {
        return new self(OrderUuid::generated(), $orderItems, $personName, $personEmail, $status);
    }

    /**
     * @return OrderUuid
     */
    public function orderUuid(): OrderUuid
    {
        return $this->orderUuid;
    }

    /**
     * @return array
     */
    public function orderItems():  array
    {
        if (is_array($this->orderItems)) {
            return $this->orderItems;
        }

        if (is_object($this->orderItems) && in_array('toArray', get_class_methods($this->orderItems))) {
            return $this->orderItems->toArray();
        }

        return [];
    }

    /**
     * @return string
     */
    public function personName(): string
    {
        return $this->personName;
    }

    /**
     * @return string
     */
    public function personEmail(): string
    {
        return $this->personEmail;
    }

    /**
     * @return string
     */
    public function status(): string
    {
        return $this->status;
    }

    /**
     * @return Money
     */
    public function totalPrice(): Money
    {
        $total = null;

        foreach ($this->orderItems() as $orderItem) {
            if (!$total) {
                $total = new Money(0, $orderItem->price()->currency());
            }

            $total = $total->increaseAmountBy($orderItem->price()->amount());
        }

        return $total;
    }
}
