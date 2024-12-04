<?php

namespace App\Http\Controllers\Api\Address;

use App\Http\Controllers\Controller;
use App\Models\Upazila;
use App\Traits\ApiHttpResponses;

class UpazilaController extends Controller {
    use ApiHttpResponses;

    public function index() {
        // $upazilas = Upazila::with( 'district' )->get(); // Eager load the 'district' relationship
        $upazilas = Upazila::all(); // Eager load the 'district' relationship
        return $this->successResponse( $upazilas, 'Upazilas retrieved successfully' );
    }
}
