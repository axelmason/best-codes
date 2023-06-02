@extends('layouts.app')

@section('title', 'Политика конфиденциальности')

@section('content')
    <div class="container py-5 h-[80vh] mx-auto">
        <h1 class="text-3xl">{{ config('app.name') }}</h1>
        <div class="flex my-3 gap-y-3 flex-col">
            <a class="flex items-center gap-x-3 text-blue-500 text-2xl" href="https://docs.google.com/document/d/1AcHo8ycOoffHRhiC9O4xp4NuOnGcAWaw/edit?usp=sharing&ouid=112479512065638178537&rtpof=true&sd=true">
            <img style="width: auto; height:20px" src="{{ asset('word.png') }}" alt="word">
            <span>Политика конфиденциальности</span>
            </a>
            <a class="flex items-center gap-x-3 text-blue-500 text-2xl" href="https://docs.google.com/document/d/1AcHo8ycOoffHRhiC9O4xp4NuOnGcAWaw/edit?usp=sharing&ouid=112479512065638178537&rtpof=true&sd=true">
                <img style="width: auto; height:20px" src="{{ asset('word.png') }}" alt="word">
                <span>Правила пользования</span>
                </a>
        </div>
    </div>
@endsection
