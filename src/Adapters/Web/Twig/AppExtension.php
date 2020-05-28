<?php

namespace BelkinDom\Adapters\Web\Twig;

use BelkinDom\Adapters\Web\View\MoneyFormatter\MoneyFormatter;
use BelkinDom\Store\Money\Money;
use BelkinDom\Store\Product\AbstractProduct;
use BelkinDom\Store\Product\Product;
use BelkinDom\Store\Product\RugStencilProduct;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;

class AppExtension extends AbstractExtension
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var MoneyFormatter
     */
    private $moneyFormatter;

    public function __construct(RouterInterface $router, MoneyFormatter $moneyFormatter)
    {
        $this->router = $router;
        $this->moneyFormatter = $moneyFormatter;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('money', [$this, 'formatMoney']),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('productPath', [$this, 'getProductPath']),
            new \Twig_SimpleFunction('adminProductPath', [$this, 'getAdminProductPath']),
            new \Twig_SimpleFunction('adminInstagramAuthPath', [$this, 'getAdminInstagramAuthPath']),
        ];
    }

    public function getProductPath(AbstractProduct $product)
    {
        if ($product instanceof Product) {
            return $this->router->generate('front_store_category_product_get', [
                'slug' => $product->category()->slug(),
                'id' => (string) $product->productUuid(),
            ]);
        }

        if ($product instanceof RugStencilProduct) {
            return $this->router->generate('front_store_rug_stencil_product_get', [
                'id' => (string) $product->productUuid(),
            ]);
        }

        return '';
    }

    public function getAdminProductPath(AbstractProduct $product)
    {
        if ($product instanceof Product) {
            return $this->router->generate('admin_products_regular_post', [
                'id' => (string) $product->productUuid(),
            ]);
        }

        if ($product instanceof RugStencilProduct) {
            return $this->router->generate('admin_products_rug_stencil_post', [
                'id' => (string) $product->productUuid(),
            ]);
        }

        return '';
    }

    public function getAdminInstagramAuthPath($clientId)
    {
        $callbackUrl = $this->router->generate('admin_config_instagram_auth', [], UrlGeneratorInterface::ABSOLUTE_URL);

        return sprintf(
            'https://api.instagram.com/oauth/authorize/?client_id=%s&redirect_uri=%s&response_type=code',
            $clientId,
            $callbackUrl
        );
    }

    public function formatMoney(Money $money)
    {
        return $this->moneyFormatter->format($money);
    }
}
