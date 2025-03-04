<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Auth;

use App\Models\Product;

use App\Models\User;

class DisplayController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Product::where('del_flg', 0);
        $products = $query->get();

        return view('home', [
            'user' => $user,
            'products' => $products,
        ]);
    }
    
    public function search(Request $request)
    {
        $query = $request->input('query');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        $products = Product::query();

        if (!empty($query)) {
            $products->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%");
            });
        }

        if (!empty($minPrice)) {
            $products->where('price', '>=', $minPrice);
        }

        if (!empty($maxPrice)) {
            $products->where('price', '<=', $maxPrice);
        }

        $products = $products->get();

        return view('home', compact('products'));
    }

    
}
