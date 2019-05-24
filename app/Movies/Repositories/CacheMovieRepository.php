<?php namespace App\Movies\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CacheMovieRepository implements MovieRepository
{
    protected $movieRepo;

    public function __construct(MovieRepository $movieRepo)
    {
        $this->movieRepo = $movieRepo;
    }

    public function getTop(int $limit): Collection
    {
        $length = 60 * 10;
        
        return Cache::remember('movies.getTop', $length, function () use ($limit): Collection {
            return $this->movieRepo->getTop($limit);
        });
    }

    public function getConfig()
    {
        $length = 60 * 10;

        return Cache::remember('movies.getConfig', $length, function () {
            return $this->movieRepo->getConfig();
        });
    }
}
