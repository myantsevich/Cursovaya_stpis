<?php

namespace BelkinDom\Adapters\Web\Form\Transformer;

use BelkinDom\DTO\Product\Product;
use BelkinDom\Store\Product\Product as ProductModel;
use BelkinDom\Store\Product\ProductUuid;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ProductModelToDTOTransformer implements DataTransformerInterface
{
    /**
     * Transforms a Model to a DTO.
     *
     * @param ProductModel $model
     * @return string
     */
    public function transform($model)
    {
        $product = new Product();

        if ($model) {
            $product->productUuid = (string) $model->productUuid();
            $product->category = $model->category();
            $product->price = $model->price();
            $product->title = $model->title();
            $product->summary = $model->summary();
            $product->description = $model->description();
            $product->availability = $model->availability();
            $product->material = $model->material();
            $product->gallery = $model->gallery();
            $product->created = $model->created();
        }

        return $product;
    }

    /**
     * Transforms a DTO to a Model.
     *
     * @param  Product $dto
     * @return ProductModel
     *
     * @throws TransformationFailedException
     */
    public function reverseTransform($dto)
    {
        return new ProductModel(
            $dto->productUuid ? ProductUuid::existing($dto->productUuid) : ProductUuid::generated(),
            $dto->price,
            $dto->title,
            $dto->summary,
            $dto->description,
            (bool) $dto->availability,
            $dto->gallery,
            $dto->category,
            $dto->material,
            $dto->created ?? new \DateTimeImmutable()
        );
    }
}
