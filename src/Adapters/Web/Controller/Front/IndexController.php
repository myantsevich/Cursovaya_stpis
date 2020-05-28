<?php

namespace BelkinDom\Adapters\Web\Controller\Front;

use BelkinDom\Adapters\Web\Controller\FindTrait;
use BelkinDom\Adapters\Web\Form\Type\Contact\ContactType;
use BelkinDom\Adapters\Web\Menu\HeaderMenu;
use BelkinDom\DTO\Request\Common\Find;
use BelkinDom\UseCase\Cart\GetUserCartUseCase;
use BelkinDom\UseCase\Contact\CreateContactUseCase;
use BelkinDom\UseCase\Faq\GetFaqUseCase;
use BelkinDom\UseCase\Partner\FindPartnersUseCase;
use BelkinDom\UseCase\Product\FindAllProductsUseCase;
use BelkinDom\UseCase\Review\FindReviewsUseCase;
use BelkinDom\UseCase\Web\GetConfigUseCase;
use BelkinDom\UseCase\Web\GetInstagramRecentPostsUseCase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface as Router;
use Twig\Environment as Twig;

class IndexController
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
     * @var GetFaqUseCase
     */
    private $getFaqUseCase;

    /**
     * @var CreateContactUseCase
     */
    private $createContactUseCase;

    /**
     * @var FindReviewsUseCase
     */
    private $findReviewsUseCase;

    /**
     * @var FindPartnersUseCase
     */
    private $findPartnersUseCase;

    /**
     * @var GetUserCartUseCase
     */
    private $getUserCartUseCase;

    /**
     * @var GetConfigUseCase
     */
    private $getConfigUseCase;

    /**
     * @var FindAllProductsUseCase
     */
    private $findAllProductsUseCase;

    /**
     * @var GetInstagramRecentPostsUseCase
     */
    private $getInstagramRecentPostsUseCase;

    /**
     * @var string[]
     */
    private $availableLocales;

    public function __construct(
        Twig $twig,
        Router $router,
        FormFactoryInterface $formFactory,
        HeaderMenu $headerMenu,
        GetFaqUseCase $getFaqUseCase,
        CreateContactUseCase $createContactUseCase,
        FindReviewsUseCase $findReviewsUseCase,
        FindPartnersUseCase $findPartnersUseCase,
        GetUserCartUseCase $getUserCartUseCase,
        GetConfigUseCase $getConfigUseCase,
        FindAllProductsUseCase $findAllProductsUseCase,
        GetInstagramRecentPostsUseCase $getInstagramRecentPostsUseCase,
        array $availableLocales
    ) {
        $this->twig = $twig;
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->headerMenu = $headerMenu;
        $this->getFaqUseCase = $getFaqUseCase;
        $this->createContactUseCase = $createContactUseCase;
        $this->findReviewsUseCase = $findReviewsUseCase;
        $this->findPartnersUseCase = $findPartnersUseCase;
        $this->getUserCartUseCase = $getUserCartUseCase;
        $this->getConfigUseCase = $getConfigUseCase;
        $this->findAllProductsUseCase = $findAllProductsUseCase;
        $this->getInstagramRecentPostsUseCase = $getInstagramRecentPostsUseCase;
        $this->availableLocales = $availableLocales;
    }

    /**
     * @Route("/", name="front_index", methods={"GET"})
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function index()
    {
        $this->headerMenu->updateCurrentItem(HeaderMenu::ABOUT);
        $config = $this->getConfigUseCase->execute();

        $page = 1;
        $lastProductsLimit = 4;
        $lastProducts = $this->findAllProductsUseCase->execute(new Find($page, $lastProductsLimit));

        $recentInstagramPostsLimit = 4;
        $instagramRecentPosts = $this->getInstagramRecentPostsUseCase->execute($recentInstagramPostsLimit);

        return new Response($this->twig->render('front/page/index.html.twig', [
            'config' => $config,
            'lastProducts' => $lastProducts,
            'instagramRecentPosts' => $instagramRecentPosts,
        ]));
    }

    /**
     * @Route("/faq", name="front_faq", methods={"GET"})
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function faq()
    {
        $this->headerMenu->updateCurrentItem(HeaderMenu::FAQ);
        $faq = $this->getFaqUseCase->execute();

        return new Response($this->twig->render('front/page/faq.html.twig', compact('faq')));
    }

    /**
     * @Route("/contact", name="front_contact", methods={"GET", "POST"})
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function contact(Request $request)
    {
        $this->headerMenu->updateCurrentItem(HeaderMenu::CONTACT);
        $form = $this->formFactory->create(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->createContactUseCase->execute($form->getData());
            $request->getSession()->getFlashBag()->add('success', 'flash.message.reply');

            return new RedirectResponse($this->router->generate('front_contact'));
        }

        return new Response($this->twig->render('front/page/contact.html.twig', [
            'form' => $form->createView()
        ]));
    }

    /**
     * @Route("/reviews", name="front_reviews", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function reviews(Request $request)
    {
        $this->headerMenu->updateCurrentItem(HeaderMenu::REVIEWS);
        $reviews = $this->findReviewsUseCase->execute($this->createFindRequest($request));

        return new Response($this->twig->render('front/page/reviews.html.twig', compact('reviews')));
    }

    /**
     * @Route("/partners", name="front_partners", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function partners(Request $request)
    {
        $this->headerMenu->updateCurrentItem(HeaderMenu::PARTNERS);
        $partners = $this->findPartnersUseCase->execute($this->createFindRequest($request));

        return new Response($this->twig->render('front/page/partners.html.twig', compact('partners')));
    }

    /**
     * @Route("/change-lang/{locale}", name="change_locale", methods={"GET"})
     *
     * @param string $locale
     * @param Request $request
     *
     * @return Response
     */
    public function changeLanguage(string $locale, Request $request): Response
    {
        if ($request->hasSession() && in_array($locale, $this->availableLocales)) {
            $request->attributes->set('_locale', null);
            $request->getSession()->set('_locale', $locale);
        }

        if ($request->headers->has('referer')) {
            $redirectTo = $request->headers->get('referer');
        } else {
            $redirectTo = $this->router->generate('front_index');
        }

        return new RedirectResponse($redirectTo);
    }

    /**
     * @return Response
     *
     * @throws \Twig_Error
     */
    public function header()
    {
        $cart = $this->getUserCartUseCase->execute();

        return new Response($this->twig->render('front/partials/header.html.twig', [
            'cart' => $cart,
            'headerMenu' => $this->headerMenu,
            'locales' => $this->availableLocales,
        ]));
    }

    /**
     * @return Response
     *
     * @throws \Twig_Error
     */
    public function footer()
    {
        $config = $this->getConfigUseCase->execute();

        return new Response($this->twig->render('front/partials/footer.html.twig', [
            'instagramUrl' => $config->instagramUrl()
        ]));
    }
}
