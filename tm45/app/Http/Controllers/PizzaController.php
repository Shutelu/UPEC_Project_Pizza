<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pizza;
use Illuminate\Support\Facades\Auth;

class PizzaController extends Controller
{

    /*
    ===========================================================================
        Ce controlleur servira pour les functionnalitées de la pizza
    ===========================================================================
    */

    //pas authentifier
    public function index(){
        // $pizza = Pizza::all();
        $user = Auth::user();
        $pizza = Pizza::paginate(3);
        return view('index',['pizza'=>$pizza,'user'=>$user]);
    }

    //route home / une fois authentifier
    public function home(){
        $user = Auth::user();//comme on est auth on a acces a notre user
        // $pizza = Pizza::all();
        $pizza = Pizza::paginate(3);
        return view('home',['pizza' => $pizza,'user'=>$user]);
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

        $request->session()->flash('etat','Ajout effectuee !');

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

        $request->session()->flash('etat','Modification effectuee !');

        return redirect()->route('index');
    }

    //page admin
    public function admin_home(){
        return view('admin.admin_home');
    }

    //ajout de pizza dans le panier
    public function mon_panier_ajout($id){
        $pizza = Pizza::findOrFail($id);

        $panier = session()->get('panier');

        //si le panier est vide et existe pas encore
        if(!$panier){
            $panier = [
                $id => [
                    'id' => $pizza->id,
                    'nom' => $pizza->nom,
                    'desc'=>$pizza->description,
                    'prix'=>$pizza->prix,
                    'qte'=>1,
                ]
            ];    
            session()->put('panier',$panier);
            return redirect()->back()->with('etat','Ajout réussie !');
        }
        //si pizza existe deja
        if(isset($panier[$id])){
            $panier[$id]['qte'] ++;
            session()->put('panier',$panier);
            return redirect()->back()->with('etat','Ajout en plus réussie !');
        }

        $panier[$id] = [
            'id' => $pizza->id,
            'nom' => $pizza->nom,
            'desc'=>$pizza->description,
            'prix'=>$pizza->prix,
            'qte'=>1,
        ];
        session()->put('panier',$panier);
        return redirect()->back()->with('etat','Ajout réussie !');

    }

    //enlever la quantite de pizza si elle tombe a 0 alors enleve la pizza du panier
    public function mon_panier_delete($id){
        $panier = session()->get('panier');
        if(isset($panier[$id])){
            if($panier[$id]['qte'] == 1){
                unset($panier[$id]);
                session()->put('panier', $panier);
                return redirect()->back()->with('etat','la pizza a etait enlevé !');
            }
            $panier[$id]['qte'] --;
            session()->put('panier',$panier);
            return redirect()->back()->with('etat','reduction de quantité reussi !');
        }
    }

    public function mon_panier_miseajour(Request $request){
        $request->validate([
            'id_pizza' => 'required|numeric|min:1',
            'quantite_miseajour' => 'required|numeric|min:1'
        ]);

        if($request->id_pizza && $request->quantite_miseajour){
            $panier = session()->get('panier');
            $panier[$request->id_pizza]['qte'] = $request->quantite_miseajour;
            session()->put('panier',$panier);
            return redirect()->back()->with('etat','modification de la quantité reussi !');
        }

    }

    public function mon_panier_deleteall($id){
        $panier = session()->get('panier');
        if(isset($panier[$id])){
            unset($panier[$id]);
            session()->put('panier',$panier);
            return redirect()->back()->with('etat','la pizza a etait enlevé !');
        }
    }

    //pagination
    // public function PizzaPagination(Request $request){
    //     $pizza = paginate(3);
    //     return view('');
    // }
    
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
