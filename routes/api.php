<?php

use App\Http\Controllers\Api\Address\DistrictController;
use App\Http\Controllers\Api\Address\DivisionController;
use App\Http\Controllers\Api\Address\UpazilaController;
use App\Http\Controllers\Api\Admin\ManageUserController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\BothBuyAndSellUsers\GetBothBuyAndSellUsersController;
use App\Http\Controllers\Api\Post\PostController;
use App\Http\Controllers\Api\Products\ProductController;
use App\Http\Controllers\Api\RolesAndPermissions\PermissionController;
use App\Http\Controllers\Api\RolesAndPermissions\RoleController;
use App\Http\Controllers\Api\Users\UserProfileController;
use Illuminate\Support\Facades\Route;

/*
-----------------------------------------------------------
==== Authentication Starts Here  ===
-----------------------------------------------------------
 */

// Public Routes for authentication

// Public Route for user registration
Route::POST( '/register-part1', [RegisterController::class, 'createUser'] )->name( 'createUser' );
// Private Route for user details
Route::post( 'register-part2/{user}/details', [RegisterController::class, 'addUserInformation'] )->name( 'addUserInformation' );

// Public Route for user login
Route::post( '/login', [LoginController::class, 'login'] )->name( 'login' )->middleware( 'guest' );

// Private Route for Logout
Route::middleware( 'auth:sanctum' )->group( function () {
    Route::post( '/logout', [LogoutController::class, 'logout'] )->name( 'logout' ); // Route for user logout
} );

/*
-----------------------------------------------------------
==== Authentication Ends Here  ===
-----------------------------------------------------------
 */

/*
-----------------------------------------------------------
==== Address Starts Here  ===
-----------------------------------------------------------
 */
// Route for listing all divisions, districts, upazilas
Route::get( '/divisions', [DivisionController::class, 'index'] )->name( 'divisions.index' );
Route::get( '/districts', [DistrictController::class, 'index'] )->name( 'districts.index' );
Route::get( '/upazilas', [UpazilaController::class, 'index'] )->name( 'upazilas.index' );

/*
-----------------------------------------------------------
==== Address Ends Here  ===
-----------------------------------------------------------
 */

/*
-----------------------------------------------------------
==== Roles Starts Here  ===
-----------------------------------------------------------
 */

// Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');

// Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');

// Route::get('/roles/{role}', [RoleController::class, 'show'])->name('roles.show');

// Route::patch('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');

// Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

/*
-----------------------------------------------------------
==== Roles Ends Here  ===
-----------------------------------------------------------
 */

/*
-----------------------------------------------------------
==== Permissions Starts Here  ===
-----------------------------------------------------------
 */

// Route::get('/permissions', [PermissionController::class, 'index']);
/*
-----------------------------------------------------------
==== Permissions Ends Here  ===
-----------------------------------------------------------
 */

Route::get( '/images/{filename}', function ( $filename ) {
    $path = storage_path( 'app/public/images/' . $filename );

    if ( !file_exists( $path ) ) {
        abort( 404 );
    }

    return response()->file( $path );
} );

Route::get( '/voices/{filename}', function ( $filename ) {
    $path = storage_path( 'app/public/voices/' . $filename );

    if ( !file_exists( $path ) ) {
        abort( 404 );
    }

    return response()->file( $path );
} );

/*
-----------------------------------------------------------
==== Posts Starts Here  ===
-----------------------------------------------------------
 */
Route::middleware( 'auth:sanctum' )->group( function () {
    // Routes for creating, updating, deleting, and retrieving posts
    Route::post( 'post/create', [PostController::class, 'store'] );
    Route::put( 'post/update/{post}', [PostController::class, 'update'] );
    Route::put( '/post/mark-as-sold/{post}', [PostController::class, 'markAsSold'] );
    Route::delete( 'posts/{post}', [PostController::class, 'delete'] );

    Route::get( 'post/show/{post}', [PostController::class, 'show'] );

    // Route for retrieving all active posts
    Route::get( 'activePosts', [PostController::class, 'allActivePosts'] );

    // Route for retrieving posts belonging to the authenticated user
    Route::get( 'user/ownPosts', [PostController::class, 'userOwnPosts'] );
} );

/*
-----------------------------------------------------------
==== Posts Ends Here  ===
-----------------------------------------------------------
 */

/*
-----------------------------------------------------------
==== Users Starts Here  ===
-----------------------------------------------------------
 */
Route::middleware( 'auth:sanctum' )->group( function () {
    Route::put(
        '/users/{user}/update-phone',
        [UserProfileController::class, 'updatePhone']
    );
    Route::put( '/users/{user}/update-password', [UserProfileController::class, 'updatePassword'] );

    // User details routes
    Route::put( '/users/{user}/details', [UserProfileController::class, 'updateUserDetails'] );

    Route::get( '/bothBuyAndSellUsers/by-roles', [GetBothBuyAndSellUsersController::class, 'getBothBuyAndSellUsersByRoles'] );
    Route::get( '/users/search', [GetBothBuyAndSellUsersController::class, 'searchUsers'] );
} );
/*
-----------------------------------------------------------
==== Users Ends Here  ===
-----------------------------------------------------------
 */

Route::middleware( ['auth:sanctum', 'role:Super Admin'] )->group( function () {

    // Manage Users
    Route::get( '/manageUsers', [ManageUserController::class, 'userList'] );

    Route::put( '/manageUsers/{user}/update-phone', [ManageUserController::class, 'updatePhone'] );
    Route::put( '/manageUsers/{user}/update-password', [ManageUserController::class, 'updatePassword'] );

    Route::put( '/manageUsers/{user}/details', [ManageUserController::class, 'updateUserDetails'] );
    Route::get( '/manageUsers/{user}/details', [ManageUserController::class, 'userDetails'] );

    Route::get( '/manageUsers/{user}', [ManageUserController::class, 'showUser'] );

    Route::delete( '/manageUsers/{user}', [ManageUserController::class, 'destroyUser'] );

    // Manage Roles
    Route::get( '/roles', [RoleController::class, 'index'] )->name( 'roles.index' );
    Route::post( '/roles', [RoleController::class, 'store'] )->name( 'roles.store' );
    Route::get( '/roles/{role}', [RoleController::class, 'show'] )->name( 'roles.show' );
    Route::patch( '/roles/{role}', [RoleController::class, 'update'] )->name( 'roles.update' );
    Route::delete( '/roles/{role}', [RoleController::class, 'destroy'] )->name( 'roles.destroy' );

    // Manage Permissions
    Route::get( '/permissions', [PermissionController::class, 'index'] );

    // Get all the posts of all users
    Route::get( 'posts', [PostController::class, 'index'] );
} );

/*
-----------------------------------------------------------
==== Products Starts Here  ===
-----------------------------------------------------------
 */
Route::get( 'products', [ProductController::class, 'index'] );
Route::post( 'products', [ProductController::class, 'store'] );
Route::get( 'products/{product}', [ProductController::class, 'show'] );
Route::put( 'products/{product}', [ProductController::class, 'update'] );
Route::delete( 'products/{product}', [ProductController::class, 'destroy'] );
/*
-----------------------------------------------------------
==== Products Ends Here  ===
-----------------------------------------------------------
 */
