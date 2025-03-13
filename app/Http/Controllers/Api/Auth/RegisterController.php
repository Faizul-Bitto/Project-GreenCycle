<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Models\Upazila;
use App\Models\District;
use App\Models\Division;
use App\Traits\ApiHttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequests\StoreUserRequest;
use App\Http\Requests\AuthRequests\StoreUserDetailsRequest;

class RegisterController extends Controller {

    use ApiHttpResponses;

    //! Registers a new user with phone number and password (First step of registration)
    public function createUser( StoreUserRequest $request ) {

        $validatedData = $request->validated();

//? Check if phone number already exists in the database
        if ( User::where( 'phone', $validatedData['phone'] )->exists() ) {
            return $this->errorResponse( 'Phone number already exists', 422 );
        }

        //? Create a new user with validated data
        $user = User::create( [
            'phone'    => $validatedData['phone'],
            'password' => bcrypt( $validatedData['password'] ),
        ] );

        //? Assign role to the user
        $role = $validatedData['role'];
        $user->assignRole( $role );

        //? Generate API token
        $token = $user->createToken( 'Register API Token of ' . $user->phone )->plainTextToken;

        return $this->successResponse( [
            'user'  => [
                'id'    => $user->id,
                'phone' => $user->phone,
            ],
            'token' => $token,
        ], 'User registered successfully', 201 );
    }

    //! Adds additional information for the user (Second step of registration)
    public function addUserInformation( StoreUserDetailsRequest $request, User $user ) {

        $validatedData = $request->validated();

        //? Update or create user details
        $userDetail = $user->userDetail()->updateOrCreate( [], [
            'name'        => $validatedData['name'],
            'division_id' => $validatedData['division_id'],
            'district_id' => $validatedData['district_id'],
            'upazila_id'  => $validatedData['upazila_id'],
            'area'        => $validatedData['area'],
        ] );

        //? Fetch additional data
        $division = Division::findOrFail( $validatedData['division_id'] );
        $district = District::findOrFail( $validatedData['district_id'] );
        $upazila  = Upazila::findOrFail( $validatedData['upazila_id'] );
        // $roles = $user->roles;
        $role = $user->roles->map( function ( $role ) {
            return [
                'id'   => $role->id,
                'name' => $role->name,
            ];
        } );

        return $this->successResponse( [
            'user_details' => [
                'id'            => $userDetail->id,
                'user_id'       => $userDetail->user_id,
                'name'          => $userDetail->name,
                'division_id'   => $division->id,
                'division_name' => $division->name,
                'district_id'   => $district->id,
                'district_name' => $district->name,
                'upazila_id'    => $upazila->id,
                'upazila_name'  => $upazila->name,
                'area'          => $userDetail->area,
                'role'          => $role,
            ],
        ], 'User details stored successfully', 200 );
    }

}
