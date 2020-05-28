<?php

namespace BelkinDom\UseCase\Web;

use BelkinDom\Store\Web\Config;
use BelkinDom\Store\Web\Configs;
use BelkinDom\Store\Web\ConfigUuid;

class CreateConfigUseCase
{
    /**
     * @var Configs
     */
    private $configs;

    public function __construct(Configs $configs)
    {
        $this->configs = $configs;
    }

    /**
     * @return Config
     */
    public function execute(): Config
    {
        $config = new Config(ConfigUuid::generated(), '', '', false, '', '');
        $this->configs->save($config);

        return $config;
    }
}
