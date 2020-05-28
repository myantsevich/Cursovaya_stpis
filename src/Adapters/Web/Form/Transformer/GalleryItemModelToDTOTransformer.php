<?php

namespace BelkinDom\Adapters\Web\Form\Transformer;

use BelkinDom\DTO\Product\GalleryItem;
use BelkinDom\Store\Product\Gallery\GalleryItem as GalleryItemModel;
use BelkinDom\Store\Product\Gallery\GalleryItemUuid;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class GalleryItemModelToDTOTransformer implements DataTransformerInterface
{
    /**
     * Transforms a Model to a DTO.
     *
     * @param  GalleryItemModel|null $model
     * @return GalleryItem
     */
    public function transform($model)
    {
        $dto = new GalleryItem();

        if ($model) {
            $dto->galleryItemUuid = (string) $model->galleryItemUuid();
            $dto->image = $model->image();
            $dto->isMain = $model->isMain();
        }

        return $dto;
    }

    /**
     * Transforms a DTO to a Model.
     *
     * @param  GalleryItem $dto
     * @return GalleryItemModel
     *
     * @throws TransformationFailedException
     */
    public function reverseTransform($dto)
    {
        return new GalleryItemModel(
            $dto->galleryItemUuid ? GalleryItemUuid::existing($dto->galleryItemUuid) : GalleryItemUuid::generated(),
            $dto->image,
            (bool) $dto->isMain
        );
    }
}
