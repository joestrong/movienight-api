<?php

namespace App\Http\Controllers;

use App\Movies\MovieService;
use App\Movies\Transformers\MovieTransformer;
use Illuminate\Support\Facades\Auth;

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

    public function show(int $movieId)
    {
        $movie = $this->movieService->find($movieId);

        return response()->json(
            fractal()->item($movie, new MovieTransformer())
        );
    }

    public function postSeen(int $movieId)
    {
        $movie = $this->movieService->find($movieId);
        $user = Auth::user();
        
        $this->movieService->markSeenForUser($movie, $user);
    }
}
