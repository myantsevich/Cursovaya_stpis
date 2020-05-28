<?php

namespace BelkinDom\Adapters\Database\Doctrine;

use BelkinDom\Adapters\Web\Security\Auth;
use BelkinDom\Store\User\UserNotFoundException;
use BelkinDom\Store\User\Users;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class AuthProvider implements UserProviderInterface
{
    /**
     * @var Users
     */
    private $repository;

    public function __construct(Users $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $username The username
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException
     */
    public function loadUserByUsername($username)
    {
        try {
            $user = $this->repository->findOneByEmail($username);
        } catch (UserNotFoundException $x) {
            throw new UsernameNotFoundException();
        }

        return new Auth($user->auth()->username(), $user->auth()->password());
    }

    /**
     * @param UserInterface $user
     *
     * @return UserInterface
     *
     * @throws UnsupportedUserException
     */
    public function refreshUser(UserInterface $user)
    {
        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return Auth::class === $class;
    }
}
