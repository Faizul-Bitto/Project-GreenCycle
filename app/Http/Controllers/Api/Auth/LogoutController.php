<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ApiHttpResponses;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller {

    use ApiHttpResponses;

    public function logout() {

// Check if the user is authenticated
        if ( $user = Auth::user() ) {
            // Delete the current access token associated with the user
            $user->currentAccessToken()->delete();

// Return success response indicating successful logout
            return $this->successResponse( [], 'Logged out successfully' );
        }

        // Return error response if user is not authenticated
        return $this->errorResponse( 'Unauthorized', 401 );
    }

}
