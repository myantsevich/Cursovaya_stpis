<?php

namespace BelkinDom\Adapters\Web\Controller\Front;

use BelkinDom\Adapters\Web\Controller\FindTrait;
use BelkinDom\Adapters\Web\Form\Type\Order\IndividualOrderType;
use BelkinDom\Adapters\Web\Menu\HeaderMenu;
use BelkinDom\Store\Product\Category\CategoryNotFoundException;
use BelkinDom\Store\Product\ProductNotFoundException;
use BelkinDom\Store\Product\ProductUuid;
use BelkinDom\UseCase\Order\CreateIndividualOrderUseCase;
use BelkinDom\UseCase\Product\GetCategoryBySlugUseCase;
use BelkinDom\UseCase\Product\GetProductsTotalsByCategoryUseCase;
use BelkinDom\UseCase\Product\Regular\FindRegularProductsByCategoryUseCase;
use BelkinDom\UseCase\Product\Regular\GetRegularProductUseCase;
use BelkinDom\UseCase\Product\RugStencil\FindRugStencilProductsUseCase;
use BelkinDom\UseCase\Product\RugStencil\GetRugStencilProductUseCase;
use BelkinDom\UseCase\Product\ViewCategoriesListUseCase;
use BelkinDom\UseCase\Web\GetConfigUseCase;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface as Router;
use Twig\Environment as Twig;

