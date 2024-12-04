<?php

namespace App\Models;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'date',
        'status',
    ];

    public function user() {
        return $this->belongsTo( User::class );
    }

    public function files() {
        return $this->morphMany( File::class, 'fileable' );
    }

    public function products() {
        return $this->belongsToMany( Product::class, 'post_products' );
    }
}
