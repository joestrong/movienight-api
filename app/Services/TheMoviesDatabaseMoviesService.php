<?php namespace App\Services;

class TheMoviesDatabaseMoviesService
{
    protected $client;
    protected $repository;

    public function __construct()
    {
        $token  = new \Tmdb\ApiToken('4face5a64cfbebe80a03929b77b1576c');
        $this->client = new \Tmdb\Client($token);
        $this->repository = new \Tmdb\Repository\MovieRepository($this->client);
        $this->configRepository = new \Tmdb\Repository\ConfigurationRepository($this->client);
    }

    public function getTop($count = 10)
    {
        return $this->repository->getPopular();
    }

    public function search($queryText)
    {
        $query = new \Tmdb\Model\Search\SearchQuery\MovieSearchQuery();
        $query->page(1);
        $repository = new \Tmdb\Repository\SearchRepository($this->client);
        return $repository->searchMovie($queryText, $query);
    }

    public function get($id)
    {
        return $this->repository->load($id);
    }

    public function getConfig()
    {
        return $this->configRepository->load();
    }
}
