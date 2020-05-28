<?php

namespace BelkinDom\Adapters\Web\Form\Transformer;

use BelkinDom\DTO\Faq\FaqBlock;
use BelkinDom\Store\Faq\FaqBlock as FaqBlockModel;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class FaqBlockModelToDTOTransformer implements DataTransformerInterface
{
    /**
     * Transforms a Model to a DTO.
     *
     * @param  FaqBlockModel $model
     * @return FaqBlock
     */
    public function transform($model)
    {
        $faq = new FaqBlock();

        if ($model) {
            $faq->setQuestion($model->question());
            $faq->setAnswer($model->answer());
        }

        return $faq;
    }

    /**
     * Transforms a DTO to a Model.
     *
     * @param  FaqBlock $dto
     * @return FaqBlockModel()
     *
     * @throws TransformationFailedException
     */
    public function reverseTransform($dto)
    {
        return new FaqBlockModel(
            $dto->getQuestion(),
            $dto->getAnswer()
        );
    }
}
