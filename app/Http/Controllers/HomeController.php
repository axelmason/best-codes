<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\Shop;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $shops = Shop::with('type')->get();
        $top_codes = Code::query()->orderBy('rating')->limit(12)->get();
        return view('home', compact('shops', 'top_codes'));
    }

    public function search(Request $r) {
        $search = trim($r->input('query'));
        $shops = Shop::query()->with('type')->where('name', 'LIKE', "%{$search}%")->get();

        return view('home', compact('shops'));
    }
}
