<?php

namespace BelkinDom\Adapters\Web\Controller\Admin\Review;

use BelkinDom\Adapters\Web\Controller\FindTrait;
use BelkinDom\Adapters\Web\Form\Type\Review\ReviewType;
use BelkinDom\Store\Review\ReviewNotFoundException;
use BelkinDom\Store\Review\ReviewUuid;
use BelkinDom\UseCase\Review\CreateReviewUseCase;
use BelkinDom\UseCase\Review\FindReviewsUseCase;
use BelkinDom\UseCase\Review\GetReviewUseCase;
use BelkinDom\UseCase\Review\UpdateReviewUseCase;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface as Router;
use Twig\Environment as Twig;

class ReviewController
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
     * @var FindReviewsUseCase
     */
    private $findReviewsUseCase;

    /**
     * @var CreateReviewUseCase
     */
    private $createReviewUseCase;

    /**
     * @var GetReviewUseCase
     */
    private $getReviewUseCase;

    /**
     * @var UpdateReviewUseCase
     */
    private $updateReviewUseCase;

    public function __construct(
        Twig $twig,
        Router $router,
        FormFactoryInterface $formFactory,
        FindReviewsUseCase $findReviewsUseCase,
        CreateReviewUseCase $createReviewUseCase,
        GetReviewUseCase $getReviewUseCase,
        UpdateReviewUseCase $updateReviewUseCase
    ) {
        $this->twig = $twig;
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->findReviewsUseCase = $findReviewsUseCase;
        $this->createReviewUseCase = $createReviewUseCase;
        $this->getReviewUseCase = $getReviewUseCase;
        $this->updateReviewUseCase = $updateReviewUseCase;
    }

    /**
     * @Route("/admin/reviews", name="admin_reviews_cget")
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
            $list = $this->findReviewsUseCase->execute($this->createFindRequest($request));
        } catch (OutOfRangeCurrentPageException $x) {
            return new RedirectResponse($this->router->generate('admin_reviews_cget'));
        }

        return new Response($this->twig->render('admin/dashboard/review/list.html.twig', [
            'list' => $list
        ]));
    }

    /**
     * @Route("/admin/reviews/add", name="admin_reviews_put")
     *
     * @param Request $request
     * @return Response
     *
     * @throws \Exception
     */
    public function put(Request $request)
    {
        $form = $this->formFactory->create(ReviewType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $review = $form->getData();
            $this->createReviewUseCase->execute($review);

            $request->getSession()->getFlashBag()->add('success', 'reviews.flashes.put.success');

            if ($form->get('saveAndReturn')->isClicked()) {
                return new RedirectResponse($this->router->generate('admin_reviews_cget'));
            } else {
                return new RedirectResponse($this->router->generate('admin_reviews_post', ['id' => $review->reviewUuid()]));
            }
        }

        return new Response($this->twig->render('admin/dashboard/review/new.html.twig', [
            'form' => $form->createView(),
        ]));
    }

    /**
     * @Route("/admin/reviews/edit/{id}", name="admin_reviews_post")
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
            $post = $this->getReviewUseCase->execute(ReviewUuid::existing($id));
        } catch (ReviewNotFoundException $x) {
            return new RedirectResponse($this->router->generate('admin_reviews_cget'));
        }

        $form = $this->formFactory->create(ReviewType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->updateReviewUseCase->execute($post, $form->getData());

            $request->getSession()->getFlashBag()->add('success', 'reviews.flashes.post.success');

            if ($form->get('saveAndReturn')->isClicked()) {
                return new RedirectResponse($this->router->generate('admin_reviews_cget'));
            }
        }

        return new Response($this->twig->render('admin/dashboard/review/edit.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
