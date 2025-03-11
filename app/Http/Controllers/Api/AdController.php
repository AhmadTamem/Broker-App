<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdController extends Controller
{

    public function index()
    {
        return Ad::with('user', 'category','image','rating')->get();
    }
    public function ad_user (){
        $user=\Illuminate\Support\Facades\Auth::user()->id;
        
        return Ad::with( 'category','image','rating','carDetail','propertyDetail')->where('user_id',$user)->get();
        
    }



    //{post} add ad ,,,,, form_data api
    public function store(Request $request)
    {

    

        // Validate the request
        $fields = $request->validate([
            "title" => "required|max:255",
            "description" => "required",
            "price" => "required|numeric",
            "location" => "required",
            "category_id" => "nullable",
            'offer_type' => 'required',
            'type_ad' => "required|in:request,ad",
           
        ]);
        if($fields['type_ad'] == "ad"){

        $category = $request->get('category');
        $categories = Category::where("name", $category)->first();
        $fields['category_id'] = $categories->id;
        }



        $ad = $request->user()->ad()->create($fields);


        return response()->json(['status' => 'success', 'message' => 'Successfully added ad ','id'=>$ad->id], 201);
    }
    public function show($id)
    {
        $ad = Ad::find($id);
        return response()->json(['status' => 'success', 'message' => 'Successfully', "data" => $ad], 200);
    }
    public function update(Request $request, Ad $ad)
    {
        Gate::authorize('modify', $ad);
        $fileds = $request->validate([
            "title" => "nullable|max:255",
            "description" => "nullable",
            "price" => "nullable",
            "location" => "nullable",
            "status"=>"nullable"
        ]);
        $ad->update($fileds);
        return response()->json(["status" => "success", "message" => "Successfully updated ad", "data" => $ad], 200);
    }
    public function destroy(Ad $ad)
    {
        Gate::authorize('modify', $ad);
        $ad->delete();
        return response()->json(["status" => "success", "message" => "Successfully deleted ad"], 200);
    }
    

    public function searchAds(Request $request)
    {
       
        $request->validate([
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'category' => 'nullable|string',
            'min_price' => 'nullable|numeric',
            'max_price' => 'nullable|numeric',
        ]);

      
        $query = Ad::query();

       
        if ($request->filled('title')) {
            $query->where('title', 'LIKE', "%{$request->title}%");
        }

        if ($request->filled('description')) {
            $query->where('description', 'LIKE', "%{$request->description}%");
        }

        if ($request->filled('location')) {
            $query->where('location', 'LIKE', "%{$request->location}%");
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

if ($request->filled('min_price') && $request->filled('max_price')) {
    $query->whereBetween('price', [$request->min_price, $request->max_price]);
} 

     
        $ads = $query->get();

       
        foreach ($ads as $ad) {
            if ($ad->category->name === 'car') {
             
                $ad->load('image', 'carDetail','rating');
            } elseif ($ad->category->name === 'real_estate') {
                
                $ad->load('rating', 'propertyDetail','image');
            }
        }
 if (!$request->filled('title') && !$request->filled('description') && !$request->filled('location') && !$request->filled('category') && !$request->filled('min_price') && !$request->filled('max_price')) {
    return response()->json(null);
}

       
        return response()->json($ads);
    }

    public function view(Request $request,Ad $ad){
        $fileds=$request->validate([
            "views" => 'nullable|numeric',
        ]);
        $ad->update($fileds);
        return response()->json(["status" => "success", "message" => "Successfully updated ad views", "data" => $fileds], 200);
    }

}
