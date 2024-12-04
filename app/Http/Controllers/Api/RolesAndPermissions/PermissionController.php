<?php

namespace App\Http\Controllers\Api\RolesAndPermissions;

use App\Http\Controllers\Controller;
use App\Traits\ApiHttpResponses;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller {
    use ApiHttpResponses;

    public function index() {
        try {
            $permissions = Permission::with( 'roles' )->get();
            return $this->successResponse( ['permissions' => $permissions] );
        } catch ( \Exception $e ) {
            return $this->errorResponse( 'Failed to fetch permissions', 500 );
        }
    }
}
