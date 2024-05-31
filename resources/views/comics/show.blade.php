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
                        <div class="d-flex justify-content-evenly">
                            <a href="{{route('comic.edit', $comic)}}" class="mt-4 btn btn-success text-light fw-bold px-3">Edit Comic</a>

                            <!-- AGGIUNTA DEL CONFIRM DIRETTAMENTE NEL FORM [funziona]: onclick="return confirm('Sei sicuro?')" || onsubmit="return deleteFunction()" -->
                            <form action="{{route('comic.destroy', $comic)}}" method="post" onsubmit="return deleteFunction()">
                                @csrf
                                @method('DELETE')
                                <!-- NON FUNZIONA: id="btn_delete" -->
                                <button class="mt-4 btn btn-danger text-dark fw-bold">Delete Comic</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>

    //
    //NONFUNZIONA
    //
    // const btn_delete = document.getElementById('btn_delete');

    // btn_delete.addEventListener('click', function() {

    //     const del = confirm("Sei sicuro?");

    //     if (!del) {
    //         return false;
    //     }
    // })


    function deleteFunction() {

        const del = confirm("Sei sicuro?");

        if (!del) {
            return false;
        }
    }
</script>

@include('partials.footer')
@endsection