<?php

namespace BelkinDom\Adapters\Web\Form\Transformer;

use BelkinDom\DTO\Common\TranslatableContent;
use BelkinDom\Store\Common\TranslatableContent as TranslatableContentModel;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TranslatableContentModelToDTOTransformer implements DataTransformerInterface
{
    /**
     * Transforms a Model to a DTO.
     *
     * @param  TranslatableContentModel|null $model
     * @return TranslatableContent
     */
    public function transform($model)
    {
        $translatableContent = new TranslatableContent();

        if ($model) {
            $translatableContent->content = $model->content();
        }

        return $translatableContent;
    }

    /**
     * Transforms a DTO to a Model.
     *
     * @param  TranslatableContent $dto
     * @return TranslatableContentModel
     *
     * @throws TransformationFailedException
     */
    public function reverseTransform($dto)
    {
        $model = new TranslatableContentModel();
        $model->updateContent($dto->content);

        return $model;
    }
}
