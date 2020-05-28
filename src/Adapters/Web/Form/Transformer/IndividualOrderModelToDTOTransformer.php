<?php

namespace BelkinDom\Adapters\Web\Form\Transformer;

use BelkinDom\DTO\Order\IndividualOrder;
use BelkinDom\Store\Order\IndividualOrder as IndividualOrderModel;
use BelkinDom\Store\Order\OrderUuid;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class IndividualOrderModelToDTOTransformer implements DataTransformerInterface
{
    /**
     * Transforms a Model to a DTO.
     *
     * @param  IndividualOrderModel|null $model
     * @return IndividualOrder
     */
    public function transform($model)
    {
        $order = new IndividualOrder;

        if ($model) {
            $order->setOrderUuid((string) $model->orderUuid());
            $order->setPersonName($model->personName());
            $order->setPersonEmail($model->personEmail());
            $order->setMessage($model->message());
            $order->setSize($model->size());
            $order->setShape($model->shape());
            $order->setMaterial($model->material());
        }

        return $order;
    }

    /**
     * Transforms a DTO to a Model.
     *
     * @param  IndividualOrder $dto
     * @return IndividualOrderModel
     *
     * @throws TransformationFailedException
     */
    public function reverseTransform($dto)
    {
        return new IndividualOrderModel(
            $dto->getOrderUuid() ? OrderUuid::existing($dto->getOrderUuid()) : OrderUuid::generated(),
            (string) $dto->getPersonName(),
            (string) $dto->getPersonEmail(),
            (string) $dto->getMessage(),
            (string) $dto->getSize(),
            (string) $dto->getShape(),
            (string) $dto->getMaterial()
        );
    }
}
