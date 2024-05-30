@extends('layouts.app')

@section('title', 'Edit Comic')

@section('content')
<section>
    <div class="container w-50 m-auto py-5">
        <div class="row">
            <div class="text-center py-3">
                <h2 class="text-white fs-4">
                    Edita il fumetto: {{$comic->title}}
                </h2>
            </div>
            <form action="{{route('comic.update', $comic)}}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label text-white">Titolo</label>
                    <input type="text" name="title" class="form-control" id="title" value="{{$comic->title}}">
                </div>
                <div class="mb-3">
                    <label for="thumb" class="form-label text-white">Percorso Immagine</label>
                    <input type="text" class="form-control" name="thumb" id="thumb" value="{{$comic->thumb}}">
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label text-white">Prezzo</label>
                    <input type="text" name="price" class="form-control" id="price" value="{{$comic->price}}">
                </div>
                <div class="mb-3">
                    <label for="series" class="form-label text-white">Series</label>
                    <input type="text" name="series" class="form-control" id="series" value="{{$comic->series}}">
                </div>
                <div class="mb-3">
                    <label for="sale_date" class="form-label text-white">Data</label>
                    <input type="text" name="sale_date" class="form-control" id="sale_date" value="{{$comic->sale_date}}">
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label text-white">Tipologia</label>
                    <input type="text" name="type" class="form-control" id="type" value="{{$comic->type}}">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label text-white">Descrizione</label>
                    <textarea class="form-control" name="description" id="description" rows="5">{!! $comic->description !!}</textarea>
                </div>
                <div class="text-center pt-3">
                    <button class="btn btn-warning text-primary fw-bold">Invia Edit</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection