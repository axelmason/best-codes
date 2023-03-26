<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function top()
    {
        $shops = Shop::orderBy('top', 'desc')->take(12)->get();
        return response()->json(compact('shops'), 200);
    }

    public function get($shopId)
    {
        $shop = Shop::with(['codes'])->findOrFail($shopId);
        $related = $shop->related();
        return view('shop', compact('shop', 'related'));
    }

    public function getRelated($shopId)
    {
        $shop = Shop::findOrFail($shopId);
        $related = Shop::where('type', $shop->type)->get();

        return response()->json(compact('related'), 200);
    }
}
