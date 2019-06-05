<?php namespace App\Users;

use App\Users\Exceptions\UserNotFoundException;
use App\Users\Repositories\UserRepository;
use Illuminate\Support\Str;
use Laravel\Socialite\Two\User as FacebookUser;

class UserService
{
    protected $userRepo;
    
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function find(int $id): User
    {
        return $this->userRepo->find($id);
    }
    
    public function getByToken(string $token): User
    {
        return $this->userRepo->getByToken($token);
    }

    public function getByFacebookId(string $id): User
    {
        return $this->userRepo->getByFacebookId($id);
    }

    public function getTokenForUser(User $user): string
    {
        return $this->userRepo->getTokenForUser($user);
    }
    
    public function createFromFacebook(FacebookUser $facebookUser): User
    {
        return $this->userRepo->create([
            'name' => $facebookUser->name,
            'email' => $facebookUser->email,
            'api_token' => hash('sha256', Str::random(60)),
            'facebook_id' => $facebookUser->id,
        ]);
    }

    public function isTokenValid(string $token): bool
    {
        try {
            $this->getByToken($token);
            
            return true;
        } catch (UserNotFoundException $e) {
            return false;
        }
    }
}
