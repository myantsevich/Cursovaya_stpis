<?php

namespace BelkinDom\Adapters\Web\Form\Transformer;

use BelkinDom\DTO\Blog\Post;
use BelkinDom\Store\Blog\Post as PostModel;
use BelkinDom\Store\Blog\PostUuid;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class PostModelToDTOTransformer implements DataTransformerInterface
{
    /**
     * Transforms a Model to a DTO.
     *
     * @param  PostModel|null $model
     * @return Post
     */
    public function transform($model)
    {
        $post = new Post();

        if ($model) {
            $post->setPostUuid((string) $model->postUuid());
            $post->setHeader($model->header());
            $post->setSummary($model->summary());
            $post->setContent($model->content());
            $post->setPreviewImage($model->previewImage());
        }

        return $post;
    }

    /**
     * Transforms a DTO to a Model.
     *
     * @param  Post $dto
     * @return PostModel
     *
     * @throws TransformationFailedException
     */
    public function reverseTransform($dto)
    {
        return new PostModel(
            $dto->getPostUuid() ? PostUuid::existing($dto->getPostUuid()) : PostUuid::generated(),
            $dto->getHeader(),
            $dto->getSummary(),
            $dto->getContent(),
            $dto->getPreviewImage()
        );
    }
}
