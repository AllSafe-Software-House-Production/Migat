<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\UserResponseTrait;
use App\Models\Favorite;
use App\Models\Hotel;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    use UserResponseTrait;

    public function index(Request $request)
    {
        $user = $request->user();

        $favorites = $user->favoriteHotels()->with('media')->get();

        return $this->success([
            'favorites' => $favorites
        ], 'Favorites fetched successfully');
    }

    public function toggle(Request $request, $hotelId)
    {
        $user = $request->user();
        $hotel = Hotel::findOrFail($hotelId);

        $favorite = Favorite::where('user_id', $user->id)
            ->where('hotel_id', $hotelId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $message = 'Hotel removed from favorites.';
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'hotel_id' => $hotelId,
            ]);
            $message = 'Hotel added to favorites.';
        }

        return $this->success([], $message);
    }
}
