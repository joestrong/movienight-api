<?php namespace App\Movies\Repositories;

use Illuminate\Support\Collection;

interface MovieRepository
{
    public function getTop(int $limit): Collection;

    public function getConfig();
}
