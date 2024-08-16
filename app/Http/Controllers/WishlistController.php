<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {   
         $wishlists = Wishlist::with(['product', 'user'])
            ->where('users_id', Auth::user()->id)
            ->get();

        return view('pages.wishlist', [
            'wishlists' => $wishlists
        ]);
    }

    public function addWishlist(Request $request, $id)
    {
        $userId = Auth::user()->id;

        $data = [
            'products_id' => $id,
            'users_id' => $userId,
        ];

        Wishlist::create($data);
    }
}
