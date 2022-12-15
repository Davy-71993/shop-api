<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'price', 'name', 'description', 
        'quantity', 'condition', 'brand_id', 'user_id',
        'category_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    // public function buyers(){
    //     return $this->belongsToMany(Profile::class);
    // }

    public function curts(){
        return $this->belongsToMany(Curt::class);
    }

    public function ratings(){
        return $this->hasMany(Rating::class);
    }

    // public function rating(){
    //     $ratings = $this->ratings;
    //     $values = [];
    //     foreach ($ratings as $rating) {
    //         // $values.push($rating->value);
    //     }
    //     $count = $this->ratings->count();
    //     return $ratings;
    // }

    public function location(){
        return $this->hasOne(Location::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function rating(){
        $rates = $this->ratings;
        $value = 0;

        foreach ($rates as $rate) {
            $value += $rate->value;
        }

        if($rates->count() == 0){
            return 0;
        }

        return $value/$rates->count();
    }

}
