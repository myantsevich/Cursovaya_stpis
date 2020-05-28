<?php

namespace BelkinDom\Adapters\Web\Security;

use BelkinDom\Store\Security\AuthInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class Auth implements UserInterface, \Serializable, AuthInterface
{
    const DEFAULT_ROLES = ['ROLE_USER'];

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

    public function getUsername(): string
    {
        return $this->username;
    }

    public function username(): string
    {
        return $this->getUsername();
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        return self::DEFAULT_ROLES;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials()
    {
    }

    public function serialize()
    {
        return serialize([
            $this->username,
            $this->password,
        ]);
    }

    public function unserialize($serialized)
    {
        list (
            $this->username,
            $this->password,
        ) = unserialize($serialized);
    }
}
