<?php

namespace BelkinDom\Adapters\Database\Doctrine;

use BelkinDom\Store\User\User;
use BelkinDom\Store\User\UserNotFoundException;
use BelkinDom\Store\User\Users;
use Doctrine\Common\Persistence\ObjectManager;

final class UsersRepository implements Users
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param string $email
     *
     * @return User
     */
    public function findOneByEmail(string $email): User
    {
        $user = $this->objectManager->getRepository(User::class)->findOneBy(['email' => $email]);

        if (!$user instanceof User) {
            throw new UserNotFoundException($email);
        }

        return $user;
    }

    /**
     * @param User $user
     */
    public function save(User $user)
    {
        $this->objectManager->persist($user);
        $this->objectManager->flush();
    }
}
