<?php

namespace BelkinDom\Adapters\Web\Controller\Front;

use BelkinDom\Adapters\Web\Controller\FindTrait;
use BelkinDom\Adapters\Web\Menu\HeaderMenu;
use BelkinDom\Store\Blog\PostNotFoundException;
use BelkinDom\Store\Blog\PostUuid;
use BelkinDom\UseCase\Blog\FindPostsUseCase;
use BelkinDom\UseCase\Blog\GetPostUseCase;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface as Router;
use Twig\Environment as Twig;

class BlogController
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
     * @var HeaderMenu
     */
    private $headerMenu;

    public function __construct(Twig $twig, Router $router, HeaderMenu $headerMenu) {
        $this->twig = $twig;
        $this->router = $router;
        $this->headerMenu = $headerMenu;
        $this->headerMenu->updateCurrentItem(HeaderMenu::BLOG);
    }

    /**
     * @Route("/blog", name="front_blog", methods={"GET"})
     *
     * @param Request $request
     * @param FindPostsUseCase $findPostsUseCase
     *
     * @return Response
     *
     * @throws \Twig_Error
     */
    public function list(Request $request, FindPostsUseCase $findPostsUseCase): Response
    {
        try {
            $list = $findPostsUseCase->execute($this->createFindRequest($request));
        } catch (OutOfRangeCurrentPageException $x) {
            return $this->redirectToBlogList();
        }

        return new Response($this->twig->render('front/blog/list.html.twig', compact('list')));
    }

    /**
     * @Route("/blog/{id}", name="front_blog_post", methods={"GET"})
     *
     * @param string $id
     * @param GetPostUseCase $getPostUseCase
     *
     * @return Response
     *
     * @throws \Twig_Error
     */
    public function post(string $id, GetPostUseCase $getPostUseCase): Response
    {
        try {
            $post = $getPostUseCase->execute(PostUuid::existing($id));
        } catch (PostNotFoundException $x) {
            return $this->redirectToBlogList();
        }

        return new Response($this->twig->render('front/blog/post.html.twig', compact('post')));
    }

    /**
     * @return RedirectResponse
     */
    private function redirectToBlogList(): RedirectResponse
    {
        return new RedirectResponse($this->router->generate('front_blog'));
    }
}
