<?php

namespace BelkinDom\Store\Security;

interface AuthPasswordEncoderInterface
{
    /**
     * @param AuthInterface $auth
     * @param $plainPassword
     *
     * @return string Encoded password
     */
    public function encode(AuthInterface $auth, $plainPassword): string;
}
