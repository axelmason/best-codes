@extends('layouts.app')

@section('title', 'Модерация')

@section('content')
    <div class="container mx-auto">
        <moderate-form :code-prop="{{ json_encode($code) }}"></moderate-form>
    </div>
@endsection
