<?php

namespace BelkinDom\Adapters\Web\Controller\Admin\Partner;

use BelkinDom\Adapters\Web\Controller\FindTrait;
use BelkinDom\Adapters\Web\Form\Type\Partner\PartnerType;
use BelkinDom\Store\Partner\Partner;
use BelkinDom\Store\Partner\PartnerNotFoundException;
use BelkinDom\Store\Partner\PartnerUuid;
use BelkinDom\UseCase\Partner\CreatePartnerUseCase;
use BelkinDom\UseCase\Partner\FindPartnersUseCase;
use BelkinDom\UseCase\Partner\GetPartnerUseCase;
use BelkinDom\UseCase\Partner\UpdatePartnerUseCase;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface as Router;
use Twig\Environment as Twig;

class PartnerController
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
     * @var FindPartnersUseCase
     */
    private $findPartnersUseCase;

    /**
     * @var CreatePartnerUseCase
     */
    private $createPartnerUseCase;

    /**
     * @var GetPartnerUseCase
     */
    private $getPartnerUseCase;

    /**
     * @var UpdatePartnerUseCase
     */
    private $updatePartnerUseCase;

    public function __construct(
        Twig $twig,
        Router $router,
        FormFactoryInterface $formFactory,
        FindPartnersUseCase $findPartnersUseCase,
        CreatePartnerUseCase $createPartnerUseCase,
        GetPartnerUseCase $getPartnerUseCase,
        UpdatePartnerUseCase $updatePartnerUseCase
    ) {
        $this->twig = $twig;
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->findPartnersUseCase = $findPartnersUseCase;
        $this->createPartnerUseCase = $createPartnerUseCase;
        $this->getPartnerUseCase = $getPartnerUseCase;
        $this->updatePartnerUseCase = $updatePartnerUseCase;
    }

    /**
     * @Route("/admin/partners", name="admin_partners_cget")
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
            $list = $this->findPartnersUseCase->execute($this->createFindRequest($request));
        } catch (OutOfRangeCurrentPageException $x) {
            return new RedirectResponse($this->router->generate('admin_partners_cget'));
        }

        return new Response($this->twig->render('admin/dashboard/partners/list.html.twig', [
            'list' => $list
        ]));
    }

    /**
     * @Route("/admin/partners/add", name="admin_partners_put")
     *
     * @param Request $request
     * @return Response
     *
     * @throws \Exception
     */
    public function put(Request $request)
    {
        $form = $this->formFactory->create(PartnerType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Partner $partner */
            $partner = $form->getData();
            $this->createPartnerUseCase->execute($partner);

            $request->getSession()->getFlashBag()->add('success', 'partner.flashes.put.success');

            if ($form->get('saveAndReturn')->isClicked()) {
                return new RedirectResponse($this->router->generate('admin_partners_cget'));
            } else {
                return new RedirectResponse($this->router->generate('admin_partners_post', ['id' => $partner->partnerUuid()]));
            }
        }

        return new Response($this->twig->render('admin/dashboard/partners/new.html.twig', [
            'form' => $form->createView(),
        ]));
    }

    /**
     * @Route("/admin/partners/edit/{id}", name="admin_partners_post")
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
            $partner = $this->getPartnerUseCase->execute(PartnerUuid::existing($id));
        } catch (PartnerNotFoundException $x) {
            return new RedirectResponse($this->router->generate('admin_partners_cget'));
        }

        $form = $this->formFactory->create(PartnerType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->updatePartnerUseCase->execute($partner, $form->getData());

            $request->getSession()->getFlashBag()->add('success', 'partner.flashes.post.success');

            if ($form->get('saveAndReturn')->isClicked()) {
                return new RedirectResponse($this->router->generate('admin_partners_cget'));
            }
        }

        return new Response($this->twig->render('admin/dashboard/partners/edit.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
