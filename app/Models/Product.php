<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Product extends Model {
    use HasFactory;
    use NodeTrait;

    protected $fillable = ['name'];

    public $timestamps = false;

    public function posts() {
        return $this->belongsToMany( Post::class, 'post_products' );
    }
}
