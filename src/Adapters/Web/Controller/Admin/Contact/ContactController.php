<?php

namespace BelkinDom\Adapters\Web\Controller\Admin\Contact;

use BelkinDom\Adapters\Web\Controller\FindTrait;
use BelkinDom\Adapters\Web\Form\Type\Contact\ContactType;
use BelkinDom\Store\Contact\ContactNotFoundException;
use BelkinDom\Store\Contact\ContactUuid;
use BelkinDom\UseCase\Contact\FindContactsUseCase;
use BelkinDom\UseCase\Contact\GetContactUseCase;
use BelkinDom\UseCase\Contact\UpdateContactUseCase;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface as Router;
use Twig\Environment as Twig;

class ContactController
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
     * @var FindContactsUseCase
     */
    private $findContactsUseCase;

    /**
     * @var GetContactUseCase
     */
    private $getContactUseCase;

    /**
     * @var UpdateContactUseCase
     */
    private $updateContactUseCase;

    public function __construct(
        Twig $twig,
        Router $router,
        FormFactoryInterface $formFactory,
        FindContactsUseCase $findContactsUseCase,
        GetContactUseCase $getContactUseCase,
        UpdateContactUseCase $updateContactUseCase
    ) {
        $this->twig = $twig;
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->findContactsUseCase = $findContactsUseCase;
        $this->getContactUseCase = $getContactUseCase;
        $this->updateContactUseCase = $updateContactUseCase;
    }

    /**
     * @Route("/admin/contact", name="admin_contact_cget")
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
            $list = $this->findContactsUseCase->execute($this->createFindRequest($request));
        } catch (OutOfRangeCurrentPageException $x) {
            return new RedirectResponse($this->router->generate('admin_contact_cget'));
        }

        return new Response($this->twig->render('admin/dashboard/contact/list.html.twig', [
            'list' => $list
        ]));
    }

    /**
     * @Route("/admin/contact/edit/{id}", name="admin_contact_post")
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
            $order = $this->getContactUseCase->execute(ContactUuid::existing($id));
        } catch (ContactNotFoundException $x) {
            return new RedirectResponse($this->router->generate('admin_contact_cget'));
        }

        $form = $this->formFactory->create(ContactType::class, $order, ['admin' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->updateContactUseCase->execute($order, $form->getData());

            $request->getSession()->getFlashBag()->add('success', 'contact.flashes.post.success');

            if ($form->get('saveAndReturn')->isClicked()) {
                return new RedirectResponse($this->router->generate('admin_contact_cget'));
            }
        }

        return new Response($this->twig->render('admin/dashboard/contact/form.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
