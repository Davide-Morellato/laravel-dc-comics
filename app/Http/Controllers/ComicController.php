<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comic;

class ComicController extends Controller
{
    public function home(){
        return view('home');
    }

    public function index(){

        $comics = Comic::all();

        return view('comics.index', compact('comics'));
    }

    public function create(){
        return view('comics.create');
    }

    public function show(Comic $comic){

        return view('comics.show', compact('comic'));
    }

    public function store(Request $request){

        $request->validate([
            'title'=>'required|max:255',
            'description'=>'required|max:2000',
            'thumb'=>'required|url|nullable',
            'price'=>'required',
            'series'=>'required',
            'sale_date'=>'required',
            'type'=>'required'
        ]);

        $form_data = $request->all();

        $new_comic = Comic::create($form_data);

        return to_route('comic.show', $new_comic);
    }

    public function edit(Comic $comic){
        return view('comics.edit', compact('comic'));
    }

    public function update(Request $request, Comic $comic){
        
        $request->validate([
            'title'=>'required|max:255',
            'description'=>'required|max:2000|min:30',
            'thumb'=>'required|url|nullable',
            'price'=>'required',
            'series'=>'required',
            'sale_date'=>'required',
            'type'=>'required'
        ]);
        

        $form_data = $request->all();

        $comic->fill($form_data);

        $comic->save();

        return to_route('comic.show', $comic);

    }

    public function destroy(Comic $comic){

        $comic->delete();

        return to_route('comic.index');
    }


}
