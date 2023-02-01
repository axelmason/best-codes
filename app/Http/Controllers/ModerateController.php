<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\UserCode;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ModerateController extends Controller
{
    public function index()
    {
        $code = Code::get();
        return view('moderate.index', compact('code'));
    }

    public function open($code_id)
    {
        $code = Code::find($code_id);
        return view('moderate.details', compact('code'));
    }

    public function update($code_id, Request $r) {
        $result = Code::find($code_id)->update([
            'moderate_status' => $r->input('moderate_status'),
            'moderate_message' => $r->input('moderate_message')
        ]);

        return response()->json($result);
    }
}
