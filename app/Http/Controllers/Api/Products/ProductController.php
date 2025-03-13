<?php

namespace App\Http\Controllers\Api\Products;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Traits\ApiHttpResponses;
use App\Http\Controllers\Controller;

class ProductController extends Controller {

    use ApiHttpResponses;

    public function index() {

        $products = Product::get()->toTree();

        return $this->successResponse( $products );
    }

    public function store( Request $request ) {

        $data = $request->validate( [
            'name'      => 'required|string|max:255',
            'parent_id' => 'nullable|exists:products,id',
        ] );

        $parent  = Product::find( $data['parent_id'] );
        $product = new Product( ['name' => $data['name']] );

        if ( $parent ) {
            $parent->appendNode( $product );
        } else {
            $product->saveAsRoot();
        }

        return $this->successResponse( $product, 'Product created successfully', 201 );
    }

    public function show( Product $product ) {

        $product->load( 'descendants' );

        return $this->successResponse( $product );
    }

    public function update( Request $request, Product $product ) {

        $data = $request->validate( [
            'name'      => 'sometimes|required|string|max:255',
            'parent_id' => 'nullable|exists:products,id',
        ] );

        if ( isset( $data['parent_id'] ) ) {
            $parent = Product::find( $data['parent_id'] );
            $product->appendToNode( $parent )->save();
        }

        $product->update( $data );

        return $this->successResponse( $product, 'Product updated successfully' );
    }

    public function destroy( Product $product ) {

        $product->delete();

        return $this->successResponse( null, 'Product deleted successfully', 204 );
    }

}
