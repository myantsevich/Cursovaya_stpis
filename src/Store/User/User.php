<?php

namespace BelkinDom\Store\User;

use BelkinDom\Store\Security\Auth;

class User
{
    /**
     * @var UserUuid
     */
    private $userUuid;

    /**
     * @var string
     */
    private $email;

    /**
     * @var Auth
     */
    private $auth;

    public function __construct(UserUuid $userUuid, string $email, Auth $auth)
    {
        $this->userUuid = $userUuid;
        $this->email = $email;
        $this->auth = $auth;
    }

    /**
     * @param string $email
     * @param Auth   $auth
     *
     * @return User
     */
    public static function generated(string $email, Auth $auth)
    {
        return new self(UserUuid::generated(), $email, $auth);
    }

    /**
     * @return UserUuid
     */
    public function userUuid(): UserUuid
    {
        return $this->userUuid;
    }

    /**
     * @return string
     */
    public function email(): string
    {
        return $this->email;
    }

    /**
     * @return Auth
     */
    public function auth(): Auth
    {
        return $this->auth;
    }
}
