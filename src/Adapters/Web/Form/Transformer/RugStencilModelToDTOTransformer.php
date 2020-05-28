<?php

namespace BelkinDom\Adapters\Web\Form\Transformer;

use BelkinDom\DTO\Product\RugStencil;
use BelkinDom\Store\Product\RugStencil\RugStencil as RugStencilModel;
use BelkinDom\Store\Product\RugStencil\RugStencilUuid;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class RugStencilModelToDTOTransformer implements DataTransformerInterface
{
    /**
     * Transforms a Model to a DTO.
     *
     * @param  RugStencilModel|null $model
     * @return RugStencil
     */
    public function transform($model)
    {
        $dto = new RugStencil();

        if ($model) {
            $dto->rugStencilUuid = (string) $model->rugStencilUuid();
            $dto->file = $model->file();
        }

        return $dto;
    }

    /**
     * Transforms a DTO to a Model.
     *
     * @param  RugStencil $dto
     * @return RugStencilModel
     *
     * @throws TransformationFailedException
     */
    public function reverseTransform($dto)
    {
        return new RugStencilModel(
            $dto->rugStencilUuid ? RugStencilUuid::existing($dto->rugStencilUuid) : RugStencilUuid::generated(),
            $dto->file
        );
    }
}
