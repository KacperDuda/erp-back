<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Sanctum\NewAccessToken;

class AuthController extends Controller
{
    /**
     * Issues Personal Access Token for a given user and returns it's plain text
     * @param User $user
     * @param string $name token name
     * @param $abilities
     * @return string
     */
    protected function issueTokenFor(User $user , string $name = 'login_token', $abilities = null): string {
        return $user->createToken($name, $abilities ?: $user->abilities)->plainTextToken;
    }

    public function __construct()
    {
        // middleware
    }

    /**
     * Retrieve currently authenticated user
     * @return array
     */
    public function user(): array
    {
        return ['user' => Auth::guard('sanctum')->user()];
    }

    /**
     * Return a token of a currently authenticated user
     * @return array
     */
    public function token(): array
    {
        return ['token' => Auth::guard('sanctum')->user()->currentAccessToken()];
    }

    /**
     * Validates user's credentials and issues a Personal Access Token
     * @param Request $request
     * @return NewAccessToken[]|string[]
     */
    public function login(Request $request): array
    {
        $credentials = $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if(Auth::guard('web')->attempt($credentials)) {
            $authenticated = User::where('email', $credentials['email'])->first();
            return ['token' => $this->issueTokenFor($authenticated, abilities: $authenticated->abilities)];
        } else {
            return ['message'=>'Invalid credentials'];
        }
    }
}
