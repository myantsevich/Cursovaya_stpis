<?php

namespace BelkinDom\Adapters\Web\Form\Transformer;

use BelkinDom\DTO\Product\Gallery;
use BelkinDom\Store\Product\Gallery\Gallery as GalleryModel;
use BelkinDom\Store\Product\Gallery\GalleryUuid;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class GalleryModelToDTOTransformer implements DataTransformerInterface
{
    /**
     * Transforms a Model to a DTO.
     *
     * @param  GalleryModel|null $model
     * @return Gallery
     */
    public function transform($model)
    {
        $dto = new Gallery();

        if ($model) {
            $dto->galleryUuid = (string) $model->galleryUuid();
            $dto->items = $model->items();
        }

        return $dto;
    }

    /**
     * Transforms a DTO to a Model.
     *
     * @param  Gallery $dto
     * @return GalleryModel
     *
     * @throws TransformationFailedException
     */
    public function reverseTransform($dto)
    {
        $items = [];

        foreach ($dto->items as $item) {
            if ($item->image()->path() || $item->image()->tempPath()) {
                $items[] = $item;
            }
        }

        return new GalleryModel(
            $dto->galleryUuid ? GalleryUuid::existing($dto->galleryUuid) : GalleryUuid::generated(),
            $items
        );
    }
}
