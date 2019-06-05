<?php namespace App\Movies\Repositories;

use App\Movies\Movie;
use Illuminate\Support\Collection;

interface MovieRepository
{
    public function find(int $id): Movie;
    
    public function getTop(int $limit): Collection;

    public function getConfig();
}
