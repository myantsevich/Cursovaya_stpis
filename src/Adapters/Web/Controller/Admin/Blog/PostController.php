<?php

namespace BelkinDom\Adapters\Web\Controller\Admin\Blog;

use BelkinDom\Adapters\Web\Controller\FindTrait;
use BelkinDom\Adapters\Web\Form\Type\Blog\PostType;
use BelkinDom\Store\Blog\Post;
use BelkinDom\Store\Blog\PostNotFoundException;
use BelkinDom\Store\Blog\PostUuid;
use BelkinDom\UseCase\Blog\CreatePostUseCase;
use BelkinDom\UseCase\Blog\FindPostsUseCase;
use BelkinDom\UseCase\Blog\GetPostUseCase;
use BelkinDom\UseCase\Blog\UpdatePostUseCase;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface as Router;
use Twig\Environment as Twig;

class PostController
{
    use FindTrait;

    /**
     * @var Twig
     */
    private $twig;

    /**
     * @var Router
     */
    private $router;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var FindPostsUseCase
     */
    private $findPostsUseCase;

    /**
     * @var CreatePostUseCase
     */
    private $createPostUseCase;

    /**
     * @var GetPostUseCase
     */
    private $getPostUseCase;

    /**
     * @var UpdatePostUseCase
     */
    private $updatePostUseCase;

    public function __construct(
        Twig $twig,
        Router $router,
        FormFactoryInterface $formFactory,
        FindPostsUseCase $findPostsUseCase,
        CreatePostUseCase $createPostUseCase,
        GetPostUseCase $getPostUseCase,
        UpdatePostUseCase $updatePostUseCase
    ) {
        $this->twig = $twig;
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->findPostsUseCase = $findPostsUseCase;
        $this->createPostUseCase = $createPostUseCase;
        $this->getPostUseCase = $getPostUseCase;
        $this->updatePostUseCase = $updatePostUseCase;
    }

    /**
     * @Route("/admin/blog/posts", name="admin_blog_posts_cget")
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function cget(Request $request)
    {
        try {
            $list = $this->findPostsUseCase->execute($this->createFindRequest($request));
        } catch (OutOfRangeCurrentPageException $x) {
            return new RedirectResponse($this->router->generate('admin_blog_posts_cget'));
        }

        return new Response($this->twig->render('admin/dashboard/blog/list.html.twig', [
            'list' => $list
        ]));
    }

    /**
     * @Route("/admin/blog/posts/add", name="admin_blog_posts_put")
     *
     * @param Request $request
     * @return Response
     *
     * @throws \Exception
     */
    public function put(Request $request)
    {
        $form = $this->formFactory->create(PostType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Post $post */
            $post = $form->getData();
            $this->createPostUseCase->execute($post);

            $request->getSession()->getFlashBag()->add('success', 'blog.flashes.put.success');

            if ($form->get('saveAndReturn')->isClicked()) {
                return new RedirectResponse($this->router->generate('admin_blog_posts_cget'));
            } else {
                return new RedirectResponse($this->router->generate('admin_blog_posts_post', ['id' => $post->postUuid()]));
            }
        }

        return new Response($this->twig->render('admin/dashboard/blog/new.html.twig', [
            'form' => $form->createView(),
        ]));
    }

    /**
     * @Route("/admin/blog/posts/edit/{id}", name="admin_blog_posts_post")
     *
     * @param string $id
     * @param Request $request
     * @return Response
     *
     * @throws \Exception
     */
    public function post(string $id, Request $request)
    {
        try {
            $post = $this->getPostUseCase->execute(PostUuid::existing($id));
        } catch (PostNotFoundException $x) {
            return new RedirectResponse($this->router->generate('admin_blog_posts_cget'));
        }

        $form = $this->formFactory->create(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->updatePostUseCase->execute($post, $form->getData());

            $request->getSession()->getFlashBag()->add('success', 'blog.flashes.post.success');

            if ($form->get('saveAndReturn')->isClicked()) {
                return new RedirectResponse($this->router->generate('admin_blog_posts_cget'));
            }
        }

        return new Response($this->twig->render('admin/dashboard/blog/edit.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
