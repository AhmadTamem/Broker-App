<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ad;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request,  $ad)
    {
        $ads = Ad::find($ad);

        $request->validate([

            'rating_value' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|max:255',
        ]);

        if ($ads->rating()->where('user_id', Auth::id())->exists()) {
            return response()->json(['error' => 'You have already evaluated this ad'], 400);
        }

        $rating = $ads->rating()->create([
            'rating_value' => $request->rating_value,
            'user_id' => Auth::user()->id,
            'comment' => $request->comment
        ]);

        return response()->json($rating, 201);
    }

    public function index(Ad $ad)
    {
        $ratings = $ad->rating()->with('user')->get();
        return response()->json($ratings);
    }
}
