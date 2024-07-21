<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginUserRequest;
use App\Models\User;
use App\Traits\ApiResponses;

class AuthController extends Controller
{
    use ApiResponses;
    public function login(LoginUserRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return  $this->unauthorized('Invalid credentials');
        }

        $user = User::firstWhere('email', $request->email);

        return $this->ok('Authenticated', [
            'token' => $user->createToken(
                'API token for ' . $user->email,
                ['*'],
                now()->addMonth()
            )->plainTextToken,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->ok('');
    }

    use ApiResponses;
    public function register(LoginUserRequest $request)
    {
        return $this->ok("TODO: register");
    }
}
