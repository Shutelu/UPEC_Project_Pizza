<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pizza;

class PizzaController extends Controller
{
    //route index
    public function index(){
        $pizza = Pizza::all();
        return view('index',['pizza' => $pizza]);
    }

    //ajout
    public function ajout_form(){
        return view('pizza_ajout');
    }

    //faire validation
    public function ajout_pizza(Request $request){
        $valid = $request->validate([
            'nom' => 'required|alpha|min:1|max:20',
            'desc' => 'required|alpha|min:1|max:200',
            'prix' => 'bail|required|integer|gte:1|lte:120'
        ]);

        $pizza = new Pizza();
        $pizza->nom = $valid['nom'];
        $pizza->description = $valid['desc'];
        $pizza->prix = $valid['prix'];
        $pizza->save();

        return redirect()->route('index');
    }
    
    //edit 
    public function edit_form($id){

        $pizza = Pizza::findOrFail($id);
        return view('pizza_edit',['pizza'=>$pizza]);
    }

    public function edit_pizza(Request $request,$id){
        $valid = $request->validate([
            'nom' => 'required|alpha|min:1|max:20',
            'desc' => 'required|alpha|min:1|max:200',
            'prix' => 'bail|required|integer|gte:1|lte:120'
        ]);

        $pizza = Pizza::findOrFail($id);

        $pizza->nom = $valid['nom'];
        $pizza->description = $valid['desc'];
        $pizza->prix = $valid['prix'];
        $pizza->save();

        return redirect()->route('index');
    }
}
