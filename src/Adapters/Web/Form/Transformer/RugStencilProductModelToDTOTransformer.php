<?php

namespace BelkinDom\Adapters\Web\Form\Transformer;

use BelkinDom\DTO\Product\RugStencilProduct;
use BelkinDom\Store\Product\RugStencilProduct as RugStencilProductModel;
use BelkinDom\Store\Product\ProductUuid;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class RugStencilProductModelToDTOTransformer implements DataTransformerInterface
{
    /**
     * Transforms a Model to a DTO.
     *
     * @param RugStencilProductModel $model
     * @return string
     */
    public function transform($model)
    {
        $product = new RugStencilProduct();

        if ($model) {
            $product->productUuid = (string) $model->productUuid();
            $product->price = $model->price();
            $product->title = $model->title();
            $product->summary = $model->summary();
            $product->description = $model->description();
            $product->gallery = $model->gallery();
            $product->availability = $model->availability();
            $product->stencils = $model->stencils();
            $product->created = $model->created();
        }

        return $product;
    }

    /**
     * Transforms a DTO to a Model.
     *
     * @param  RugStencilProduct $dto
     * @return RugStencilProductModel
     *
     * @throws TransformationFailedException
     */
    public function reverseTransform($dto)
    {
        $stencils = [];

        foreach ($dto->stencils as $stencil) {
            if ($stencil->file()->path() || $stencil->file()->tempPath()) {
                $stencils[] = $stencil;
            }
        }

        return new RugStencilProductModel(
            $dto->productUuid ? ProductUuid::existing($dto->productUuid) : ProductUuid::generated(),
            $dto->price,
            $dto->title,
            $dto->summary,
            $dto->description,
            (bool) $dto->availability,
            $dto->gallery,
            $stencils,
            $dto->created ?? new \DateTimeImmutable()
        );
    }
}
