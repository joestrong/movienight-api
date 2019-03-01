<?php namespace App\Http\Controllers;

use App\Users\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    protected $userService;
    
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    public function redirectToProvider(): RedirectResponse
    {
        return Socialite::driver('facebook')->stateless()->redirect();
    }

    public function handleProviderCallback(): JsonResponse
    {
        $facebookUser = Socialite::driver('facebook')->stateless()->user();

        $user = $this->userService->getByFacebookId($facebookUser->id);
        
        return response()->json([
            'token' => $this->userService->getTokenForUser($user),
        ]);
    }
}
