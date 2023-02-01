<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\UserCode;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $codes = Code::where('moderate_status', 'accepted')->get();

        return view('home', compact('codes'));
    }

    public function search(Request $r) {
        $search = trim($r->input('search'));
        $fields = ['code', 'title', 'description'];
        $codes = Code::query();
        foreach ($fields as $field) {
            $codes->orWhere($field, 'LIKE', "%{$search}%");
        }
        $codes = $codes->get()->where('moderate_status', 'accepted');

        return view('home', compact('codes'));
    }
}
