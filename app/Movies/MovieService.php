<?php namespace App\Movies;

use App\Movies\Repositories\MovieRepository;
use Tmdb\Model\Movie as TmdMovie;

class MovieService
{
    protected $movieRepo;
    
    public function __construct(MovieRepository $movieRepo)
    {
        $this->movieRepo = $movieRepo;
    }

    public function getTop(int $limit = 10)
    {
        $movies = $this->movieRepo->getTop($limit);

        return $movies->map(function (Movie $movie): Movie {
            if ($movie->getPosterImage() !== null) {
                $movie->setPosterImage($this->getPosterPath() . $movie->getPosterImage());
            }
            if ($movie->getBackdropImage() !== null) {
                $movie->setBackdropImage($this->getPosterPath() . $movie->getBackdropImage());
            }

            return $movie;
        });
    }

    public function getPosterPath()
    {
        $imageConfig = $this->movieRepo->getConfig()->getImages();

        return $imageConfig['secure_base_url'] . $imageConfig['poster_sizes'][4];
    }
}
