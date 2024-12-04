<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $divisions = [
            'Chattogram',
            'Rajshahi',
            'Khulna',
            'Barishal',
            'Sylhet',
            'Dhaka',
            'Rangpur',
            'Mymensingh',
        ];

        foreach ( $divisions as $division ) {
            DB::table( 'divisions' )->insert( [
                'name' => $division,
            ] );
        }

    }

}
