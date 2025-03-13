<?php

namespace App\Http\Controllers\Api\Address;

use App\Models\Division;
use App\Traits\ApiHttpResponses;
use App\Http\Controllers\Controller;

class DivisionController extends Controller {

    use ApiHttpResponses;

    //? Method to retrieve all Divisions
    public function index() {
        $divisions = Division::all();
        return $this->successResponse( $divisions, 'Divisions retrieved successfully' );
    }
}
