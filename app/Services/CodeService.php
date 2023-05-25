<?php

namespace App\Services;

use App\Models\Code;
use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CodeService
{
    public function create(Request $data) {
        $code = Code::create($data->all()+[
            'user_id' => auth()->user()->id
        ]);

        if($data->has('images')) {
            foreach ($data->images as $image) {
                $img = new Image();
                $img->path = $image->store("/images/codes/$code->id/", ['disk' => 'public']);
                $code->images()->save($img);
            }
        }

        return $code;
    }

    public function update(FormRequest $request, Code $code)
    {
        $code->update($request->all());
    }
}