class StoreController
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
     * @var HeaderMenu
     */
    private $headerMenu;

    /**
     * @var GetCategoryBySlugUseCase
     */
    private $getCategoryBySlugUseCase;

    /**
     * @var GetProductsTotalsByCategoryUseCase
     */
    private $getProductsTotalsByCategoryUseCase;

    /**
     * @var ViewCategoriesListUseCase
     */
    private $viewCategoriesListUseCase;

    /**
     * @var FindRegularProductsByCategoryUseCase
     */
    private $findRegularProductsByCategoryUseCase;

    /**
     * @var GetRegularProductUseCase
     */
    private $getRegularProductUseCase;

    /**
     * @var FindRugStencilProductsUseCase
     */
    private $findRugStencilsProductsUseCase;

    /**
     * @var GetRugStencilProductUseCase
     */
    private $getRugStencilProductUseCase;

    /**
     * @var CreateIndividualOrderUseCase
     */
    private $createIndividualOrderUseCase;

    /**
     * @var GetConfigUseCase
     */
    private $getConfigUseCase;

    public function __construct(
        Twig $twig,
        Router $router,
        FormFactoryInterface $formFactory,
        HeaderMenu $headerMenu,
        GetConfigUseCase $getConfigUseCase,

        GetCategoryBySlugUseCase $getCategoryBySlugUseCase,
        GetProductsTotalsByCategoryUseCase $getProductsTotalsByCategoryUseCase,
        ViewCategoriesListUseCase $viewCategoriesListUseCase,

        FindRegularProductsByCategoryUseCase $findRegularProductsByCategoryUseCase,
        GetRegularProductUseCase $getRegularProductUseCase,

        FindRugStencilProductsUseCase $findRugStencilsProductsUseCase,
        GetRugStencilProductUseCase $getRugStencilProductUseCase,

        CreateIndividualOrderUseCase $createIndividualOrderUseCase
    ) {
        $this->twig = $twig;
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->headerMenu = $headerMenu;
        $this->headerMenu->updateCurrentItem(HeaderMenu::STORE);
        $this->getConfigUseCase = $getConfigUseCase;

        $this->getCategoryBySlugUseCase = $getCategoryBySlugUseCase;
        $this->getProductsTotalsByCategoryUseCase = $getProductsTotalsByCategoryUseCase;
        $this->viewCategoriesListUseCase = $viewCategoriesListUseCase;

        $this->findRegularProductsByCategoryUseCase = $findRegularProductsByCategoryUseCase;
        $this->getRegularProductUseCase = $getRegularProductUseCase;

        $this->findRugStencilsProductsUseCase = $findRugStencilsProductsUseCase;
        $this->getRugStencilProductUseCase = $getRugStencilProductUseCase;

        $this->createIndividualOrderUseCase = $createIndividualOrderUseCase;
    }

    /**
     * @Route("/store", name="front_store", methods={"GET"})
     * @return RedirectResponse
     */
    public function inStock()
    {
        $categories = $this->viewCategoriesListUseCase->execute();
        $category = $categories[0];

        return new RedirectResponse($this->router->generate('front_store_category_products', [
            'slug' => $category->slug(),
        ]));
    }

    /**
     * @Route("/store/order", name="front_store_individual_order", methods={"GET", "POST"})
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Twig_Error
     */
    public function individualOrder(Request $request)
    {
        $form = $this->formFactory->create(IndividualOrderType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->createIndividualOrderUseCase->execute($form->getData());

            $config = $this->getConfigUseCase->execute();
            if ($config->orderFlashEnabled()) {
                $request->getSession()->getFlashBag()->add(
                    'success',
                    $config->orderFlashText()->translate($request->getLocale())
                );
            }

            return new RedirectResponse($this->router->generate('front_store_individual_order'));
        }

        return new Response($this->twig->render('front/store/individualOrder/form.html.twig', [
            'form' => $form->createView(),
        ]));
    }

    /**
     * @Route("/store/rug-stencils", name="front_store_rug_stencils_products", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Twig_Error
     */
    public function rugStencils(Request $request)
    {
        try {
            $list = $this->findRugStencilsProductsUseCase->execute($this->createFindRequest($request));
        } catch (OutOfRangeCurrentPageException $x) {
            return new RedirectResponse($this->router->generate('front_store_rug_stencils_products', [
                'page' => 1,
            ]));
        }

        return new Response($this->twig->render('front/store/rugStencils/list.html.twig', compact('list')));
    }

    /**
     * @Route("/store/rug-stencils/{id}", name="front_store_rug_stencil_product_get", methods={"GET"})
     *
     * @param string $id
     *
     * @return Response
     *
     * @throws \Twig_Error
     */
    public function rugStencilProduct(string $id)
    {
        try {
            $product = $this->getRugStencilProductUseCase->execute(ProductUuid::existing($id));
        } catch (ProductNotFoundException $x) {
            return new RedirectResponse($this->router->generate('front_store_rug_stencils_products'));
        };

        return new Response($this->twig->render('front/store/rugStencils/view.html.twig', compact('product')));
    }

    /**
     * @Route("/store/{slug}", name="front_store_category_products", methods={"GET"})
     *
     * @param string $slug
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Twig_Error
     */
    public function categoryProducts(string $slug, Request $request)
    {
        try {
            $category = $this->getCategoryBySlugUseCase->execute($slug);
        } catch (CategoryNotFoundException $x) {
            return new RedirectResponse($this->router->generate('front_store'));
        }

        try {
            $list = $this->findRegularProductsByCategoryUseCase->execute($category, $this->createFindRequest($request));
        } catch (OutOfRangeCurrentPageException $x) {
            return new RedirectResponse($this->router->generate('front_store_category_products', [
                'slug' => $slug,
                'page' => 1,
            ]));
        }

        if (0 === $list->count()) {
            return new RedirectResponse($request->headers->get('referer'));
        }

        return new Response($this->twig->render('front/store/inStock/list.html.twig', [
            'currentCategory' => $category,
            'list' => $list
        ]));
    }

    /**
     * @Route("/store/{slug}/{id}", name="front_store_category_product_get", methods={"GET"})
     *
     * @param string $slug
     * @param string $id
     *
     * @return Response
     *
     * @throws \Twig_Error
     */
    public function categoryProduct(string $slug, string $id)
    {
        try {
            $category = $this->getCategoryBySlugUseCase->execute($slug);
        } catch (CategoryNotFoundException $x) {
            return new RedirectResponse($this->router->generate('front_store'));
        }

        try {
            $product = $this->getRegularProductUseCase->execute(ProductUuid::existing($id));
        } catch (ProductNotFoundException $x) {
            return new RedirectResponse($this->router->generate('front_store_category_products', [
                'slug' => $slug,
            ]));
        }

        return new Response($this->twig->render('front/store/inStock/view.html.twig', [
            'currentCategory' => $category,
            'product' => $product
        ]));
    }

    /**
     * @param string $current
     *
     * @return Response
     *
     * @throws \Twig_Error
     */
    public function categories(string $current = '')
    {
        $categories = $this->viewCategoriesListUseCase->execute();
        $productsTotals = $this->getProductsTotalsByCategoryUseCase->execute();

        return new Response($this->twig->render(
            'front/store/partials/categories.html.twig',
            compact('categories', 'current', 'productsTotals')
        ));
    }
}
