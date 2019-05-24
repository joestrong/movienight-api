<?php namespace App\Movies\Providers;

use App\Movies\Repositories\MovieRepository;
use App\Movies\Repositories\TmdbMovieRepository;
use Illuminate\Support\ServiceProvider;

class MovieServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(MovieRepository::class, function (): MovieRepository {
            return new TmdbMovieRepository();
        });
    }
}
