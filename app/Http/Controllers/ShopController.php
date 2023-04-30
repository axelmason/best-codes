<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\ShopType;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function adminPage()
    {
        return view('dashboard.shops');
    }

    public function top()
    {
        $shops = Shop::orderBy('top', 'desc')->take(12)->get();
        return response()->json(compact('shops'), 200);
    }

    public function get($shopAlias)
    {
        $shop = Shop::with(['codes' => function($query) {
            $query->with('images');
        }])->where('alias', $shopAlias)->first();
        $related = $shop->related();
        return view('shop', compact('shop', 'related'));
    }

    public function getRelated($shopId)
    {
        $shop = Shop::findOrFail($shopId);
        $related = Shop::where('type', $shop->type)->get();

        return response()->json(compact('related'));
    }

    public function getTypes()
    {
        $types = ShopType::all();

        return response()->json($types);
    }
}
