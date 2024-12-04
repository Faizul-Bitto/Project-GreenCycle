<?php

namespace App\Http\Controllers\Api\Address;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Traits\ApiHttpResponses;

class DivisionController extends Controller {
    use ApiHttpResponses; // The ApiHttpResponses trait

    // Method to retrieve all Divisions
    public function index() {
        $divisions = Division::all(); // Retrieve all Divisions from the database
        return $this->successResponse( $divisions, 'Divisions retrieved successfully' );
    }
}
