@extends('layouts.app')

@section('title', 'Comics')

@section('content')
@include('partials.header')

<section>
    <div class="container">
        <ul class="row gy-4 list-unstyled">
            @foreach($comics as $comic)
            <li class="col-4">
                <div class="card h-100">
                    <img src="{{$comic->thumb}}" class="h-50 w-100" alt="comic_image">
                    <div class="card-body">
                        <h5 class="card-title">{{$comic->title}}</h5>
                        <p class="card-text">{{$comic->series}}</p>
                        <p class="card-text">{{$comic->sale_date}}</p>
                        <p class="card-text">{{$comic->description}}</p>
                        <a href="{{route('comic.show', $comic)}}" class="btn btn-primary">go to Show for more details</a>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</section>

@include('partials.footer')
@endsection