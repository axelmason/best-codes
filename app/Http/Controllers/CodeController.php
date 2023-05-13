<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCodeRequest;
use App\Http\Requests\UpdateCodeRequest;
use App\Models\Image;
use App\Models\Shop;
use App\Services\CodeService;
use App\Models\Code;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CodeController extends Controller
{
    public function index(Request $r)
    {
        $query = Code::query();

        $total = $query->count();

        $codes = $query->with(['shop' => function($query) {
            $query->with('type');
        }])->simplePaginate(15, ['*'], '', (int)$r->page);

        return response()->json(compact('total', 'codes'));
    }

    public function store(StoreCodeRequest $request, CodeService $service)
    {
        $code = $service->create($request);

        return \response()->json($code);
    }

    public function show(Request $r, $codeId)
    {
        $result = [];
        $code = Code::with(['user', 'shop' => function($query) {
            $query->with('type');
        }])->find((int)$codeId);

        $result['code'] = $code;

        if(isset($r->withShops) && filter_var($r->withShops, FILTER_VALIDATE_BOOLEAN)) {
            $result['shops'] = Shop::with(['type'])->get();
        }

        return response()->json($result);
    }

    public function update(UpdateCodeRequest $request, CodeService $service, Code $code)
    {
        $result = $service->update($request, $code);

        // $result = $code->update($data);

        // return response()->json($result);
    }

    public function destroy(Code $code)
    {
        if($code->images()->exists()) $code->images()->delete();
        $code->delete();

        return response()->json('', Response::HTTP_NO_CONTENT);
    }

    public function suggestPage()
    {
        return view('suggest');
    }

    public function details($code_id) {
        $code = Code::with('images', 'shop')->findOrFail($code_id);

        return view('details', compact('code'));
    }

    public function viewed(Request $request, $code_id) {
        $key = key($request->all());
        $code = Code::find($code_id)->update([$key => $request->input($key)]);
    }

    public function adminPage()
    {
        $codes = Code::with('shop')->get();

        return view('dashboard.codes', compact('codes'));
    }

    public function uploadImages(Request $request, $codeId)
    {
        $code = Code::find($codeId);

        $images = $request->images;
        if(!empty($images)) {
            foreach ($images as $image) {
                $img = new Image();
                $img->path = $image->store("/images/codes/$code->id/", ['disk' => 'public']);
                $code->images()->save($img);
            }
        }

        return response()->json(['images' => $code->images]);
    }

    public function deleteImages(Request $request, $codeId)
    {
        $code = Code::query()->find($codeId);
        $imageId = $request->imageId;

        if($imageId) {
            $image = $code->images->where('id', $imageId)->first();
            try {
                unlink(public_path().'/storage/'.$image->path);
            } catch(Exception $e) {
                dd($e->getMessage());
            }

            $image->delete();
        }

        return response()->json(['images' => $code->images]);
    }

    public function fetchImages($codeId)
    {
        $code = Code::query()->find($codeId);

        return response()->json(['images' => $code->images]);
    }
}
