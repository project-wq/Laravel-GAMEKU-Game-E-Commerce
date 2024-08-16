<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $id)
    {
        $product = Product::with(['galleries', 'user', 'category'])
            ->where('slug', $id)
            ->firstOrFail();
        
        $productsSeller = Product::with(['galleries', 'user', 'category'])
            ->where('users_id', $product->users_id)
            ->get();

        $reviews = Review::with(['user', 'product'])
            ->where('products_id', $product->id)
            ->orderBy('created_at', 'desc')
            ->paginate(3);
        $reviewCount = $reviews->count();

        $rateSum = Review::with(['user', 'product'])
            ->where('products_id', $product->id)
            ->get()
            ->sum('rate');

        $totalRateSum = Review::with(['user', 'product'])
            ->where('products_id', $product->id)
            ->count();

        /*  dd($totalRateSum); */

        if ($rateSum !== null && $rateSum !== 0) {
            $rate = number_format($rateSum / $totalRateSum, 1);
        } else {
            $rate = number_format(0, 1);
        }

        /* foreach ($reviews as $review) {
            $rateSum += $review->rate;
        } */

        /* dd($rate); */

        return view('pages.detail', [
            'product' => $product,
            'productsSeller' => $productsSeller,
            'reviews' => $reviews,
            'reviewCount' => $reviewCount,
            'rate' => $rate,
        ]);
    }

    public function add(Request $request, $id)
    {   
    
        $userId = Auth::user()->id;

        $cartItem = Cart::where('products_id', $id)->where('users_id', $userId)->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            $data = [
                'products_id' => $id,
                'users_id' => $userId,
                'quantity' => $request->quantity,
            ];

            Cart::create($data);
        }

        return redirect()->route('cart');
    }
}
