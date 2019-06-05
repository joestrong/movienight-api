<?php namespace App\Http\Controllers;

use App\Http\Requests\MyProfileRequest;
use App\Users\UserService;
use App\Users\Transformers\UserTransformer;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function myProfile(MyProfileRequest $request)
    {
        $user = Auth::user();

        return response()->json(
            fractal()->item($user, new UserTransformer())
        );
    }

    public function show(int $userId)
    {
        $user = $this->userService->find($userId);

        return response()->json(
            fractal()->item($user, new UserTransformer())
        );
    }
}
