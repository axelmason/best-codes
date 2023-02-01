@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    <div class="container mx-auto">
        <home-page :codes="{{ json_encode($codes) }}"></home-page>
    </div>
@endsection
