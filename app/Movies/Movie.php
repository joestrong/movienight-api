<?php namespace App\Movies;

class Movie
{
    protected $id;
    protected $title;
    protected $posterImage;
    protected $backdropImage;

    public function getId(): int
    {
        return $this->id;
    }
    
    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function getPosterImage(): ?string
    {
        return $this->posterImage;
    }

    public function setPosterImage(string $posterImage)
    {
        $this->posterImage = $posterImage;
    }

    public function getBackdropImage(): ?string
    {
        return $this->backdropImage;
    }

    public function setBackdropImage(string $backdropImage)
    {
        $this->backdropImage = $backdropImage;
    }
}
