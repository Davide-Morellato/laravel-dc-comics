@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container">
    <div class="row">
        <h1>
            Questa è la Home
        </h1>

        <div>
            <a href="{{route('comic.index')}}" class="btn btn-primary">
                Go to index
            </a>
        </div>
    </div>
</div>
@endsection