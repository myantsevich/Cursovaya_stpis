<?php

namespace BelkinDom\Adapters\Web\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface as Router;
use Twig\Environment as Twig;

class IndexController
{
    /**
     * @var Twig
     */
    private $twig;

    /**
     * @var Router
     */
    private $router;

    public function __construct(Twig $twig, Router $router)
    {
        $this->twig = $twig;
        $this->router = $router;
    }

    /**
     * @Route("/admin", name="admin_dashboard", methods={"GET"})
     */
    public function home()
    {
        return new RedirectResponse($this->router->generate('admin_order_cget'));
    }
}
