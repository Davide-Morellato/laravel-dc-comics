@extends('layouts.app')

@section('title', 'Comics')

@section('content')
@include('partials.header')

<section>
    <div class="container">
        <div class="row gy-4 list-unstyled">
            @foreach($comics as $comic)
            <ul class="col-4 fade-in-comic">
                <li class="card h-100 text-center">
                    <img src="{{$comic->thumb}}" class="h-75 w-100" alt="comic_image">
                    <div class="card-body">
                        <h5 class="card-title">{{$comic->title}}</h5>
                        <p class="card-text">{{$comic->series}}</p>
                        <p class="card-text">{{$comic->sale_date}}</p>
                        <a href="{{route('comic.show', $comic)}}" class="mt-4 btn btn-warning text-primary fw-bold">Details</a>
                    </div>
                </li>
            </ul>
            @endforeach
        </div>
    </div>
</section>

@include('partials.footer')
@endsection