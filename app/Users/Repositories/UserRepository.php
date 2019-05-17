<?php namespace App\Users\Repositories;

use App\Users\User;

interface UserRepository
{
    public function getByToken(string $token): User;

    public function getByFacebookId(string $id): User;
    
    public function getTokenForUser(User $user): string;

    public function create(array $attributes): User;
}
