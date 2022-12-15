<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingRequest;
use App\Http\Requests\StoreListingRequest;
use App\Http\Resources\ListingListResource;
use App\Http\Resources\ListingResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Listing;
use App\Models\Rating;
use App\Models\Tag;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ListingListResource::collection(Listing::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreListingRequest $request)
    {
        $brand = Brand::firstOrCreate(['name' => $request->brand]);

        $listing = Listing::create([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'condition' => $request->condition,
            'brand_id' => $brand['id'],
            'category_id' => $request->category_id,
            'user_id' => Auth::user()->id
        ]);

        $listing->location()->create($request->location);

        foreach ($request->tags as $key => $tag) {
            $tc = Tag::firstOrCreate(['name' => $tag]);
            $listing->tags()->attach($tc);
        }

        return $this->success(new ListingResource($listing));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $listing = Listing::find($id);

        return new ListingResource($listing);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rate(RatingRequest $request, $id)
    {
        
        $rating = Rating::where([
            'user_id' => Auth::user()->id,
            'listing_id' => $id
        ])->first();

        if ($rating) {
            $rating['value'] = $request->rating;
            $rating->save();

        } else {
            $rating = Rating::create([
                'user_id' => Auth::user()->id,
                'listing_id' => $id,
                'value' => $request->rating
            ]);
        }

        return $this->success(new ListingListResource(Listing::find($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request['rating']) {
        }
        return $this->success([
            'listin_id' => $id,
            'rating' => $request->rating
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
