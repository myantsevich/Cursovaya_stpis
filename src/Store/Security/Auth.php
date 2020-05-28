<?php

namespace BelkinDom\Store\Security;

class Auth implements AuthInterface
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @param string $username
     *
     * @return Auth
     */
    public static function generated(string $username): Auth
    {
        return new self($username, "");
    }

    /**
     * @param AuthInterface $auth
     * @param string        $newPassword
     *
     * @return Auth
     */
    public static function updatePassword(AuthInterface $auth, string $newPassword): Auth
    {
        return new self($auth->username(), $newPassword);
    }

    /**
     * @return string
     */
    public function username(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function password(): string
    {
        return $this->password;
    }
}
