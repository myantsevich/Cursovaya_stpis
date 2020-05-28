<?php

namespace BelkinDom\Store\User;

interface Users
{
    /**
     * @param string $email
     *
     * @return User
     *
     * @throws UserNotFoundException
     */
    public function findOneByEmail(string $email): User;

    /**
     * @param User $user
     */
    public function save(User $user);
}
