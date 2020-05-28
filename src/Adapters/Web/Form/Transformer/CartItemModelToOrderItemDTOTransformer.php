<?php

namespace BelkinDom\Adapters\Web\Form\Transformer;

use BelkinDom\DTO\Order\OrderItem;
use BelkinDom\Store\Cart\CartItem;
use BelkinDom\Store\Order\OrderItem as OrderItemModel;
use BelkinDom\Store\Order\OrderItemUuid;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class CartItemModelToOrderItemDTOTransformer implements DataTransformerInterface
{
    /**
     * Transforms a Model to a DTO.
     *
     * @param  CartItem|null $model
     * @return OrderItem
     */
    public function transform($model)
    {
        $dto = new OrderItem();

        if ($model) {
            $dto->setProduct($model->product());
            $dto->setQuantity($model->quantity());
        }

        return $dto;
    }

    /**
     * Transforms a DTO to a Model.
     *
     * @param  OrderItem $dto
     * @return OrderItemModel
     *
     * @throws TransformationFailedException
     */
    public function reverseTransform($dto)
    {
        return OrderItemModel::generated($dto->getProduct(), (int) $dto->getQuantity());
    }
}
