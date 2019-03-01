<?php namespace App\Users\Repositories;

use App\Users\Factories\UserFactory;
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

        return UserFactory::fromState($userModel->toArray());
    }

    public function getByFacebookId(string $id): User
    {
        $userModel = $this->model
            ->where('facebook_id', $id)
            ->firstOrFail();

        return UserFactory::fromState($userModel->toArray());
    }

    public function getTokenForUser(User $user): string
    {
        $userModel = $this->model
            ->findOrFail($user->getId());
        
        return $userModel->api_token;
    }
}
