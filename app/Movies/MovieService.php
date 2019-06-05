<?php namespace App\Movies;

use App\Movies\Exceptions\AlreadySeenException;
use App\Movies\Repositories\MovieRepository;
use App\Users\Repositories\UserRepository;
use App\Users\Seenable;
use App\Users\User;
use Illuminate\Support\Collection;
use Tmdb\Model\Movie as TmdMovie;

class MovieService
{
    protected $movieRepo;
    protected $userRepo;
    
    public function __construct(
        MovieRepository $movieRepo,
        UserRepository $userRepo
    ) {
        $this->movieRepo = $movieRepo;
        $this->userRepo= $userRepo;
    }

    public function find(int $id): Movie
    {
        $movie = $this->movieRepo->find($id);

        $movie = $this->addFullImagePaths($movie);

        return $movie;
    }

    public function getTop(int $limit = 10)
    {
        $movies = $this->movieRepo->getTop($limit);

        return $movies->map(function (Movie $movie): Movie {
            $movie = $this->addFullImagePaths($movie);

            return $movie;
        });
    }

    public function getPosterPath()
    {
        $imageConfig = $this->movieRepo->getConfig()->getImages();

        return $imageConfig['secure_base_url'] . $imageConfig['poster_sizes'][4];
    }

    public function markSeenForUser(Movie $movie, User $user): void
    {
        if ($this->hasBeenSeen($movie, $user)) {
            throw new AlreadySeenException();
        }
        
        $this->userRepo->markMovieSeen($user, $movie);
    }
    
    public function hasBeenSeen(Movie $movie, User $user): bool
    {
        return $this->userRepo->hasBeenSeen($user, $movie);
    }

    public function getSeenList(User $user): Collection
    {
        $seenList = $this->userRepo->getSeenList($user);

        $movies = $seenList->map(function (Seenable $seenable): Movie {
            $movie = $this->movieRepo->find($seenable->getMovieId());
            $movie = $this->addFullImagePaths($movie);
            
            return $movie;
        });

        return $movies;
    }

    protected function addFullImagePaths(Movie $movie): Movie
    {
        if ($movie->getPosterImage() !== null) {
            $movie->setPosterImage($this->getPosterPath() . $movie->getPosterImage());
        }
        if ($movie->getBackdropImage() !== null) {
            $movie->setBackdropImage($this->getPosterPath() . $movie->getBackdropImage());
        }

        return $movie;
    }
}
