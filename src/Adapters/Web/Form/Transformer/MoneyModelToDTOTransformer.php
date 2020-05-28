<?php

namespace BelkinDom\Adapters\Web\Form\Transformer;

use BelkinDom\DTO\Money\Money;
use BelkinDom\Store\Money\Money as MoneyModel;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class MoneyModelToDTOTransformer implements DataTransformerInterface
{
    /**
     * Transforms a Model to a DTO.
     *
     * @param  MoneyModel|null $model
     * @return Money
     */
    public function transform($model)
    {
        $money = new Money();

        if ($model) {
            $money->amount = $model->amount();
            $money->currency = $model->currency();
        }

        return $money;
    }

    /**
     * Transforms a DTO to a Model.
     *
     * @param  Money $dto
     * @return MoneyModel
     *
     * @throws TransformationFailedException
     */
    public function reverseTransform($dto)
    {
        return new MoneyModel((float) $dto->amount, $dto->currency);
    }
}
