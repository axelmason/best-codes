@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    <div class="container mx-auto">
        <code-details :code="{{ json_encode($code) }}"></code-details>
    </div>
@endsection
