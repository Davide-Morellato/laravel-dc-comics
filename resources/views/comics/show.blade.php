@extends('layouts.app')

@section('title', 'Comic')

@section('content')
@include('partials.header')

<section>
    <div class="container text-center">
        <div class="row gy-4 justify-content-center">
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
                        <a href="{{route('comic.index', $comic)}}" class="mt-4 btn btn-warning text-primary fw-bold">Go Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('partials.footer')
@endsection