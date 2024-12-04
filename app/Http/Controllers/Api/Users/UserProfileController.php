<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User_Detail;
use App\Traits\ApiHttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller {

    use ApiHttpResponses;

    private function authorizeUser( User $user ) {

        if ( $user->id !== auth()->user()->id ) {
            return $this->errorResponse( 'Unauthorized', 403 );
        }

    }

    public function updatePhone( Request $request, User $user ) {

// Check if the authenticated user is updating his/her own profile
        if ( $response = $this->authorizeUser( $user ) ) {
            return $response;
        }

        $validatedData = $request->validate( [
            'phone' => 'required|unique:users,phone,' . $user->id,
        ] );

        $user->update( [
            'phone' => $validatedData['phone'],
        ] );

        return $this->successResponse( $user, 'Phone number updated successfully' );
    }

    public function updatePassword( Request $request, User $user ) {

// Check if the authenticated user is updating his/her own profile

        if ( $response = $this->authorizeUser( $user ) ) {
            return $response;
        }

        $validatedData = $request->validate( [
            'password' => 'required|min:6',
        ] );

        $user->update( [
            'password' => bcrypt( $validatedData['password'] ),
        ] );

        return $this->successResponse( $user, 'Password updated successfully' );
    }

    public function updateUserDetails( Request $request, User $user ) {

// Check if the authenticated user is updating his/her own details

        if ( $response = $this->authorizeUser( $user ) ) {
            return $response;
        }

        $validatedData = $request->validate( [
            'name'        => 'required',
            'division_id' => 'required|exists:divisions,id',
            'district_id' => 'required|exists:districts,id',
            'upazila_id'  => 'required|exists:upazilas,id',
            'area'        => 'required',
        ] );

        if ( $user->userDetail()->exists() ) {
            $userDetail = $user->userDetail;
            $userDetail->update( $validatedData );
        } else {
            $userDetail = new User_Detail( $validatedData );
            $user->userDetail()->save( $userDetail );
        }

        return $this->successResponse( $userDetail, 'User details updated successfully' );
    }

    public function updateProfileImage( Request $request, User $user ) {

        if ( $response = $this->authorizeUser( $user ) ) {
            return $response;
        }

        $request->validate( [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ] );

        if ( $request->hasFile( 'image' ) ) {

            if ( $user->profile_image ) {
                Storage::disk( 'public' )->delete( $user->profile_image );
            }

            $imagePath = $request->file( 'image' )->store( 'profile_images', 'public' );
            $user->update( ['profile_image' => $imagePath] );
        }

        return $this->successResponse( $user, 'Profile image updated successfully' );
    }

}
