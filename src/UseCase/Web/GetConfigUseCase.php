<?php

namespace BelkinDom\UseCase\Web;

use BelkinDom\Store\Web\Config;
use BelkinDom\Store\Web\ConfigNotFoundException;
use BelkinDom\Store\Web\Configs;

class GetConfigUseCase
{
    /**
     * @var Configs
     */
    private $configs;

    /**
     * @var CreateConfigUseCase
     */
    private $createConfigUseCase;

    public function __construct(Configs $configs, CreateConfigUseCase $createConfigUseCase)
    {
        $this->configs = $configs;
        $this->createConfigUseCase = $createConfigUseCase;
    }

    /**
     * @return Config
     */
    public function execute(): Config
    {
        try {
            $config = $this->configs->get();
        } catch (ConfigNotFoundException $x) {
            $config = $this->createConfigUseCase->execute();
        }

        return $config;
    }
}
