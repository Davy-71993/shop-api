<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [ 'longitude', 'latitude' ];

    public function listing(){
        return $this->belongsTo(Listing::class);
    }
}
