<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Review;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::all();
        $products = Product::with(['galleries'])
            ->take(8)
            ->latest()
            ->get();

        return view('pages.home', [
            'categories' => $categories,
            'products' => $products,
        ]);
    }

    public function storeProfile($slugSeller)
    {
        $seller = User::where('store_slug', $slugSeller)->firstOrFail();

        $productIds = Product::where('users_id', $seller->id)->pluck('id');

        $productsSeller = Product::with(['galleries', 'user', 'category'])
            ->where('users_id', $seller->id)
            ->get();

        $reviews = Review::with(['user', 'product'])
            ->whereIn('products_id', $productIds)
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRating = $reviews->sum('rate');
        $reviewCount = $reviews->count();
        $averageRating = $reviewCount > 0 ? $totalRating / $reviewCount : 0;
        $roundedRating = round($averageRating, 1);

        return view('pages.store-home', [
            'seller' => $seller,
            'productsSeller' => $productsSeller,
            'reviews' => $reviews,
            'reviewCount' => $reviewCount,
            'roundedRating' => $roundedRating,
        ]);
    }
}
