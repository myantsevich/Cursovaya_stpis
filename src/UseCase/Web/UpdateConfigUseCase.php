<?php

namespace BelkinDom\UseCase\Web;

use BelkinDom\Store\Web\Config;
use BelkinDom\Store\Web\Configs;

class UpdateConfigUseCase
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
     * @param Config $config
     */
    public function execute(Config $config)
    {
        $this->configs->update($config);
    }
}
