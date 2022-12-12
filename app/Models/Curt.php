<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curt extends Model
{
    use HasFactory;

    public function buyer(){
        return $this->belongsTo(User::class);
    }

    public function listings(){
        return $this->belongsToMany(Listing::class);
    }
}
