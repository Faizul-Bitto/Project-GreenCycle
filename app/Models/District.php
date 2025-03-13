<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends Model {

    use HasFactory;

    public $timestamps = false;

    public function division() {

        return $this->belongsTo( Division::class );
    }

    public function upazilas() {

        return $this->hasMany( Upazila::class );
    }
}
