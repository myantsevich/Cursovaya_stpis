<?php

namespace BelkinDom\Adapters\Database\Doctrine;

use BelkinDom\DTO\Request\Common\Find;
use BelkinDom\Store\Blog\Posts;
use BelkinDom\Store\Blog\Post;
use BelkinDom\Store\Blog\PostNotFoundException;
use BelkinDom\Store\Blog\PostUuid;
use Pagerfanta\Pagerfanta;

final class PostsRepository extends EntityRepository implements Posts
{
    /**
     * @param PostUuid $uuid
     *
     * @return Post
     *
     * @throws PostNotFoundException
     */
    public function get(PostUuid $uuid): Post
    {
        $post = $this->find((string) $uuid);

        if (!$post instanceof Post) {
            throw new PostNotFoundException($uuid);
        }

        return $post;
    }

    /**
     * @param Find $findRequest
     *
     * @return Pagerfanta
     */
    public function list(Find $findRequest): Pagerfanta
    {
        $qb = $this->createQueryBuilder('post');

        return $this->createPaginator($qb, $findRequest);
    }

    /**
     * @param Post $post
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Post $post)
    {
        $this->getEntityManager()->persist($post);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Post $post
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(Post $post)
    {
        $this->getEntityManager()->merge($post);
        $this->getEntityManager()->flush();
    }
}
