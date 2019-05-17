<?php namespace App\Movies;

class Movie
{
    protected $title;
    protected $posterImage;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function getPosterImage()
    {
        return $this->posterImage;
    }

    public function setPosterImage($posterImage)
    {
        $this->posterImage = $posterImage;
    }
}
