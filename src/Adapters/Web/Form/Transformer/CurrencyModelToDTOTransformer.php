<?php

namespace BelkinDom\Adapters\Web\Form\Transformer;

use BelkinDom\DTO\Money\Currency;
use BelkinDom\Store\Money\Currency as CurrencyModel;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class CurrencyModelToDTOTransformer implements DataTransformerInterface
{
    /**
     * Transforms a Model to a DTO.
     *
     * @param  CurrencyModel|null $model
     * @return Currency
     */
    public function transform($model)
    {
        $currency = new Currency();

        if ($model) {
            $currency->isoCode = $model->isoCode();
        }

        return $currency;
    }

    /**
     * Transforms a DTO to a Model.
     *
     * @param  Currency $dto
     * @return CurrencyModel
     *
     * @throws TransformationFailedException
     */
    public function reverseTransform($dto)
    {
        return new CurrencyModel((string) $dto->isoCode);
    }
}
