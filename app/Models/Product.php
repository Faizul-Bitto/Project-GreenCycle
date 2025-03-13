<?php

namespace App\Models;

use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model {

    use HasFactory, NodeTrait;

    protected $fillable = ['name'];

    public $timestamps = false;

    public function posts() {

        return $this->belongsToMany( Post::class, 'post_products' );
    }
}
