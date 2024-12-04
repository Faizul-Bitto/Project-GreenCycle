<?php

namespace App\Http\Controllers\Api\RolesAndPermissions;

use App\Http\Controllers\Controller;
use App\Traits\ApiHttpResponses;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller {
    use ApiHttpResponses;

    public function index() {
        try {
            $roles = Role::with( 'permissions' )->get();
            return $this->successResponse( ['roles' => $roles] );
        } catch ( \Exception $e ) {
            return $this->errorResponse( 'Failed to fetch roles', 500 );
        }
    }

    public function store( Request $request ) {
        try {
            $request->validate( [
                'name'          => 'required|unique:roles,name',
                'permissions'   => 'required|array',
                'permissions.*' => 'exists:permissions,name',
            ] );

            $role = Role::create( [
                'name' => $request->input( 'name' ),
            ] );

            // Sync the permissions to the role
            $role->syncPermissions( $request->input( 'permissions' ) );

            return $this->successResponse( ['role' => $role], 'Role created successfully', 201 );
        } catch ( \Exception $e ) {
            return $this->errorResponse( 'Failed to create role', 500 );
        }
    }

    public function show( Role $role ) {
        try {
            $permissions = $role->permissions()->get();
            return $this->successResponse( ['role' => $role, 'permissions' => $permissions], 'Role fetched successfully', 200 );
        } catch ( \Exception $e ) {
            return $this->errorResponse( 'Role not found', 404 );
        }
    }

    public function update( Request $request, Role $role ) {
        try {
            $request->validate( [
                'name'          => 'required',
                'permissions'   => 'required|array',
                'permissions.*' => 'exists:permissions,name',
            ] );

            $role->name = $request->input( 'name' );
            $role->save();

            // Sync the permissions to the role
            $role->syncPermissions( $request->input( 'permissions' ) );

            return $this->successResponse( ['role' => $role], 'Role updated successfully', 200 );
        } catch ( \Exception $e ) {
            return $this->errorResponse( 'Failed to update role', 500 );
        }
    }

    public function destroy( Role $role ) {
        try {
            $role->delete();
            return $this->successResponse( null, 'Role deleted successfully', 200 );
        } catch ( \Exception $e ) {
            return $this->errorResponse( 'Failed to delete role', 500 );
        }
    }
}
