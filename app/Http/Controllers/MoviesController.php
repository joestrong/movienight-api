<?php

namespace App\Http\Controllers;

use App\Movies\MovieService;
use App\Movies\Transformers\MovieTransformer;

class MoviesController extends Controller
{
    private $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function index()
    {
        $movies = $this->movieService->getTop(30);

        return response()->json(
            fractal()->collection($movies, new MovieTransformer())
        );
    }
}
