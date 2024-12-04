<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\User_Detail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SuperAdminUserSeeder extends Seeder {
    /**
     * Run the database seeds.
     */

    private $permissions = [
        'role-list',
        'role-create',
        'role-edit',
        'role-delete',
        'product-list',
        'product-create',
        'product-edit',
        'product-delete',
        'create posts',
        'edit posts',
        'delete posts',
        'view own posts',
        'view all posts',
        'edit profile',
        'delete profile',
    ];

    /**
     * Seed the application's database.
     */
    public function run(): void {

        foreach ( $this->permissions as $permission ) {
            Permission::create( ['name' => $permission] );
        }

        // Create Super Admin role and assign all permissions
        $superAdminRole = Role::create( ['name' => 'Super Admin'] );
        $superAdminPermissions = Permission::pluck( 'id', 'id' )->all();
        $superAdminRole->syncPermissions( $superAdminPermissions );

        // Create additional roles and assign permissions
        $householdRole = Role::create( ['name' => 'Household'] );
        $householdPermissions = [
            'product-list',
            'view own posts',
            'view all posts',
            'edit profile',
        ];
        $householdRole->syncPermissions( $householdPermissions );

        $officeRole = Role::create( ['name' => 'Office'] );
        $officePermissions = [
            'product-list',
            'product-create',
            'view own posts',
            'view all posts',
            'edit profile',
        ];
        $officeRole->syncPermissions( $officePermissions );

        $restaurantRole = Role::create( ['name' => 'Restaurant'] );
        $restaurantPermissions = [
            'product-list',
            'product-create',
            'product-edit',
            'view own posts',
            'view all posts',
            'edit profile',
        ];
        $restaurantRole->syncPermissions( $restaurantPermissions );

        $shoppingMallRole = Role::create( ['name' => 'Shopping Mall'] );
        $shoppingMallPermissions = [
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
            'view all posts',
            'edit profile',
        ];
        $shoppingMallRole->syncPermissions( $shoppingMallPermissions );

        $institutionRole = Role::create( ['name' => 'Institution'] );
        $institutionPermissions = [
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
            'create posts',
            'edit posts',
            'view all posts',
            'edit profile',
        ];
        $institutionRole->syncPermissions( $institutionPermissions );

        $factoryRole = Role::create( ['name' => 'Factory'] );
        $factoryPermissions = [
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
            'create posts',
            'edit posts',
            'view all posts',
            'edit profile',
        ];
        $factoryRole->syncPermissions( $factoryPermissions );

        $vangariRole = Role::create( ['name' => 'Vangari'] );
        $vangariPermissions = [
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
            'create posts',
            'edit posts',
            'view all posts',
            'edit profile',
        ];
        $vangariRole->syncPermissions( $vangariPermissions );

        $wasteCollectorRole = Role::create( ['name' => 'Waste Collector'] );
        $wasteCollectorPermissions = [
            'view own posts',
            'view all posts',
            'edit profile',
        ];
        $wasteCollectorRole->syncPermissions( $wasteCollectorPermissions );

        $recyclingCompanyRole = Role::create( ['name' => 'Recycling Company'] );
        $recyclingCompanyPermissions = [
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
            'create posts',
            'edit posts',
            'view all posts',
            'edit profile',
        ];
        $recyclingCompanyRole->syncPermissions( $recyclingCompanyPermissions );

        // Create admin User and assign the role to him.
        $user = User::create( [
            'phone'    => '21434343434',
            'password' => Hash::make( '1234' ),
        ] );

        $user->assignRole( [$superAdminRole->id] );

        // Create user details
        $userDetail = new User_Detail( [
            'name' => 'Super Admin',
        ] );

        // Associate the details with the user
        $user->userDetail()->save( $userDetail );
    }

}
