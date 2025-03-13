<?php

namespace App\Http\Controllers\Api\Auth;

use App\Traits\ApiHttpResponses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller {

    use ApiHttpResponses;

    public function logout() {

//? Check if the user is authenticated
        if ( $user = Auth::user() ) {
            //? Delete the current access token associated with the user
            $user->currentAccessToken()->delete();

            return $this->successResponse( [], 'Logged out successfully' );
        }

        return $this->errorResponse( 'Unauthorized', 401 );
    }

}
