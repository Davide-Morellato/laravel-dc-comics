@extends('layouts.app')

@section('title', 'Edit Comic')

@section('content')
<section>
    <div class="container w-50 m-auto py-5">
        <div class="row">
            <div class="text-center py-3 text-white fs-4">
                <h2>
                    Edita il fumetto:
                </h2>
                <h3>
                    {{$comic->title}}
                </h3>
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
                    <input type="text" class="form-control" name="thumb" id="thumb" value="{{old('thumb', $comic->thumb)}}">
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label text-white">Prezzo</label>
                    <input type="text" name="price" class="form-control" id="price" value="{{old('price', $comic->price)}}">
                </div>
                <div class="mb-3">
                    <label for="series" class="form-label text-white">Series</label>
                    <input type="text" name="series" class="form-control" id="series" value="{{old('series', $comic->series)}}">
                </div>
                <div class="mb-3">
                    <label for="sale_date" class="form-label text-white">Data</label>
                    <input type="text" name="sale_date" class="form-control" id="sale_date" value="{{old('sale_date', $comic->sale_date)}}">
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label text-white">Tipologia</label>
                    <input type="text" name="type" class="form-control" id="type" value="{{old('type', $comic->type)}}">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label text-white">Descrizione</label>
                    <textarea class="form-control" name="description" id="description" rows="5">{!! old('description', $comic->description) !!}</textarea>
                </div>
                <div class="d-flex justify-content-evenly pt-3">
                    <button class="btn btn-success text-white fw-bold">Invia Edit</button>
                    <a href="{{route('comic.show', $comic)}}" class="btn btn-warning text-primary fw-bold">Go Back</a>
                </div>
            </form>


            <div class="my-4 centered w-25">
                @if ( $errors->any() )
                <div class="alert alert-danger op-90">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection