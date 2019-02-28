<?php namespace App\Users\Repositories;

use App\Users\Models\User as UserModel;
use App\Users\User;

class EloquentUserRepository implements UserRepository
{
    protected $model;
    
    public function __construct(UserModel $userModel)
    {
        $this->model = $userModel;
    }
    
    public function getByToken(string $token): User
    {
        $userModel = $this->model
            ->where('api_token', $token)
            ->firstOrFail();
        
        $user = new User();
        $user->setName($userModel->name);
        $user->setEmail($userModel->email);
        
        return $user;
    }
}
