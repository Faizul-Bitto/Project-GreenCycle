<?php

namespace App\Http\Controllers\Api\Address;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Traits\ApiHttpResponses;

class DistrictController extends Controller {

    use ApiHttpResponses;

    // Method to retrieve all Districts
    public function index() {
        // $districts = District::with( 'division' )->get(); // Eager load the 'division' relationship
        $districts = District::all(); // Eager load the 'division' relationship
        return $this->successResponse( $districts, 'Districts retrieved successfully' );
    }
}
