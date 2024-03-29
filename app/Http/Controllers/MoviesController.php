<?php

namespace App\Http\Controllers;

use App\Movies\Exceptions\AlreadySeenException;
use App\Movies\Exceptions\NotSeenException;
use App\Movies\MovieService;
use App\Movies\Transformers\MovieTransformer;
use App\Users\UserService;
use Illuminate\Support\Facades\Auth;

class MoviesController extends Controller
{
    protected $movieService;
    protected $userService;

    public function __construct(
        MovieService $movieService,
        UserService $userService
    ) {
        $this->movieService = $movieService;
        $this->userService = $userService;
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

        try {
            $this->movieService->markSeenForUser($movie, $user);
        } catch (AlreadySeenException $e) {
            // Silently fail
        }
    }

    public function deleteSeen(int $movieId)
    {
        $movie = $this->movieService->find($movieId);
        $user = Auth::user();

        try {
            $this->movieService->removeSeenForUser($movie, $user);
        } catch (NotSeenException $e) {
            // Silently fail
        }
    }

    public function seenList(int $userId)
    {
        $user = $this->userService->find($userId);
        
        $movies = $this->movieService->getSeenList($user);

        return response()->json(
            fractal()->collection($movies, new MovieTransformer())
        );
    }
}
