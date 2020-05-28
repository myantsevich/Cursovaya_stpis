<?php

namespace BelkinDom\Adapters\Web\Controller\Admin;

use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment as Twig;

class SecurityController
{
    /**
     * @var Twig
     */
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/admin/login", name="admin_login")
     *
     * @param AuthenticationUtils $authUtils
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function login(AuthenticationUtils $authUtils)
    {
        $error = $authUtils->getLastAuthenticationError();

        $lastUsername = $authUtils->getLastUsername();

        return new Response($this->twig->render('admin/security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]));
    }
}
