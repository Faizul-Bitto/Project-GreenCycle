<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequests\LoginRequest;
use App\Traits\ApiHttpResponses;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {

    use ApiHttpResponses;

    public function login( LoginRequest $request ) {

        $credentials = $request->only( 'phone', 'password' );

// Attempt to authenticate the user
        if ( Auth::attempt( $credentials, true ) ) {
            $user = Auth::user();

            // Create an API token for the authenticated user
            $token = $user->createToken( 'Login API Token of ' . $user->phone )->plainTextToken;

// Fetch the user's roles
            // $roles = $user->roles;
            $role = $user->roles->map( function ( $role ) {
                return [
                    'id'   => $role->id,
                    'name' => $role->name,
                ];
            } );

            // Return a successful response with user data, roles, and token
            return $this->successResponse( [
                'user'  => [
                    'id'    => $user->id,
                    'phone' => $user->phone,
                    'role'  => $role,
                ],
                'token' => $token,
            ], 'Logged in successfully', 200 );
        }

        // Return an error response for invalid credentials
        return $this->errorResponse( 'Invalid credentials', 401 );
    }

}
