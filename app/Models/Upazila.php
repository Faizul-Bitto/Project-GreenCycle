<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Upazila extends Model {

    use HasFactory;

    public $timestamps = false;

    public function district() {

        return $this->belongsTo( District::class );
    }
}
