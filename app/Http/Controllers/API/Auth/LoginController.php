<?php

namespace App\Http\Controllers\API\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(LoginRequest $request, Hasher $hasher)
    {
        $user = User::where('badge', $request->badge)->first();

        if (!$user || !$hasher->check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'badge' => ['incorrect badge'],
            ]);
        }

        return $user->createToken($request->badge)->plainTextToken;
    }
}
