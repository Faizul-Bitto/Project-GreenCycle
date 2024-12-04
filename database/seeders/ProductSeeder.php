<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {

        // Main Products
        $paper = Product::create( ['name' => 'Paper'] );
        $plastic = Product::create( ['name' => 'Plastic'] );
        $ewaste = Product::create( ['name' => 'E-waste'] );
        $metal = Product::create( ['name' => 'Metal'] );
        $glass = Product::create( ['name' => 'Glass'] );
        $textile = Product::create( ['name' => 'Textile'] );
        $rubber = Product::create( ['name' => 'Rubber'] );
        $wood = Product::create( ['name' => 'Wood'] );
        $leather = Product::create( ['name' => 'Leather'] );
        $industrial = Product::create( ['name' => 'Industrial'] );
        $packaging = Product::create( ['name' => 'Packaging'] );
        $construction = Product::create( ['name' => 'Construction'] );

// Paper Sub-products
        $paper->appendNode( Product::create( ['name' => 'Hardboard'] ) );
        $paper->appendNode( Product::create( ['name' => 'Plain Paper'] ) );
        $paper->appendNode( Product::create( ['name' => 'Newspaper'] ) );
        $paper->appendNode( Product::create( ['name' => 'Cardboard'] ) );

// Plastic Sub-products
        $plastic->appendNode( Product::create( ['name' => 'Plastic Bottle'] ) );
        $plastic->appendNode( Product::create( ['name' => 'Plastic Jar'] ) );
        $plastic->appendNode( Product::create( ['name' => 'Plastic Bag'] ) );
        $plastic->appendNode( Product::create( ['name' => 'Plastic Packaging'] ) );
        $plastic->appendNode( Product::create( ['name' => 'Plastic Container'] ) );
        $plastic->appendNode( Product::create( ['name' => 'Plastic Toy'] ) );
        $plastic->appendNode( Product::create( ['name' => 'PVC Pipe'] ) );

// E-waste Sub-products
        $mobile = Product::create( ['name' => 'Mobile'] );
        $ewaste->appendNode( $mobile );

// Mobile Sub-products
        $mobile->appendNode( Product::create( ['name' => 'Camera'] ) );
        $mobile->appendNode( Product::create( ['name' => 'Motherboard'] ) );
        $mobile->appendNode( Product::create( ['name' => 'Circuit'] ) );
        $mobile->appendNode( Product::create( ['name' => 'Screen'] ) );

// Computer Sub-products
        $computer = Product::create( ['name' => 'Computer'] );
        $ewaste->appendNode( $computer );
        $computer->appendNode( Product::create( ['name' => 'Motherboard'] ) );
        $computer->appendNode( Product::create( ['name' => 'Circuit'] ) );
        $computer->appendNode( Product::create( ['name' => 'Power Supply'] ) );
        $computer->appendNode( Product::create( ['name' => 'Hard Drive'] ) );
        $computer->appendNode( Product::create( ['name' => 'RAM'] ) );
        $computer->appendNode( Product::create( ['name' => 'Monitor'] ) );

// Laptop Sub-products
        $laptop = Product::create( ['name' => 'Laptop'] );
        $ewaste->appendNode( $laptop );
        $laptop->appendNode( Product::create( ['name' => 'Motherboard'] ) );
        $laptop->appendNode( Product::create( ['name' => 'Screen'] ) );
        $laptop->appendNode( Product::create( ['name' => 'Battery'] ) );

// Television Sub-products
        $television = Product::create( ['name' => 'Television'] );
        $ewaste->appendNode( $television );
        $television->appendNode( Product::create( ['name' => 'Screen'] ) );
        $television->appendNode( Product::create( ['name' => 'Circuit'] ) );
        $television->appendNode( Product::create( ['name' => 'Power Supply'] ) );

// Metal Sub-products
        $metal->appendNode( Product::create( ['name' => 'Iron'] ) );
        $metal->appendNode( Product::create( ['name' => 'Aluminum'] ) );
        $metal->appendNode( Product::create( ['name' => 'Copper'] ) );
        $metal->appendNode( Product::create( ['name' => 'Steel'] ) );
        $metal->appendNode( Product::create( ['name' => 'Brass'] ) );
        $metal->appendNode( Product::create( ['name' => 'Tin'] ) );

// Glass Sub-products
        $glass->appendNode( Product::create( ['name' => 'Glass Bottle'] ) );
        $glass->appendNode( Product::create( ['name' => 'Window Glass'] ) );
        $glass->appendNode( Product::create( ['name' => 'Glass Jar'] ) );
        $glass->appendNode( Product::create( ['name' => 'Glass Cup'] ) );

// Textile Sub-products
        $textile->appendNode( Product::create( ['name' => 'Cloth'] ) );
        $textile->appendNode( Product::create( ['name' => 'Wool'] ) );
        $textile->appendNode( Product::create( ['name' => 'Polyester'] ) );
        $textile->appendNode( Product::create( ['name' => 'Silk'] ) );
        $textile->appendNode( Product::create( ['name' => 'Linen'] ) );
        $textile->appendNode( Product::create( ['name' => 'Nylon'] ) );
        $textile->appendNode( Product::create( ['name' => 'Denim'] ) );

// Rubber Sub-products
        $rubber->appendNode( Product::create( ['name' => 'Tire'] ) );
        $rubber->appendNode( Product::create( ['name' => 'Rubber Gloves'] ) );
        $rubber->appendNode( Product::create( ['name' => 'Rubber Pipe'] ) );
        $rubber->appendNode( Product::create( ['name' => 'Rubber Flooring'] ) );
        $rubber->appendNode( Product::create( ['name' => 'Rubber Toy'] ) );
        $rubber->appendNode( Product::create( ['name' => 'Rubber Footwear'] ) );

// Wood Sub-products
        $wood->appendNode( Product::create( ['name' => 'Plywood'] ) );
        $wood->appendNode( Product::create( ['name' => 'Furniture'] ) );

// Leather Sub-products
        $leather->appendNode( Product::create( ['name' => 'Leather Shoes'] ) );
        $leather->appendNode( Product::create( ['name' => 'Leather Bag'] ) );
        $leather->appendNode( Product::create( ['name' => 'Leather Jacket'] ) );

// Industrial Waste Sub-products
        $industrial->appendNode( Product::create( ['name' => 'Scrap Metal'] ) );

// Packaging Sub-products
        $packaging->appendNode( Product::create( ['name' => 'Cardboard Box'] ) );
        $packaging->appendNode( Product::create( ['name' => 'Bubble Wrap'] ) );
        $packaging->appendNode( Product::create( ['name' => 'Foam Packaging'] ) );
        $packaging->appendNode( Product::create( ['name' => 'Plastic Wrap'] ) );

// Construction Sub-products
        $construction->appendNode( Product::create( ['name' => 'Cement'] ) );
        $construction->appendNode( Product::create( ['name' => 'Brick'] ) );
        $construction->appendNode( Product::create( ['name' => 'Concrete'] ) );
        $construction->appendNode( Product::create( ['name' => 'Wood'] ) );
        $construction->appendNode( Product::create( ['name' => 'Glass'] ) );
        $construction->appendNode( Product::create( ['name' => 'Metal'] ) );
        $construction->appendNode( Product::create( ['name' => 'Roof Tiles'] ) );
        $construction->appendNode( Product::create( ['name' => 'Gypsum'] ) );
    }
}
