<?php namespace App\Movies\Factories;

use App\Movies\Movie;
use Tmdb\Model\Movie as TmdMovie;

class MovieFactory{
    public function make(TmdMovie $data): Movie
    {
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
    }
}
