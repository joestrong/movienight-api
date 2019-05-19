<?php namespace App\Http\Controllers;

use App\Http\Requests\ExchangeFacebookTokenRequest;
use App\Http\Requests\ValidateTokenRequest;
use App\Users\Exceptions\InvalidFacebookTokenException;
use App\Users\Exceptions\UserNotFoundException;
use App\Users\UserService;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    protected $userService;
    
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function exchangeFacebookToken(ExchangeFacebookTokenRequest $request): JsonResponse
    {
        $facebookToken = $request->json()->get('token');

        try {
            $facebookUser = Socialite::driver('facebook')->userFromToken($facebookToken);
        } catch (ClientException $e) {
            throw new InvalidFacebookTokenException();
        }
        
        try {
            $user = $this->userService->getByFacebookId($facebookUser->id);
        } catch (UserNotFoundException $e) {
            $user = $this->userService->createFromFacebook($facebookUser);
        }
        
        return response()->json([
            'token' => $this->userService->getTokenForUser($user),
        ]);
    }

    public function validateToken(ValidateTokenRequest $request): JsonResponse
    {
        $token = $request->json()->get('token');
        
        $validity = $this->userService->isTokenValid($token);
        
        return response()->json([
            'valid' => $validity,
        ]);
    }
}
