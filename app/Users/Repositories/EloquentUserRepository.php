<?php namespace App\Users\Repositories;

use App\Movies\Movie;
use App\Users\Exceptions\UserNotFoundException;
use App\Users\Factories\UserFactory;
use App\Users\Models\User as UserModel;
use App\Users\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentUserRepository implements UserRepository
{
    protected $model;

    public function __construct(UserModel $userModel)
    {
        $this->model = $userModel;
    }

    public function getByToken(string $token): User
    {
        try {
            $userModel = $this->model
                ->where('api_token', $token)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new UserNotFoundException();
        }

        return UserFactory::fromState($userModel->toArray());
    }

    public function getByFacebookId(string $id): User
    {
        try {
            $userModel = $this->model
                ->where('facebook_id', $id)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new UserNotFoundException();
        }

        return UserFactory::fromState($userModel->toArray());
    }

    public function getTokenForUser(User $user): string
    {
        $userModel = $this->model
            ->findOrFail($user->getId());

        return $userModel->api_token;
    }

    public function create(array $attributes): User
    {
        $userModel = $this->model->create($attributes);
        $userModel->find($userModel->id);

        return UserFactory::fromState($userModel->toArray());
    }

    public function markMovieSeen(User $user, Movie $movie): void
    {
        $userModel = $this->model->findOrFail($user->getId());

        $userModel->seeables()->create([
            'seeable_type' => Movie::class,
            'seeable_id' => $movie->getId(),
        ]);
    }
}
