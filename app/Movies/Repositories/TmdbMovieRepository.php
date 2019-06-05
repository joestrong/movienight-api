<?php namespace App\Movies\Repositories;

use App\Movies\Movie;
use Illuminate\Support\Collection;
use Tmdb\Model\Movie as TmdMovie;

class TmdbMovieRepository implements MovieRepository
{
    protected $client;
    protected $repository;
    protected $configRepository;

    public function __construct()
    {
        $token  = new \Tmdb\ApiToken(env('TMDB_TOKEN'));
        $this->client = new \Tmdb\Client($token);
        $this->repository = new \Tmdb\Repository\MovieRepository($this->client);
        $this->configRepository = new \Tmdb\Repository\ConfigurationRepository($this->client);
    }

    public function getTop($limit = 10): Collection
    {
        $movieData = $this->repository->getPopular();

        return collect($movieData)
            ->values()
            ->map(function (TmdMovie $data): Movie {
                $movie = new Movie();
                $movie->setId($data->getId());
                $movie->setTitle($data->getTitle());
                if ($data->getPosterImage()->getFilePath() !== null) {
                    $movie->setPosterImage(
                        $data->getPosterImage()->getFilePath()
                    );
                }
                if ($data->getBackdropImage()->getFilePath() !== null) {
                    $movie->setBackdropImage(
                        $data->getBackdropImage()->getFilePath()
                    );
                }

                return $movie;
            });
    }

    public function getConfig()
    {
        return $this->configRepository->load();
    }
}
