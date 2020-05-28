<?php

namespace BelkinDom\Adapters\Web\Controller\Admin\Order;

use BelkinDom\Adapters\Web\Controller\FindTrait;
use BelkinDom\Store\Order\OrderNotFoundException;
use BelkinDom\Store\Order\OrderUuid;
use BelkinDom\UseCase\Order\FindOrdersUseCase;
use BelkinDom\UseCase\Order\GetOrderUseCase;
use BelkinDom\UseCase\Order\UpdateOrderUseCase;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface as Router;
use Twig\Environment as Twig;

class OrderController
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
     * @var FindOrdersUseCase
     */
    private $findOrdersUseCase;

    /**
     * @var GetOrderUseCase
     */
    private $getOrderUseCase;

    /**
     * @var UpdateOrderUseCase
     */
    private $updateOrderUseCase;

    public function __construct(
        Twig $twig,
        Router $router,
        FormFactoryInterface $formFactory,
        FindOrdersUseCase $findOrdersUseCase,
        GetOrderUseCase $getOrderUseCase,
        UpdateOrderUseCase $updateOrderUseCase
    ) {
        $this->twig = $twig;
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->findOrdersUseCase = $findOrdersUseCase;
        $this->getOrderUseCase = $getOrderUseCase;
        $this->updateOrderUseCase = $updateOrderUseCase;
    }

    /**
     * @Route("/admin/order", name="admin_order_cget")
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
            $list = $this->findOrdersUseCase->execute($this->createFindRequest($request));
        } catch (OutOfRangeCurrentPageException $x) {
            return new RedirectResponse($this->router->generate('admin_order_cget'));
        }

        return new Response($this->twig->render('admin/dashboard/order/list.html.twig', [
            'list' => $list
        ]));
    }

    /**
     * @Route("/admin/order/{id}", name="admin_order_get")
     *
     * @param string $id
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function get(string $id)
    {
        try {
            $order = $this->getOrderUseCase->execute(OrderUuid::existing($id));
        } catch (OrderNotFoundException $x) {
            return new RedirectResponse($this->router->generate('admin_order_cget'));
        }
        return new Response($this->twig->render('admin/dashboard/order/view.html.twig', [
            'order' => $order
        ]));
    }
}
