<?php namespace App\Users\Repositories;

use App\Movies\Movie;
use App\Users\User;

interface UserRepository
{
    public function getByToken(string $token): User;

    public function getByFacebookId(string $id): User;
    
    public function getTokenForUser(User $user): string;

    public function create(array $attributes): User;

    public function markMovieSeen(User $user, Movie $movie): void;
}
