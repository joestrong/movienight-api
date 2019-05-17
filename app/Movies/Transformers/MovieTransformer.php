<?php namespace App\Movies\Transformers;

use App\Movies\Movie;
use League\Fractal\TransformerAbstract;

class MovieTransformer extends TransformerAbstract
{
    public function transform(Movie $movie)
    {
        return [
            'title' => $movie->getTitle(),
            'posterImage' => $movie->getPosterImage(),
        ];
    }
}
