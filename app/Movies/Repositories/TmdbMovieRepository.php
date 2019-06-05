<?php namespace App\Movies\Repositories;

use App\Movies\Factories\MovieFactory;
use App\Movies\Movie;
use Illuminate\Support\Collection;
use Tmdb\Model\Movie as TmdMovie;

class TmdbMovieRepository implements MovieRepository
{
    protected $client;
    protected $repository;
    protected $configRepository;
    protected $movieFactory;

    public function __construct(MovieFactory $movieFactory)
    {
        $token  = new \Tmdb\ApiToken(env('TMDB_TOKEN'));
        $this->client = new \Tmdb\Client($token);
        $this->repository = new \Tmdb\Repository\MovieRepository($this->client);
        $this->configRepository = new \Tmdb\Repository\ConfigurationRepository($this->client);
        $this->movieFactory = $movieFactory;
    }

    public function find(int $id): Movie
    {
        $movieData = $this->repository->load($id);

        return $this->movieFactory->make($movieData);
    }

    public function getTop($limit = 10): Collection
    {
        $movieData = $this->repository->getPopular();

        return collect($movieData)
            ->values()
            ->map(function (TmdMovie $data): Movie {
                return $this->movieFactory->make($data);
            })
            ->take($limit);
    }

    public function getConfig()
    {
        return $this->configRepository->load();
    }
}
