<?php

namespace App\Http\Controllers\Api\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequests\StorePostRequest;
use App\Http\Requests\PostRequests\UpdatePostRequest;
use App\Models\Post;
use App\Traits\ApiHttpResponses;
use Illuminate\Http\Request;

class PostController extends Controller {

    use ApiHttpResponses;

    private function handleFileUploads( $request, $post ) {

        if ( $request->hasFile( 'images' ) ) {

            foreach ( $request->file( 'images' ) as $image ) {
                $imagePath = $image->store( 'images', 'public' );
                $post->files()->create( ['url' => $imagePath, 'file_type' => 'image'] );
            }

        }

        if ( $request->hasFile( 'voice' ) ) {
            $voicePath = $request->file( 'voice' )->store( 'voices', 'public' );
            $post->files()->create( ['url' => $voicePath, 'file_type' => 'voice'] );
        }

    }

    private function deleteAssociatedFiles( $post ) {
        $post->files()->delete();
    }

    private function formatPostResponse( $post ) {
        return [
            'id'       => $post->id,
            'user_id'  => $post->user_id,
            'title'    => $post->title,
            'content'  => $post->content,
            'date'     => $post->created_at->format( 'Y-m-d H:i:s' ),
            'status'   => $post->status,
            'images'   => $post->files->where( 'file_type', 'image' )->map->only( ['id', 'url'] ),
            'voice'    => $post->files->where( 'file_type', 'voice' )->map->only( ['id', 'url'] )->first(),
            'products' => $post->products->map( function ( $product ) {
                return [
                    'id'          => $product->id,
                    'name'        => $product->name,
                    'parent_id'   => $product->parent_id,
                    'parent_name' => $product->parent ? $product->parent->name : null,
                ];
            } ),
            'user'     => [
                'id'    => $post->user->id,
                'phone' => $post->user->phone,
            ],
        ];
    }

    public function store( StorePostRequest $request ) {
        $validatedData = $request->validated();
        $user = $request->user();

        if ( !$user ) {
            return $this->errorResponse( 'Unauthorized', 401 );
        }

        $post = $user->posts()->create( [
            'title'   => $validatedData['title'],
            'content' => $validatedData['content'],
        ] );

        if ( isset( $validatedData['products'] ) ) {
            $post->products()->sync( $validatedData['products'] );
        }

        $this->handleFileUploads( $request, $post );

        return $this->successResponse(
            $this->formatPostResponse( $post ),
            'Post created successfully',
            201
        );
    }

    public function update( UpdatePostRequest $request, Post $post ) {
        $validatedData = $request->validated();

        if ( $request->user()->id !== $post->user_id ) {
            return $this->errorResponse( 'Unauthorized', 403 );
        }

        $post->update( [
            'title'   => $validatedData['title'],
            'content' => $validatedData['content'],
        ] );

        if ( isset( $validatedData['products'] ) ) {
            $post->products()->sync( $validatedData['products'] );
        }

        $this->handleFileUploads( $request, $post );
        $post->load( ['files', 'products.parent', 'user:id,phone'] );

        return $this->successResponse( $this->formatPostResponse( $post ), 'Post updated successfully' );
    }

    public function markAsSold( Post $post ) {
        $user = auth()->user();

        if ( $user->id !== $post->user_id ) {
            return $this->errorResponse( 'Unauthorized', 403 );
        }

        $post->update( ['status' => 'Sold'] );

        return $this->successResponse( null, 'Post marked as sold successfully' );
    }

    public function delete( Request $request, Post $post ) {

        if ( $request->user()->id !== $post->user_id ) {
            return $this->errorResponse( 'Unauthorized', 403 );
        }

        $this->deleteAssociatedFiles( $post );
        $post->delete();

        return $this->successResponse( null, 'Post deleted successfully' );
    }

    public function index() {
        $posts = Post::with( 'files', 'products' )->get();
        return $this->successResponse( $posts );
    }

    public function show( Post $post ) {

        if ( !auth()->check() || auth()->user()->id !== $post->user_id ) {
            return $this->errorResponse( 'Unauthorized', 403 );
        }

        $post->load( ['files', 'products.parent', 'user:id,phone'] );

        return $this->successResponse( $this->formatPostResponse( $post ) );
    }

    public function allActivePosts() {
        $user = auth()->user();

        $posts = Post::where( 'status', 'Active' )
            ->where( 'user_id', '!=', $user->id )
            ->with( ['files', 'products.parent', 'user:id,phone'] )
            ->get()
            ->map( fn( $post ) => $this->formatPostResponse( $post ) );

        return $this->successResponse( $posts, 'All Active Posts fetched successfully' );
    }

    public function userOwnPosts() {
        $user = auth()->user();

        $posts = $user->posts()
            ->with( ['files', 'products.parent'] )
            ->orderByRaw( "FIELD(status, 'Active', 'Sold')" )
            ->get()
            ->map( fn( $post ) => $this->formatPostResponse( $post ) );

        $response = [
            'posts' => $posts,
            'user'  => [
                'id'    => $user->id,
                'phone' => $user->phone,
            ],
        ];

        return $this->successResponse( $response );
    }

}
