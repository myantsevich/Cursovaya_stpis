<?php

namespace BelkinDom\Adapters\Web\Form\Transformer;

use BelkinDom\DTO\Order\Order;
use BelkinDom\Store\Cart\Cart;
use BelkinDom\Store\Order\Order as OrderModel;
use BelkinDom\Store\Order\OrderUuid;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class CartModelToOrderDTOTransformer implements DataTransformerInterface
{
    /**
     * Transforms a Model to a DTO.
     *
     * @param  Cart|null $model
     * @return Order
     */
    public function transform($model)
    {
        $dto = new Order();

        if ($model) {
            $dto->setOrderItems($model->cartItems());
        }

        return $dto;
    }

    /**
     * Transforms a DTO to a Model.
     *
     * @param  Order $dto
     * @return OrderModel
     *
     * @throws TransformationFailedException
     */
    public function reverseTransform($dto)
    {
        $items = [];

        foreach ($dto->getOrderItems() as $item) {
            $items[] = $item;
        }

        return OrderModel::generated(
            $items,
            (string) $dto->getPersonName(),
            (string) $dto->getPersonEmail(),
            OrderModel::STATUS_PENDING
        );
    }
}
