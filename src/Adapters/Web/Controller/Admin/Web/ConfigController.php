<?php

namespace BelkinDom\Adapters\Web\Controller\Admin\Web;

use BelkinDom\Adapters\Instagram\Client as Instagram;
use BelkinDom\Adapters\Web\Controller\FindTrait;
use BelkinDom\Adapters\Web\Form\Type\Web\ConfigType;
use BelkinDom\UseCase\Web\GetConfigUseCase;
use BelkinDom\UseCase\Web\UpdateConfigUseCase;
use BelkinDom\UseCase\Web\UpdateInstagramAccessTokenUseCase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface as Router;
use Twig\Environment as Twig;

class ConfigController
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
     * @var GetConfigUseCase
     */
    private $getConfigUseCase;

    /**
     * @var UpdateConfigUseCase
     */
    private $updateConfigUseCase;

    /**
     * @var UpdateInstagramAccessTokenUseCase
     */
    private $updateInstagramAccessTokenUseCase;

    /**
     * @var Instagram
     */
    private $instagram;

    public function __construct(
        Twig $twig,
        Router $router,
        FormFactoryInterface $formFactory,
        GetConfigUseCase $getConfigUseCase,
        UpdateConfigUseCase $updateConfigUseCase,
        UpdateInstagramAccessTokenUseCase $updateInstagramAccessTokenUseCase,
        Instagram $instagram
    ) {
        $this->twig = $twig;
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->getConfigUseCase = $getConfigUseCase;
        $this->updateConfigUseCase = $updateConfigUseCase;
        $this->updateInstagramAccessTokenUseCase = $updateInstagramAccessTokenUseCase;
        $this->instagram = $instagram;
    }

    /**
     * @Route("/admin/config", name="admin_config")
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function config(Request $request)
    {
        $config = $this->getConfigUseCase->execute();
        $form = $this->formFactory->create(ConfigType::class, $config);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->updateConfigUseCase->execute($form->getData());
        }

        return new Response($this->twig->render('admin/dashboard/config/form.html.twig', [
            'form' => $form->createView(),
        ]));
    }

    /**
     * @Route("/admin/config/instagram_auth", name="admin_config_instagram_auth")
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function instagramAuth(Request $request)
    {
        $redirectResponse = new RedirectResponse($this->router->generate('admin_config'));

        try {
            $code = $request->get('code');

            if (!$code) {
                throw new \RuntimeException($request->get('error_description', 'config.flashes.instagram_access_token.code_error'));
            }

            $accessToken = $this->instagram->getOAuthToken($code);
            $this->updateInstagramAccessTokenUseCase->execute($accessToken);
        } catch (\Exception $x) {
            $request->getSession()->getFlashBag()->add('danger', $x->getMessage());

            return $redirectResponse;
        }

        $request->getSession()->getFlashBag()->add('success', 'config.flashes.instagram_access_token.success');

        return $redirectResponse;
    }
}
