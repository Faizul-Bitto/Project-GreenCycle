<?php

namespace App\Http\Controllers\Api\BothBuyAndSellUsers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiHttpResponses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GetBothBuyAndSellUsersController extends Controller {

    use ApiHttpResponses;
    public function getBothBuyAndSellUsersByRoles() {

        //? Ensure the user is authenticated
        $authenticatedUser = Auth::user();

        if ( !$authenticatedUser ) {
            return $this->errorResponse( 'Unauthorized', 401 );
        }

        $roles = ['Vangari', 'Waste Collector', 'Recycling Company'];

//? Get the authenticated user's area
        $authenticatedUserArea = $authenticatedUser->userDetail->area;

        $users = User::with( ['userDetail.division', 'userDetail.district', 'userDetail.upazila', 'roles'] )
            ->whereHas( 'roles', function ( $query ) use ( $roles ) {
                $query->whereIn( 'name', $roles );
            } )
            ->get()
            ->map( function ( $user ) {
                return [
                    'id'      => $user->id,
                    'phone'   => $user->phone,
                    'role'    => $user->roles->pluck( 'name' ),
                    'details' => [
                        'name'     => $user->userDetail->name ?? null,
                        'division' => $user->userDetail->division->name ?? null,
                        'district' => $user->userDetail->district->name ?? null,
                        'upazila'  => $user->userDetail->upazila->name ?? null,
                        'area'     => $user->userDetail->area ?? null,
                    ],
                ];
            } )
            ->sortBy( function ( $user ) use ( $authenticatedUserArea ) {
                return $user['details']['area'] === $authenticatedUserArea ? 0 : 1;
            } )
            ->values();

        return $this->successResponse( $users, 'Users fetched successfully' );
    }

    public function searchUsers( Request $request ) {

        //? Ensure the user is authenticated
        $authenticatedUser = Auth::user();

        if ( !$authenticatedUser ) {
            return $this->errorResponse( 'Unauthorized', 401 );
        }

        $roles = ['Vangari', 'Waste Collector', 'Recycling Company'];

        //? Get search parameters
        $division = $request->input( 'division' );
        $district = $request->input( 'district' );
        $upazila  = $request->input( 'upazila' );
        $area     = $request->input( 'area' );

        $query = User::with( ['userDetail.division', 'userDetail.district', 'userDetail.upazila', 'roles'] )
            ->whereHas( 'roles', function ( $query ) use ( $roles ) {
                $query->whereIn( 'name', $roles );
            } );

//? Apply filters
        if ( $division ) {
            $query->whereHas( 'userDetail.division', function ( $q ) use ( $division ) {
                $q->where( 'name', $division );
            } );
        }

        if ( $district ) {
            $query->whereHas( 'userDetail.district', function ( $q ) use ( $district ) {
                $q->where( 'name', $district );
            } );
        }

        if ( $upazila ) {
            $query->whereHas( 'userDetail.upazila', function ( $q ) use ( $upazila ) {
                $q->where( 'name', $upazila );
            } );
        }

        if ( $area ) {
            $query->whereHas( 'userDetail', function ( $q ) use ( $area ) {
                $q->where( 'area', 'LIKE', '%' . $area . '%' );
            } );
        }

        $users = $query->get()
            ->map( fn( $user ) => [
                'id'      => $user->id,
                'phone'   => $user->phone,
                'role'    => $user->roles->pluck( 'name' ),
                'details' => [
                    'name'     => $user->userDetail->name ?? null,
                    'division' => $user->userDetail->division->name ?? null,
                    'district' => $user->userDetail->district->name ?? null,
                    'upazila'  => $user->userDetail->upazila->name ?? null,
                    'area'     => $user->userDetail->area ?? null,
                ],
            ] );

        return $this->successResponse( $users, 'Users fetched successfully' );
    }

}
