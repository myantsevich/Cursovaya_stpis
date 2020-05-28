<?php

namespace BelkinDom\UseCase\Web;

use BelkinDom\Store\Web\Config;
use BelkinDom\Store\Web\Configs;

class UpdateInstagramAccessTokenUseCase
{
    /**
     * @var Configs
     */
    private $configs;

    /**
     * @var GetConfigUseCase
     */
    private $getConfigUseCase;

    public function __construct(Configs $configs,  GetConfigUseCase $getConfigUseCase)
    {
        $this->configs = $configs;
        $this->getConfigUseCase = $getConfigUseCase;
    }

    /**
     * @param string $accessToken
     */
    public function execute(string $accessToken)
    {
        $config = $this->getConfigUseCase->execute();
        $config->updateInstagramAccessToken($accessToken);
        $this->configs->update($config);
    }
}
