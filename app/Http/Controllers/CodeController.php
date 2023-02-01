<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCodeRequest;
use App\Http\Requests\UpdateCodeRequest;
use App\Services\CodeService;
use App\Models\Code;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CodeController extends Controller
{
    public function index()
    {
        $codes = Code::orderBy('moderate_status')->get();

        return response()->json($codes);
    }

    public function store(StoreCodeRequest $request, CodeService $service)
    {
        $code = $service->create($request);

        return \response()->json($code);
    }

    public function show(Code $code)
    {
        return response()->json($code->with(['users'])->get());
    }

    public function update(UpdateCodeRequest $request, Code $code)
    {
        $result = $code->update($request->all());
        $code->save();

        return response()->json($result);
    }

    public function destroy(Code $code)
    {
        $code->delete();

        return response()->json('', Response::HTTP_NO_CONTENT);
    }

    public function suggestPage()
    {
        return view('suggest');
    }

    public function details($code_id) {
        $code = Code::find($code_id);
        if($code and $code->moderate_status == 'accepted') {
            return view('details', compact('code'));
        }
        abort(404);
    }

    public function viewed(Request $request, $code_id) {
        $key = key($request->all());
        $code = Code::find($code_id)->update([$key => $request->input($key)]);
    }
}
