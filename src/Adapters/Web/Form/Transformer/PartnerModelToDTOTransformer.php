<?php

namespace BelkinDom\Adapters\Web\Form\Transformer;

use BelkinDom\DTO\Partner\Partner;
use BelkinDom\Store\Partner\Partner as PartnerModel;
use BelkinDom\Store\Partner\PartnerUuid;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class PartnerModelToDTOTransformer implements DataTransformerInterface
{
    /**
     * Transforms a Model to a DTO.
     *
     * @param  PartnerModel|null $model
     * @return Partner
     */
    public function transform($model)
    {
        $post = new Partner();

        if ($model) {
            $post->setPartnerUuid((string) $model->partnerUuid());
            $post->setName($model->name());
            $post->setDiscount($model->discount());
            $post->setCode($model->code());
            $post->setImage($model->image());
        }

        return $post;
    }

    /**
     * Transforms a DTO to a Model.
     *
     * @param  Partner $dto
     * @return PartnerModel
     *
     * @throws TransformationFailedException
     */
    public function reverseTransform($dto)
    {
        return new PartnerModel(
            $dto->getPartnerUuid() ? PartnerUuid::existing($dto->getPartnerUuid()) : PartnerUuid::generated(),
            (string) $dto->getName(),
            (int) $dto->getDiscount(),
            (string) $dto->getCode(),
            $dto->getImage()
        );
    }
}
