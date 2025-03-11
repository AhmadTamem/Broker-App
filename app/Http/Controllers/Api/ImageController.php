<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function uploadImage(Request $request, int $adId)
    {
        // Validate the request
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $imageUrls = [];
        $ad = Ad::find($adId);


        if (!$ad) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ad not found',
            ], 404);
        }


        $filePath = $ad->category_id == 1 ? 'images/cars/' : 'images/real_estate/';


        foreach ($request->file('images') as $file) {

            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();


            $file->move(public_path($filePath), $fileName);


            $imagePath = $filePath . $fileName;
            $imageUrls[] = [
                'ad_id' => $ad->id,
                'image' => url($imagePath)
            ];
        }


        Image::insert($imageUrls);

        return response()->json([
            'status' => 'success',
            'message' => 'Uploaded successfully',
            'data' => $imageUrls
        ], 200);
    }
}
