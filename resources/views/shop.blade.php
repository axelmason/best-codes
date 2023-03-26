@extends('layouts.app')

@section('title', 'Магазин '.$shop->name)

@section('content')
    <div class="container mx-auto">
        <shop-page :shop="{{ json_encode($shop) }}" :related="{{ json_encode($related) }}"></shop-page>
    </div>
@endsection
