<?php namespace App\Users;

class Seenable
{
    protected $movieId;

    public function getMovieId(): int
    {
        return $this->movieId;
    }

    public function setMovieId(int $movieId)
    {
        $this->movieId = $movieId;
    }
}
