<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiHttpResponses;
use Illuminate\Http\Request;

class ManageUserController extends Controller {

    use ApiHttpResponses;

//     public function userList() {

//         $users = User::all();

//         return $this->successResponse( $users, 'List of users retrieved successfully' );

//     }

//     public function showUser( User $user ) {

//         return $this->successResponse( $user, 'User details retrieved successfully' );

//     }

//     public function userDetails( User $user ) {

//         if ( $user->userDetail()->exists() ) {

//             return $this->successResponse( $user->userDetail, 'User details retrieved successfully' );

//         } else {

//             return $this->errorResponse( 'User details not found', 404 );

//         }

//     }

//     public function destroyUser( User $user ) {

//         $user->delete();

//         return $this->successResponse( null, 'User deleted successfully' );

//     }

//     public function updateUserDetails( Request $request, User $user ) {

//         $validatedData = $request->validate( [

//             'name'        => 'required',

//             'division_id' => 'required|exists:divisions,id',

//             'district_id' => 'required|exists:districts,id',

//             'upazila_id'  => 'required|exists:upazilas,id',

//             'area'        => 'required',

//         ] );

//         if ( $user->userDetail()->exists() ) {

//             $userDetail = $user->userDetail;

//             $userDetail->update( $validatedData );

//         } else {

//             $userDetail = new User_Detail( $validatedData );

//             $user->userDetail()->save( $userDetail );

//         }

//         return $this->successResponse( $userDetail, 'User details updated successfully' );

//     }

//     public function updatePhone( Request $request, User $user ) {

// // Check if the authenticated user is updating their own profile

//         if ( $user->id !== auth()->user()->id ) {

//             return $this->errorResponse( 'Unauthorized', 403 );

//         }

//         $validatedData = $request->validate( [

//             'phone' => 'required|unique:users,phone,' . $user->id,

//         ] );

//         $user->update( [

//             'phone' => $validatedData['phone'],

//         ] );

//         return $this->successResponse( $user, 'Phone number updated successfully' );

//     }

//     public function updatePassword( Request $request, User $user ) {

// // Check if the authenticated user is updating their own profile

//         if ( $user->id !== auth()->user()->id ) {

//             return $this->errorResponse( 'Unauthorized', 403 );

//         }

//         $validatedData = $request->validate( [

//             'password' => 'required|min:6',

//         ] );

//         $user->update( [

//             'password' => bcrypt( $validatedData['password'] ),

//         ] );

//         return $this->successResponse( $user, 'Password updated successfully' );

//     }

// private function authorizeUser( User $user ) {

//     if ( $user->id !== auth()->user()->id ) {

//         abort( 403, 'Unauthorized' );

//     }

    // }

    public function userList() {
        $users = User::all();
        return $this->successResponse( $users, 'List of users retrieved successfully' );
    }

    public function showUser( User $user ) {
        return $this->successResponse( $user, 'User details retrieved successfully' );
    }

    public function userDetails( User $user ) {

        if ( $user->userDetail()->exists() ) {
            return $this->successResponse( $user->userDetail, 'User details retrieved successfully' );
        } else {
            return $this->errorResponse( 'User details not found', 404 );
        }

    }

    public function destroyUser( User $user ) {
        $user->delete();
        return $this->successResponse( null, 'User deleted successfully' );
    }

    public function updateUserDetails( Request $request, User $user ) {
        $validatedData = $this->validateUserDetails( $request );

        $userDetail = $user->userDetail()->updateOrCreate( [], $validatedData );

        return $this->successResponse( $userDetail, 'User details updated successfully' );
    }

    public function updatePhone( Request $request, User $user ) {
        // $this->authorizeUser( $user );

        $validatedData = $request->validate( [
            'phone' => 'required|unique:users,phone,' . $user->id,
        ] );

        $user->update( ['phone' => $validatedData['phone']] );

        return $this->successResponse( $user, 'Phone number updated successfully' );
    }

    public function updatePassword( Request $request, User $user ) {
        // $this->authorizeUser( $user );

        $validatedData = $request->validate( [
            'password' => 'required|min:6',
        ] );

        $user->update( ['password' => bcrypt( $validatedData['password'] )] );

        return $this->successResponse( $user, 'Password updated successfully' );
    }

    private function validateUserDetails( Request $request ) {

        return $request->validate( [
            'name'        => 'required',
            'division_id' => 'required|exists:divisions,id',
            'district_id' => 'required|exists:districts,id',
            'upazila_id'  => 'required|exists:upazilas,id',
            'area'        => 'required',
        ] );
    }

}
