<?php

namespace App\Http\Controllers;

class MoviesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->movies = new \App\Services\TheMoviesDatabaseMoviesService();
    }

    public function index()
    {
        $movies = $this->movies->getTop(30);
        $return = [];
        foreach ($movies as $movie) {
            array_push($return, [
                'title' => $movie->getTitle(),
            ]);
        }
        return response()->json($return);
    }
}
