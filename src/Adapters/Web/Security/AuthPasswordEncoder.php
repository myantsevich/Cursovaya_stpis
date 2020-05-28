<?php

namespace BelkinDom\Adapters\Web\Security;

use BelkinDom\Store\Security\AuthInterface;
use BelkinDom\Store\Security\AuthPasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthPasswordEncoder implements AuthPasswordEncoderInterface
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function encode(AuthInterface $auth, $plainPassword): string
    {
        /** @var Auth $auth */
        return $this->passwordEncoder->encodePassword(new Auth($auth->username(), ''), $plainPassword);
    }
}
