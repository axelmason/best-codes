@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    <div class="container mx-auto">
        <home-page :shops="{{ json_encode($shops) }}" :top-codes="{{ json_encode($top_codes??null) }}"></home-page>
    </div>
@endsection
