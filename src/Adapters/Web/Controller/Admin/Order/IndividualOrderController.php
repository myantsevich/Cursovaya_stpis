<?php

namespace BelkinDom\Adapters\Web\Controller\Admin\Order;

use BelkinDom\Adapters\Web\Controller\FindTrait;
use BelkinDom\Adapters\Web\Form\Type\Order\IndividualOrderType;
use BelkinDom\Store\Order\OrderNotFoundException;
use BelkinDom\Store\Order\OrderUuid;
use BelkinDom\UseCase\Order\FindIndividualOrdersUseCase;
use BelkinDom\UseCase\Order\GetIndividualOrderUseCase;
use BelkinDom\UseCase\Order\UpdateIndividualOrderUseCase;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface as Router;
use Twig\Environment as Twig;

class IndividualOrderController
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
     * @var FindIndividualOrdersUseCase
     */
    private $findIndividualOrdersUseCase;

    /**
     * @var GetIndividualOrderUseCase
     */
    private $getIndividualOrderUseCase;

    /**
     * @var UpdateIndividualOrderUseCase
     */
    private $updateIndividualOrderUseCase;

    public function __construct(
        Twig $twig,
        Router $router,
        FormFactoryInterface $formFactory,
        FindIndividualOrdersUseCase $findIndividualOrdersUseCase,
        GetIndividualOrderUseCase $getIndividualOrderUseCase,
        UpdateIndividualOrderUseCase $updateIndividualOrderUseCase
    ) {
        $this->twig = $twig;
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->findIndividualOrdersUseCase = $findIndividualOrdersUseCase;
        $this->getIndividualOrderUseCase = $getIndividualOrderUseCase;
        $this->updateIndividualOrderUseCase = $updateIndividualOrderUseCase;
    }

    /**
     * @Route("/admin/order/individual", name="admin_order_individual_cget")
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
            $list = $this->findIndividualOrdersUseCase->execute($this->createFindRequest($request));
        } catch (OutOfRangeCurrentPageException $x) {
            return new RedirectResponse($this->router->generate('admin_order_individual_cget'));
        }

        return new Response($this->twig->render('admin/dashboard/order/individual/list.html.twig', [
            'list' => $list
        ]));
    }

    /**
     * @Route("/admin/order/individual/edit/{id}", name="admin_order_individual_post")
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
            $order = $this->getIndividualOrderUseCase->execute(OrderUuid::existing($id));
        } catch (OrderNotFoundException $x) {
            return new RedirectResponse($this->router->generate('admin_order_individual_cget'));
        }

        $form = $this->formFactory->create(IndividualOrderType::class, $order, ['admin' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->updateIndividualOrderUseCase->execute($order, $form->getData());

            $request->getSession()->getFlashBag()->add('success', 'order.individual.flashes.post.success');

            if ($form->get('saveAndReturn')->isClicked()) {
                return new RedirectResponse($this->router->generate('admin_order_individual_cget'));
            }
        }

        return new Response($this->twig->render('admin/dashboard/order/individual/form.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
