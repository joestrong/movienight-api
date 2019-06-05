<?php namespace App\Users\Repositories;

use App\Movies\Movie;
use App\Users\Exceptions\UserNotFoundException;
use App\Users\Factories\UserFactory;
use App\Users\Models\User as UserModel;
use App\Users\Models\UserSeeable;
use App\Users\Seenable;
use App\Users\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class EloquentUserRepository implements UserRepository
{
    protected $model;

    public function __construct(UserModel $userModel)
    {
        $this->model = $userModel;
    }

    public function find(int $id): User
    {
        try {
            $userModel = $this->model->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new UserNotFoundException();
        }
        
        return UserFactory::fromState($userModel->toArray());
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
        try {
            $userModel = $this->model->findOrFail($user->getId());
        } catch (ModelNotFoundException $e) {
            throw new UserNotFoundException();
        }

        $userModel->seeables()->create([
            'seeable_type' => Movie::class,
            'seeable_id' => $movie->getId(),
        ]);
    }
    
    public function hasBeenSeen(User $user, Movie $movie): bool
    {
        $userModel = $this->model
            ->where('id', $user->getId())
            ->whereHas('seeables', function (Builder $query) use ($movie) {
                $query->where('seeable_type', Movie::class);
                $query->where('seeable_id', $movie->getId());
            })
            ->first();
        
        return $userModel !== null;
    }

    public function getSeenList(User $user): Collection
    {
        try {
            $userModel = $this->model->findOrFail($user->getId());
        } catch (ModelNotFoundException $e) {
            throw new UserNotFoundException();
        }

        return $userModel->seeables->map(function (UserSeeable $userSeeable): Seenable {
            $seenable = new Seenable();
            $seenable->setMovieId($userSeeable->seeable_id);

            return $seenable;
        });
    }
}
