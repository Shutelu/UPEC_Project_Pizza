<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pizza;
use Illuminate\Support\Facades\Auth;

class PizzaController extends Controller
{

    //pas authentifier
    public function index(){
        $pizza = Pizza::all();
        return view('index',['pizza'=>$pizza]);
    }

    //route home / une fois authentifier
    public function home(){
        $user = Auth::user();//comme on est auth on a acces a notre user
        $pizza = Pizza::all();
        return view('home',['pizza' => $pizza]);
    }

    //ajout
    public function ajout_form(){
        return view('pizza_ajout');
    }

    //faire validation
    public function ajout_pizza(Request $request){
        $valid = $request->validate([
            'nom' => 'required|alpha|min:1|max:30',
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

    //page admin
    public function admin_home(){
        return view('admin.admin_home');
    }
    
    // //autorisation voir les pizzas pour user authentifier
    // public function view(Request $request,$id){
    //     $pizza = Pizza::findOrFail($id);
    //     $this->authorize('view',$pizza);
    //     return view('voir_pizza',['pizza'=>$pizza]);
    // }

    // //autorisation supprimer les pizzas pour user authentifier
    // public function delete(Request $request,$id){
    //     $pizza = Pizza::findOrFail($id);
    //     $this->authorize('delete',$pizza);
    //     $pizza->delete();
    //     return redirect('/');

    // }
}
