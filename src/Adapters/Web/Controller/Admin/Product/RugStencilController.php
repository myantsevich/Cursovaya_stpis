<?php

namespace BelkinDom\Adapters\Web\Controller\Admin\Product;

use BelkinDom\Adapters\Web\Controller\FindTrait;
use BelkinDom\Adapters\Web\Form\Type\Product\RugStencilProductType;
use BelkinDom\Store\Product\RugStencilProduct;
use BelkinDom\Store\Product\ProductNotFoundException;
use BelkinDom\Store\Product\ProductUuid;
use BelkinDom\UseCase\Product\RugStencil\GetRugStencilProductUseCase;
use BelkinDom\UseCase\Product\RugStencil\CreateRugStencilProductUseCase;
use BelkinDom\UseCase\Product\RugStencil\FindRugStencilProductsUseCase;
use BelkinDom\UseCase\Product\RugStencil\UpdateRugStencilProductUseCase;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface as Router;
use Twig\Environment as Twig;

class RugStencilController
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
     * @var FindRugStencilProductsUseCase
     */
    private $findRugStencilProductsUseCase;

    /**
     * @var CreateRugStencilProductUseCase
     */
    private $createRugStencilProductUseCase;

    /**
     * @var GetRugStencilProductUseCase
     */
    private $getRugStencilProductUseCase;

    /**
     * @var UpdateRugStencilProductUseCase
     */
    private $updateRugStencilProductUseCase;

    public function __construct(
        Twig $twig,
        Router $router,
        FormFactoryInterface $formFactory,
        FindRugStencilProductsUseCase $findRugStencilProductsUseCase,
        CreateRugStencilProductUseCase $createRugStencilProductUseCase,
        GetRugStencilProductUseCase $getRugStencilProductUseCase,
        UpdateRugStencilProductUseCase $updateRugStencilProductUseCase
    ) {
        $this->twig = $twig;
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->findRugStencilProductsUseCase = $findRugStencilProductsUseCase;
        $this->createRugStencilProductUseCase = $createRugStencilProductUseCase;
        $this->getRugStencilProductUseCase = $getRugStencilProductUseCase;
        $this->updateRugStencilProductUseCase = $updateRugStencilProductUseCase;
    }

    /**
     * @Route("/admin/products/rug-stencil", name="admin_products_rug_stencil_cget")
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function list(Request $request)
    {
        try {
            $list = $this->findRugStencilProductsUseCase->execute($this->createFindRequest($request));
        } catch (OutOfRangeCurrentPageException $x) {
            return new RedirectResponse($this->router->generate('admin_products_rug_stencil_cget'));
        }

        return new Response($this->twig->render('admin/dashboard/product/rugStencil/list.html.twig', [
            'list' => $list
        ]));
    }

    /**
     * @Route("/admin/products/rug-stencil/add", name="admin_products_rug_stencil_put")
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
            $this->createRugStencilProductUseCase->execute($product);

            $request->getSession()->getFlashBag()->add('success', 'product.flashes.put.success');

            if ($form->get('baseProduct')->get('saveAndReturn')->isClicked()) {
                return new RedirectResponse($this->router->generate('admin_products_rug_stencil_cget'));
            } else {
                return new RedirectResponse($this->router->generate('admin_products_rug_stencil_post', ['id' => $product->productUuid()]));
            }
        }

        return new Response($this->twig->render('admin/dashboard/product/rugStencil/new.html.twig', [
            'form' => $form->createView(),
        ]));
    }

    /**
     * @Route("/admin/products/rug-stencil/edit/{id}", name="admin_products_rug_stencil_post")
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
            $product = $this->getRugStencilProductUseCase->execute(ProductUuid::existing($id));
        } catch (ProductNotFoundException $x) {
            return new RedirectResponse($this->router->generate('admin_products_rug_stencil_cget'));
        }

        $form = $this->createForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->updateRugStencilProductUseCase->execute($product, $form->getData());

            $request->getSession()->getFlashBag()->add('success', 'product.flashes.post.success');

            if ($form->get('baseProduct')->get('saveAndReturn')->isClicked()) {
                return new RedirectResponse($this->router->generate('admin_products_rug_stencil_cget'));
            } else {
                return new RedirectResponse($this->router->generate('admin_products_rug_stencil_post', ['id' => $product->productUuid()]));
            }
        }

        return new Response($this->twig->render('admin/dashboard/product/rugStencil/edit.html.twig', [
            'form' => $form->createView(),
        ]));
    }

    /**
     * @param RugStencilProduct|null $product
     *
     * @return FormInterface
     */
    private function createForm(RugStencilProduct $product = null): FormInterface
    {
        return $this->formFactory->create(RugStencilProductType::class, $product);
    }
}
