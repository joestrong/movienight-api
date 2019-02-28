<?php namespace App\Users;

use App\Users\Repositories\UserRepository;

class UserService
{
    protected $userRepo;
    
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }
    
    public function getByToken(string $token): User
    {
        return $this->userRepo->getByToken($token);
    }
}
