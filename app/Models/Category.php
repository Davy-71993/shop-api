<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [ 'name', 'parent_category_id' ];

    public function parentCategory(){
        return $this->belongsTo(ParentCategory::class);
    }

    public function listings(){
        return $this->hasMany(Listing::class);
    }

    public function brands(){
        return $this->belongsToMany(Brand::class);
    }
}
