<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        // Associative array with divisions and their respective districts
        $districts = [
            'Chattogram' => ['Cumilla', 'Feni', 'Brahmanbaria', 'Rangamati', 'Noakhali', 'Chandpur', 'Lakshmipur', 'Chattogram', 'Coxsbazar', 'Khagrachhari', 'Bandarban'],

            'Rajshahi'   => ['Sirajganj', 'Pabna', 'Bogura', 'Rajshahi', 'Natore', 'Joypurhat', 'Chapainawabganj', 'Naogaon'],

            'Khulna'     => ['Jashore', 'Satkhira', 'Meherpur', 'Narail', 'Chuadanga', 'Kushtia', 'Magura', 'Khulna', 'Bagerhat', 'Jhenaidah'],

            'Barishal'   => ['Jhalakathi', 'Patuakhali', 'Pirojpur', 'Barishal', 'Bhola', 'Barguna'],

            'Sylhet'     => ['Sylhet', 'Moulvibazar', 'Habiganj', 'Sunamganj'],

            'Dhaka'      => ['Narsingdi', 'Gazipur', 'Shariatpur', 'Narayanganj', 'Tangail', 'Kishoreganj', 'Manikganj', 'Dhaka', 'Munshiganj', 'Rajbari', 'Madaripur', 'Gopalganj', 'Faridpur'],

            'Rangpur'    => ['Panchagarh', 'Dinajpur', 'Lalmonirhat', 'Nilphamari', 'Gaibandha', 'Thakurgaon', 'Rangpur', 'Kurigram'],

            'Mymensingh' => ['Sherpur', 'Mymensingh', 'Jamalpur', 'Netrokona'],
        ];

        foreach ( $districts as $divisionName => $districtNames ) {
            $division = Division::where( 'name', $divisionName )->first();

            if ( $division ) {

                foreach ( $districtNames as $districtName ) {
                    $division->districts()->create( ['name' => $districtName] );
                }

            }

        }

    }

}
