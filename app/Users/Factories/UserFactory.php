<?php namespace App\Users\Factories;

use App\Users\User;

class UserFactory
{
    public static function fromState(array $state): User
    {
        $user = new User();

        $user->setId($state['id']);
        $user->setName($state['name']);
        $user->setEmail($state['email']);

        return $user;
    }
}
