<?php

namespace BelkinDom\Adapters\Web\Controller\Admin\Faq;

use BelkinDom\Adapters\Web\Controller\FindTrait;
use BelkinDom\Adapters\Web\Form\Type\Faq\FaqType;
use BelkinDom\UseCase\Faq\GetFaqUseCase;
use BelkinDom\UseCase\Faq\UpdateFaqUseCase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface as Router;
use Twig\Environment as Twig;

class FaqController
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
     * @var GetFaqUseCase
     */
    private $getFaqUseCase;

    /**
     * @var UpdateFaqUseCase
     */
    private $updateFaqUseCase;

    public function __construct(
        Twig $twig,
        Router $router,
        FormFactoryInterface $formFactory,
        GetFaqUseCase $getFaqUseCase,
        UpdateFaqUseCase $updateFaqUseCase
    ) {
        $this->twig = $twig;
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->getFaqUseCase = $getFaqUseCase;
        $this->updateFaqUseCase = $updateFaqUseCase;
    }

    /**
     * @Route("/admin/faq", name="admin_faq")
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function faq(Request $request)
    {
        $faq = $this->getFaqUseCase->execute();
        $form = $this->formFactory->create(FaqType::class, $faq);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->updateFaqUseCase->execute($form->getData());
            $request->getSession()->getFlashBag()->add('success', 'faq.flashes.post.success');
        }

        return new Response($this->twig->render('admin/dashboard/faq/form.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
