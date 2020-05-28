<?php

namespace BelkinDom\Adapters\Web\Controller\Admin\Product;

use BelkinDom\Adapters\Web\Controller\FindTrait;
use BelkinDom\Adapters\Web\Form\Type\Product\ProductType;
use BelkinDom\Store\Product\Product;
use BelkinDom\Store\Product\ProductNotFoundException;
use BelkinDom\Store\Product\ProductUuid;
use BelkinDom\UseCase\Product\Regular\CreateRegularProductUseCase;
use BelkinDom\UseCase\Product\Regular\FindRegularProductsUseCase;
use BelkinDom\UseCase\Product\Regular\GetRegularProductUseCase;
use BelkinDom\UseCase\Product\Regular\UpdateRegularProductUseCase;
use BelkinDom\UseCase\Product\ViewCategoriesListUseCase;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface as Router;
use Twig\Environment as Twig;

class RegularController
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
     * @var FindRegularProductsUseCase
     */
    private $findRegularProductsUseCase;

    /**
     * @var GetRegularProductUseCase
     */
    private $getRegularProductUseCase;

    /**
     * @var CreateRegularProductUseCase
     */
    private $createRegularProductUseCase;

    /**
     * @var UpdateRegularProductUseCase 
     */
    private $updateRegularProductUseCase;

    /**
     * @var ViewCategoriesListUseCase
     */
    private $viewCategoriesListUseCase;

    public function __construct(
        Twig $twig,
        Router $router,
        FormFactoryInterface $formFactory,
        FindRegularProductsUseCase $findRegularProductsUseCase,
        GetRegularProductUseCase $getRegularProductUseCase,
        CreateRegularProductUseCase $createRegularProductUseCase,
        UpdateRegularProductUseCase $updateRegularProductUseCase,
        ViewCategoriesListUseCase $viewCategoriesListUseCase
    ) {
        $this->twig = $twig;
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->findRegularProductsUseCase = $findRegularProductsUseCase;
        $this->getRegularProductUseCase = $getRegularProductUseCase;
        $this->createRegularProductUseCase = $createRegularProductUseCase;
        $this->updateRegularProductUseCase = $updateRegularProductUseCase;
        $this->viewCategoriesListUseCase = $viewCategoriesListUseCase;
    }

    /**
     * @Route("/admin/products/regular", name="admin_products_regular_cget")
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
            $list = $this->findRegularProductsUseCase->execute($this->createFindRequest($request));
        } catch (OutOfRangeCurrentPageException $x) {
            return new RedirectResponse($this->router->generate('admin_products_regular_cget'));
        }

        return new Response($this->twig->render('admin/dashboard/product/regular/list.html.twig', [
            'list' => $list
        ]));
    }

    /**
     * @Route("/admin/products/regular/add", name="admin_products_regular_put")
     *
     * @param Request $request
     * @return Response
     *
     * @throws \Exception
     */
    public function put(Request $request)
    {
        $form = $this->createForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $this->createRegularProductUseCase->execute($product);

            $request->getSession()->getFlashBag()->add('success', 'product.flashes.put.success');

            if ($form->get('baseProduct')->get('saveAndReturn')->isClicked()) {
                return new RedirectResponse($this->router->generate('admin_products_regular_cget'));
            } else {
                return new RedirectResponse($this->router->generate('admin_products_regular_post', ['id' => $product->productUuid()]));
            }
        }

        return new Response($this->twig->render('admin/dashboard/product/regular/new.html.twig', [
            'form' => $form->createView(),
        ]));
    }

    /**
     * @Route("/admin/products/regular/edit/{id}", name="admin_products_regular_post")
     *
     * @param string  $id
     * @param Request $request
     * @return Response
     *
     * @throws \Exception
     */
    public function post(string $id, Request $request)
    {
        try {
            $product = $this->getRegularProductUseCase->execute(ProductUuid::existing($id));
        } catch (ProductNotFoundException $x) {
            return new RedirectResponse($this->router->generate('admin_products_regular_cget'));
        }

        $form = $this->createForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->updateRegularProductUseCase->execute($product, $form->getData());

            $request->getSession()->getFlashBag()->add('success', 'product.flashes.post.success');

            if ($form->get('baseProduct')->get('saveAndReturn')->isClicked()) {
                return new RedirectResponse($this->router->generate('admin_products_regular_cget'));
            } else {
                return new RedirectResponse($this->router->generate('admin_products_regular_post', ['id' => $product->productUuid()]));
            }
        }

        return new Response($this->twig->render('admin/dashboard/product/regular/edit.html.twig', [
            'form' => $form->createView(),
        ]));
    }

    /**
     * @param Product|null $product
     *
     * @return FormInterface
     */
    private function createForm(Product $product = null): FormInterface
    {
        return $this->formFactory->create(ProductType::class, $product, [
            'categories' => $this->viewCategoriesListUseCase->execute(),
        ]);
    }
}
