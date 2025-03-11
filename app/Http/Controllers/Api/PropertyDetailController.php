<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\PropertyDetail;
use Illuminate\Http\Request;

class PropertyDetailController extends Controller
{
    public function index(){
        return PropertyDetail::with('ad','ad.user','ad.image','ad.rating')->get();
    }
    public function store(Request $request, $ad)
    {
        $ad = Ad::find($ad);
        if ($ad->category_id == 2) {
            $request->validate([
                'area' => 'required|numeric',
                'floor_number' => 'required',
                'type_of_ownership' => 'required',
                'number_of_rooms' => 'required|numeric',
                'seller_type' => 'required',
                'furnishing' => 'required',
                'direction' => 'required',
                'condition' => 'required',

            ]);

            $ad->propertyDetail()->create($request->all());
            return response()->json(['status' => 'success', 'message' => 'Successfully added ad Property'], 201);
        }
    }
    public function update(Request $request, $id)
    {
        $id = PropertyDetail::find($id);
        if (!$id) {
            return response()->json([
                'status' => 'error',
                'message' => 'id not found',
            ], 404);
        }
        $request->validate([
            'area' => 'nullable|numeric',
            'floor_number' => 'nullable',
            'type_of_ownership' => 'nullable',
            'number_of_rooms' => 'nullable|numeric',
            'seller_type' => 'nullable',
            'furnishing' => 'nullable',
            'direction' => 'nullable',
            'condition' => 'nullable',

        ]);
        $id->update($request->all());
        return response()->json(["status" => "success", "message" => "update Property detail successfully"], 200);
    }
}
