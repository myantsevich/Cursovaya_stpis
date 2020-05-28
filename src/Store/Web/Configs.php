<?php

namespace BelkinDom\Store\Web;

interface Configs
{
    /**
     * @return Config
     *
     * @throws ConfigNotFoundException
     */
    public function get(): Config;

    /**
     * @param Config $config
     */
    public function save(Config $config);

    /**
     * @param Config $config
     */
    public function update(Config $config);
}
