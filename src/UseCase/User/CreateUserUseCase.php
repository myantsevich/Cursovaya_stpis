<?php

namespace BelkinDom\UseCase\User;

use BelkinDom\Store\Security\Auth;
use BelkinDom\Store\Security\AuthPasswordEncoderInterface;
use BelkinDom\Store\User\NonUniqueUserException;
use BelkinDom\Store\User\User;
use BelkinDom\Store\User\UserNotFoundException;
use BelkinDom\Store\User\Users;

class CreateUserUseCase
{
    /**
     * @var AuthPasswordEncoderInterface
     */
    private $authPasswordEncoder;

    /**
     * @var Users
     */
    private $users;

    public function __construct(AuthPasswordEncoderInterface $passwordEncoder, Users $users)
    {
        $this->authPasswordEncoder = $passwordEncoder;
        $this->users = $users;
    }

    /**
     * @param string $username
     * @param string $plainPassword
     *
     * @throws NonUniqueUserException
     */
    public function execute(string $username, string $plainPassword)
    {
        try {
            $this->users->findOneByEmail($username);

            throw new NonUniqueUserException($username);
        } catch (UserNotFoundException $x) {
        }

        $auth = Auth::generated($username);
        $encodedPassword = $this->authPasswordEncoder->encode($auth, $plainPassword);

        $user = User::generated($username, Auth::updatePassword($auth, $encodedPassword));

        $this->users->save($user);
    }
}
