<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\ShopType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShopApiController extends Controller
{
    public function index(Request $r)
    {
        $shops = Shop::query();

        $total = $shops->count();

        $shops = $shops->with('type')->withCount('codes')->simplePaginate(15, ['*'], '', (int)$r->page);

        return response()->json(compact('total', 'shops'));
    }

    public function all(Request $request)
    {
        $shops = Shop::query();
        if($request->withType) $shops->with('type');

        return response()->json($shops->get());
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['alias'] = str($request->name)->slug()->value();

        $data['image'] = $request->file('image')->store('/images/shops/'.$data['alias'].'/', ['disk' => 'public']);

        Shop::create($data);
    }

    public function show($id)
    {
        $shop = Shop::with('type')->find($id);
        $types = ShopType::all();

        return response()->json(compact('shop', 'types'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $shop = Shop::find($id);
        $data['alias'] = str($request->name)->slug()->value();
        if($request->hasFile('image')) {
            Storage::disk('public')->delete($shop->image);
            $data['image'] = $request->file('image')->store('/images/shops/'.$data['alias'].'/', ['disk' => 'public']);
        }


        $shop->update($data);
    }

    public function destroy($id)
    {
        $shop = Shop::findOrFail($id);
        if($shop->image) Storage::disk('public')->delete($shop->image);

        $shop->delete();
    }
}
