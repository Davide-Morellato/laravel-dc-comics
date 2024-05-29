@extends('layouts.app')

@section('title', 'Comic')

@section('content')
@include('partials.header')

<section>
    <div class="container">
        <div class="row gy-4">
            <div class="col-4">
                <div class="card h-100">
                        <img src="{{$comic->thumb}}" class="card-img-top" alt="comic_image">
                    <div class="card-body">
                        <h5 class="card-title">{{$comic->title}}</h5>
                        <p class="card-text">{{$comic->series}}</p>
                        <p class="card-text">{{$comic->sale_date}}</p>
                        <p class="card-text">{{$comic->type}}</p>
                        <p class="card-text">{{$comic->price}}</p>
                        <p class="card-text">{{$comic->description}}</p>
                        <a href="{{route('comic.index', $comic)}}" class="btn btn-primary">go to Index</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('partials.footer')
@endsection