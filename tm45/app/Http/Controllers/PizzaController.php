<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PizzaController extends Controller
{

    /*
    ===========================================================================
        Ce controlleur servira pour les functionalitées de la pizza et du panier:
            - Pour user non connecté :
                = index()
            - Pour user connecté :
                = home()
            - Pour la gestion de la pizza :
                = ajout_form()
                = ajout_pizza(request)
                = edit_form(id)
                = edit_pizza(request,id)
                = suppPizza_form(id)
                = suppPizza(id)
            - Pour la gestion du panier :
                = mon_panier_ajout(id)
                = mon_panier_delete(id)
                = mon_panier_miseajour(request)
                = mon_panier_deleteall(id)
    ===========================================================================
    */

    //==Partie pour l'utilisateur non authentifié==

    public function index(){ //renvoie sur la page index/principal meme si l'utilisateur n'est pas authentifié (avec pagination)
        // $pizza = Pizza::all();
        $user = Auth::user();
        $pizza = Pizza::paginate(5);
        return view('index',['pizza'=>$pizza,'user'=>$user]);
    }

    //==Partie pour l'utilisateur authentifié==

    public function home(){ //renvoie la page home une fois l'utilisateur authentifié (avec pagination), ##probleme de route sans ce code(reste sur le login)
        $user = Auth::user();
        // $pizza = Pizza::all();
        $pizza = Pizza::paginate(5);
        return view('home',['pizza' => $pizza,'user'=>$user]);
    }

    //==Partie sur la gestion de la pizza==

    public function ajout_form(){ //renvoie sur la page d'ajout de pizza
        return view('pizza_ajout');
    }

    public function ajout_pizza(Request $request){ //function d'ajout de pizza
        $valid = $request->validate([
            'nom' => 'required|alpha|min:1|max:30',
            'desc' => 'required|min:1|max:200',
            'prix' => 'bail|required|integer|gte:1|lte:999'
        ]);


        $pizza = new Pizza();
        $pizza->nom = $valid['nom'];
        $pizza->description = $valid['desc'];
        $pizza->prix = $valid['prix'];
        $this->authorize('create',$pizza);
        $pizza->save();

        $request->session()->flash('etat','Ajout effectuee !');

        return redirect()->route('index');
    }
    
    public function edit_form($id){ //renvoie sur la page d'édition de la pizza

        $pizza = Pizza::findOrFail($id);
        return view('pizza_edit',['pizza'=>$pizza]);
    }

    public function edit_pizza(Request $request,$id){ //function d'édition de la pizza
        $valid = $request->validate([
            'nom' => 'required|alpha|min:1|max:20',
            'desc' => 'required|min:1|max:200',
            'prix' => 'bail|required|integer|gte:1|lte:999'
        ]);

        $pizza = Pizza::findOrFail($id);

        $pizza->nom = $valid['nom'];
        $pizza->description = $valid['desc'];
        $pizza->prix = $valid['prix'];
        $pizza->save();

        $request->session()->flash('etat','Modification effectuee !');

        return redirect()->route('index');
    }

    public function suppPizza_form($id){ //renvoie le formulaire de la suppression de la pizza
        $pizza = Pizza::findOrFail($id);
        $bool = false;
        // dd(sizeof($pizza->commandes) );
        // dd($pizza->commandes);
        if(sizeof($pizza->commandes) > 0){ //la pizza appartient à une commande
            $bool = true;
        }
        return view('admin.supp_pizza_form',['pizza'=>$pizza,'bool'=>$bool]);
    } 

    public function suppPizza($id){
        $pizza = Pizza::findOrFail($id);
        $this->authorize('delete',$pizza);

        if(sizeof($pizza->commandes) > 0){ //la pizza appartient à une commande
            $pizza->delete();
            return redirect()->route('home')->with('etat','La pizza à été supprimé ! (utilisation du softdelete)');
        }
        $pizza->forceDelete();
        return redirect()->route('home')->with('etat','La pizza à été supprimé définitivement!');
    }

    //==Partie sur la gestion du panier==

    public function mon_panier_ajout($id){ //fonction permettant l'ajout de pizza dans le panier en utilisant les sessions pour l'utilisateur
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

    public function mon_panier_delete($id){ // fonction permettant la suppression (si la quantité tombe à 0) ou la diminution des pizzas du panier pour l'utilisateur
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

    public function mon_panier_miseajour(Request $request){ //fonction pour mettre à jour le nombre de quantité du panier saisi par l'utilisateur
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

    public function mon_panier_deleteall($id){ //fonction de suppression d'une pizza du panier pour l'utilisateur
        $panier = session()->get('panier');
        // $this->authorize('delete',$pizza);
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
