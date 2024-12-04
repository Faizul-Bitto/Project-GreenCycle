<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Detail extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'division_id', 'district_id', 'upazila_id', 'area'];

    /**
     * Get the user that owns the user detail.
     */
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the division that the user detail belongs to.
     */
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * Get the district that the user detail belongs to.
     */
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    /**
     * Get the upazila that the user detail belongs to.
     */
    public function upazila()
    {
        return $this->belongsTo(Upazila::class);
    }
}
