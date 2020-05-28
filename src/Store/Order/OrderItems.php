<?php

namespace BelkinDom\Store\Order;

interface OrderItems
{
    /**
     * @param OrderItem $orderItem
     */
    public function save(OrderItem $orderItem): void;

    /**
     * @param OrderItem $orderItem
     */
    public function update(OrderItem $orderItem): void;

    /**
     * @param OrderItem $orderItem
     */
    public function remove(OrderItem $orderItem): void;
}
