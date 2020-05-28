<?php

namespace BelkinDom\Adapters\Web\Form\Transformer;

use BelkinDom\DTO\Review\Review;
use BelkinDom\Store\Review\Review as ReviewModel;
use BelkinDom\Store\Review\ReviewUuid;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ReviewModelToDTOTransformer implements DataTransformerInterface
{
    /**
     * Transforms a Model to a DTO.
     *
     * @param  ReviewModel|null $model
     * @return Review
     */
    public function transform($model)
    {
        $post = new Review();

        if ($model) {
            $post->setReviewUuid((string) $model->reviewUuid());
            $post->setAuthorName($model->authorName());
            $post->setBody($model->body());
        }

        return $post;
    }

    /**
     * Transforms a DTO to a Model.
     *
     * @param  Review $dto
     * @return ReviewModel
     *
     * @throws TransformationFailedException
     */
    public function reverseTransform($dto)
    {
        return new ReviewModel(
            $dto->getReviewUuid() ? ReviewUuid::existing($dto->getReviewUuid()) : ReviewUuid::generated(),
            $dto->getAuthorName(),
            $dto->getBody()
        );
    }
}
