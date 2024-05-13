<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
   public function login(LoginRequest $request)
    {
        // Validate user credentials
        $credentials = $request->validated();

        try {
            // Attempt to authenticate the user and return token
            $token = Auth::attempt($credentials);
            if (!$token) {
                return response()->json([
                    'message' => 'Invalid credentials',
                    'status' => false,
                ], 401);
            }

            return $this->respondWithToken(
                $token, 
                true, 
                "Logged in successful"
            );

        } catch (Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'status' => false,
            ], 500);
        }
    }
    /**
     * Register a new user and return user data and token.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required'
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }
        /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            auth()->logout();
    
            return response()->json([
                'status' => true,
                'message' => 'Successfully logged out'
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Internal server error, try again letter'
            ], 500);
        }
    }


    /**
     * Get the token array structure along with user data.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'user' => auth()->user(), // Include user data
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
