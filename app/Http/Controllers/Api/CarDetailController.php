<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\CarDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
class CarDetailController extends Controller
{
    public function index(){
        return CarDetail::with('ad','ad.user','ad.image','ad.rating')->get();
    }
    public function store (Request $request,$ad){
        $ad=Ad::find($ad);
        if ($ad->category_id == 1) {
            $request->validate([
                'car_condition' => 'required',
                'make'=> 'required',
                'vehicle_class'=> 'required',
                'transmission'=> 'required',
                'manufacturing_year'=> 'required|numeric',
                'kilometers'=> 'required|numeric',
                'color'=> 'required',
                'fuel'=> 'required',
                'engine_capacity'=> 'required',
                'seller_type'=> 'required',
                
            ]);
            $ad->carDetail()->create($request->all());
            return response()->json(['status' => 'success', 'message' => 'Successfully added ad cars'], 201);
    }
}
    public function update (Request $request,$id){
        $id=CarDetail::find($id);
      
        if (!$id) {
            return response()->json([
                'status' => 'error',
                'message' => 'id not found',
                ], 404);
    }
    $request->validate([
        'car_condition' => "nullable",
        'make'=> "nullable",
        'vehicle_class'=> "nullable",
        'transmission'=> "nullable",
        'manufacturing_year'=> "nullable|numeric",
        'kilometers'=> "nullable|numeric",
        'color'=> "nullable",
        'fuel'=> "nullable",
        'engine_capacity'=> "nullable",
        'seller_type'=> "nullable",
        
    ]);

    $id->update($request->all());
    return response()->json(["status"=> "success", "message"=> "update car detail successfully"],200);

}
}