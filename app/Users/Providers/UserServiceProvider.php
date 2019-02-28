<?php namespace App\Users\Providers;

use App\Users\Models\User;
use App\Users\Repositories\EloquentUserRepository;
use App\Users\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepository::class, function() {
            return new EloquentUserRepository(new User());
        });
    }
}
