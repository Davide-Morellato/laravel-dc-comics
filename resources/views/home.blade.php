@extends('layouts.app')

@section('title', 'Home')

@section('content')
<section class="centered">
    <div class="container">
        <div class="row text-center">
            <audio autoplay>
                <source src="/audio/laugh.mp3" type="audio/mp3">
            </audio>
            <div class="text-white">
                <h1 class="bold fs-70">
                    Follow Me.....
                </h1>
                <img class="inverted" src="{{Vite::asset('resources/image/joker-minimal-art.jpg')}}" alt="">
            </div>
            <div class="fade-in-text">
                <a href="{{route('comic.index')}}" class="text-danger">
                    Why not?
                </a>
            </div>
        </div>
    </div>
</section>
@endsection