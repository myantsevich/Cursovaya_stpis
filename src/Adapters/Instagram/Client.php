<?php

namespace BelkinDom\Adapters\Instagram;

use BelkinDom\Adapters\Instagram\Exception\InstagramAuthException;
use BelkinDom\UseCase\Web\GetConfigUseCase;
use MetzWeb\Instagram\Instagram;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface as Router;

class Client
{
    /**
     * @var Instagram
     */
    private $ig;

    public function __construct(Router $router, GetConfigUseCase $getConfigUseCase)
    {
        $config = $getConfigUseCase->execute();

        $this->ig = new Instagram([
            'apiKey'      => $config->instagramClientId(),
            'apiSecret'   => $config->instagramClientSecret(),
            'apiCallback' => $router->generate('admin_config_instagram_auth', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        if ($config->instagramAccessToken()) {
            $this->ig->setAccessToken($config->instagramAccessToken());
        }
    }

    /**
     * @param int $limit
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function getRecentMedia(int $limit)
    {
        return $this->ig->getUserMedia('self', $limit);
    }

    /**
     * @param string $code
     *
     * @return string
     *
     * @throws InstagramAuthException
     */
    public function getOAuthToken(string $code)
    {
        $data = $this->ig->getOAuthToken($code);

        if (property_exists($data, 'error_message')) {
            throw new InstagramAuthException($data->error_message);
        }

        if (property_exists($data, 'access_token')) {
            return $data->access_token;
        }

        throw new InstagramAuthException('Undefined Auth Response (there is no error_message property nor access_token)');
    }
}
