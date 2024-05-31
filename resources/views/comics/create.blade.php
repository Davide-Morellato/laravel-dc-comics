@extends('layouts.app')

@section('title', 'Create Comic')

@section('content')
<section>
    <div class="container w-50 m-auto py-5">
        <div class="row">
            <div class="text-center py-3">
                <h2 class="text-white fs-4">
                    Crea il fumetto
                </h2>
            </div>
            <form action="{{route('comic.store')}}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label text-white">Titolo</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Inserisci Titolo">
                </div>
                <div class="mb-3">
                    <label for="thumb" class="form-label text-white">Inserisci Percorso immagine</label>
                    <input type="text" class="form-control" name="thumb" id="thumb" placeholder="....">
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label text-white">Prezzo</label>
                    <input type="text" name="price" class="form-control" id="price" placeholder="Inserisci Prezzo">
                </div>
                <div class="mb-3">
                    <label for="series" class="form-label text-white">Series</label>
                    <input type="text" name="series" class="form-control" id="series" placeholder="Inserisci Series">
                </div>
                <div class="mb-3">
                    <label for="sale_date" class="form-label text-white">Data</label>
                    <input type="text" name="sale_date" class="form-control" id="sale_date" placeholder="Inserisci Data">
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label text-white">Tipologia</label>
                    <input type="text" name="type" class="form-control" id="type" placeholder="Inserisci Tipologia">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label text-white">Descrizione</label>
                    <textarea class="form-control" name="description" id="description" rows="8"></textarea>
                </div>
                <div class="d-flex justify-content-evenly pt-3">
                    <button class="btn btn-success text-white fw-bold">Invia comics</button>
                    <a href="{{route('comic.index')}}" class="btn btn-warning text-primary fw-bold">Go Back</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection