<?php

namespace BelkinDom\Adapters\Web\Controller\Front;

use BelkinDom\Adapters\Web\Controller\FindTrait;
use BelkinDom\Adapters\Web\Form\Type\Order\CartOrderType;
use BelkinDom\Adapters\Web\Menu\HeaderMenu;
use BelkinDom\Store\Product\ProductNotFoundException;
use BelkinDom\Store\Product\ProductUuid;
use BelkinDom\UseCase\Cart\AddProductToCartUseCase;
use BelkinDom\UseCase\Cart\GetUserCartUseCase;
use BelkinDom\UseCase\Cart\RemoveProductFromCartUseCase;
use BelkinDom\UseCase\Cart\ResetCartUseCase;
use BelkinDom\UseCase\Order\CreateOrderUseCase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface as Router;
use Twig\Environment as Twig;

class CartController
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
     * @var GetUserCartUseCase
     */
    private $getUserCartUseCase;

    /**
     * @var AddProductToCartUseCase
     */
    private $addProductToCartUseCase;

    /**
     * @var RemoveProductFromCartUseCase
     */
    private $removeProductFromCartUseCase;

    /**
     * @var CreateOrderUseCase
     */
    private $createOrderUseCase;

    /**
     * @var ResetCartUseCase
     */
    private $resetCartUseCase;

    public function __construct(
        Twig $twig,
        Router $router,
        FormFactoryInterface $formFactory,
        HeaderMenu $headerMenu,
        GetUserCartUseCase $getUserCartUseCase,
        AddProductToCartUseCase $addProductToCartUseCase,
        RemoveProductFromCartUseCase $removeProductFromCartUseCase,
        CreateOrderUseCase $createOrderUseCase,
        ResetCartUseCase $resetCartUseCase
    ) {
        $this->twig = $twig;
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->headerMenu = $headerMenu;
        $this->headerMenu->updateCurrentItem(HeaderMenu::CART);

        $this->getUserCartUseCase = $getUserCartUseCase;
        $this->addProductToCartUseCase = $addProductToCartUseCase;
        $this->removeProductFromCartUseCase = $removeProductFromCartUseCase;
        $this->createOrderUseCase = $createOrderUseCase;
        $this->resetCartUseCase = $resetCartUseCase;
    }

    /**
     * @Route("/cart", name="front_cart", methods={"GET", "POST"})
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Twig_Error
     */
    public function cart(Request $request)
    {
        $cart = $this->getUserCartUseCase->execute();
        $form = $this->formFactory->create(CartOrderType::class, $cart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->createOrderUseCase->execute($form->getData());
            $this->resetCartUseCase->execute($cart);
            $request->getSession()->getFlashBag()->add('success', 'flash.message.product_reply');
        }

        return new Response($this->twig->render("front/cart/view.html.twig", [
            'cart' => $cart,
            'orderForm' => $form->createView(),
        ]));
    }

    /**
     * @Route("/cart/add/{id}", name="front_cart_product_put", methods={"GET"})
     *
     * @param string $id
     * @param Request $request
     *
     * @return Response
     */
    public function addProduct(string $id, Request $request)
    {
        $referer = $request->headers->get('referer');

        try {
            $cart = $this->getUserCartUseCase->execute();
            $this->addProductToCartUseCase->execute(ProductUuid::existing($id), $cart);
            $request->getSession()->getFlashBag()->add('success', 'flash.message.added');
        } catch (ProductNotFoundException $x) {
            return new RedirectResponse($referer);
        }

        return new RedirectResponse($referer);
    }

    /**
     * @Route("/cart/remove/{id}", name="front_cart_product_remove", methods={"GET"})
     *
     * @param string $id
     * @param Request $request
     *
     * @return Response
     */
    public function removeProduct(string $id, Request $request)
    {
        $referer = $request->headers->get('referer');

        try {
            $cart = $this->getUserCartUseCase->execute();
            $this->removeProductFromCartUseCase->execute(ProductUuid::existing($id), $cart);
        } catch (ProductNotFoundException $x) {
            return new RedirectResponse($referer);
        }

        return new RedirectResponse($referer);
    }
}
