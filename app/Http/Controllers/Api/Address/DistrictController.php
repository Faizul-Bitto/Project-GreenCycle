<?php

namespace App\Http\Controllers\Api\Address;

use App\Models\District;
use App\Traits\ApiHttpResponses;
use App\Http\Controllers\Controller;

class DistrictController extends Controller {

    use ApiHttpResponses;

    //? Method to retrieve all Districts
    public function index() {
        //? Eager load the 'division' relationship
        // $districts = District::with( 'division' )->get();
        //? Eager load the 'division' relationship
        $districts = District::all();
        return $this->successResponse( $districts, 'Districts retrieved successfully' );
    }
}
