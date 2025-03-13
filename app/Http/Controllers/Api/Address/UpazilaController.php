<?php

namespace App\Http\Controllers\Api\Address;

use App\Models\Upazila;
use App\Traits\ApiHttpResponses;
use App\Http\Controllers\Controller;

class UpazilaController extends Controller {

    use ApiHttpResponses;

    public function index() {
        //? Eager load the 'district' relationship
        // $upazilas = Upazila::with( 'district' )->get();
        //? Eager load the 'district' relationship
        $upazilas = Upazila::all();
        return $this->successResponse( $upazilas, 'Upazilas retrieved successfully' );
    }
}
