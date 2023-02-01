<?php

namespace App\Services;

use App\Models\Code;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CodeService
{
    public function create(Request $data) {
        $code = Code::create($data->all()+[
            'user_id' => auth()->user()->id
        ]);

        $extension = $data->file('image')->getClientOriginalExtension();
        $datetime = str_replace([' ', ':'], '_', Carbon::now()->toDateTimeString());
        $filename = $datetime.'_code_'.$code->id.'_preview.'.$extension;

        $code->image = $filename;
        $code->save();

        Storage::putFileAs('public/images', $data->file('image'), $filename);

        return $code;
    }
}
