<?php namespace App\Users\Repositories;

use App\Users\User;

interface UserRepository
{
    public function getByToken(string $token): User;
}
