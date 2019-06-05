<?php namespace App\Movies\Providers;

use App\Movies\Factories\MovieFactory;
use App\Movies\Repositories\CacheMovieRepository;
use App\Movies\Repositories\MovieRepository;
use App\Movies\Repositories\TmdbMovieRepository;
use Illuminate\Support\ServiceProvider;

class MovieServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(MovieRepository::class, function (): MovieRepository {
            return new CacheMovieRepository(
                new TmdbMovieRepository(
                    new MovieFactory()
                )
            );
        });
    }
}
