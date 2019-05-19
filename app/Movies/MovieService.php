<?php namespace App\Movies;

use Tmdb\Model\Movie as TmdMovie;

class MovieService
{
    public function __construct()
    {
        $this->movies = new \App\Services\TheMoviesDatabaseMoviesService();
    }

    public function getTop(int $limit = 10)
    {
        $movieData = $this->movies->getTop($limit);
        
        return collect($movieData)
            ->values()
            ->map(function (TmdMovie $data): Movie {
                $movie = new Movie();
                $movie->setTitle($data->getTitle());
                $movie->setPosterImage(
                    $this->getPosterPath() .
                    $data->getPosterImage()->getFilePath()
                );
                $movie->setBackdropImage(
                    $this->getPosterPath() .
                    $data->getBackdropImage()->getFilePath()
                );

                return $movie;
            });
    }

    public function getPosterPath()
    {
        $imageConfig = $this->movies->getConfig()->getImages();

        return $imageConfig['secure_base_url'] . $imageConfig['poster_sizes'][4];
    }
}
