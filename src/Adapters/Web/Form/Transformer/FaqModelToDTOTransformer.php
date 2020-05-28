<?php

namespace BelkinDom\Adapters\Web\Form\Transformer;

use BelkinDom\DTO\Faq\Faq;
use BelkinDom\Store\Faq\Faq as FaqModel;
use BelkinDom\Store\Faq\FaqUuid;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class FaqModelToDTOTransformer implements DataTransformerInterface
{
    /**
     * Transforms a Model to a DTO.
     *
     * @param  FaqModel $model
     * @return Faq
     */
    public function transform($model)
    {
        $faq = new Faq();

        if ($model) {
            $faq->setFaqUuid($model->faqUuid());
            $faq->setBlocks($model->blocks());
        }

        return $faq;
    }

    /**
     * Transforms a DTO to a Model.
     *
     * @param  Faq $dto
     * @return FaqModel
     *
     * @throws TransformationFailedException
     */
    public function reverseTransform($dto)
    {
        return new FaqModel(FaqUuid::existing($dto->getFaqUuid()), $dto->getBlocks());
    }
}
