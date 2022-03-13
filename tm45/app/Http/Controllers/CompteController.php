<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Commande;
use App\Models\Pizza;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CompteController extends Controller
{
    //Controller pour la gestion du compte 

    public function mon_compte(){
        $user = Auth::user();
        return view('compte.mon_compte',['user'=>$user]);
    }

    public function edit_mdp_form(){
        $user = Auth::user();
        return view('compte.edit_mdp_form',['user'=>$user]);
    }

    public function edit_mdp(Request $request){
        $valid = $request->validate([
            'mdp' => 'required|string|max:40|min:1|confirmed',
            // 'new_mdp_confirmation' => 'required|string|max:40|min:1',
        ]);

        $user = Auth::user();
        $user->mdp = Hash::make($valid['mdp']);
        $user->save();

        $request->session()->flash('etat','MDP modifier !');

        // $request->session()->flash('etat','Changement')
        return redirect()->route('index');

    }

    //panier
    public function mon_panier(){
        $user = Auth::user();
        $commandes = $user->commandes; 
        $panier = session()->get('panier');
        // $panier = session()->get('panier')->paginate(4);//a demande au prof
        return view('compte.mon_panier',['user'=>$user,'panier'=>$panier]);
    }

    //panier
    public function cree_commande(){
        $user = Auth::user();//reccup user
        $panier = session()->get('panier');

        //si existe
        if($panier){
            $commande = new Commande();
            $commande->user_id = $user->id;
            $commande->statut = "envoye";
            $user->commandes()->save($commande);
    
            foreach($panier as $id => $opt){
                $pizza = Pizza::findOrFail($id);
                // $commande->pizza()->attach()
                $commande->pizza()->attach($pizza,['qte'=>$opt['qte']]);
            }
            
            session()->forget('panier');//nouv ajout
            session()->flash('etat','Une commande a ete cree !');
    
            return view('compte.mon_panier',['user'=>$user,'panier'=>$panier]);
        }
    }

    //cook list 
    public function cook_liste(){
        $commande = Commande::where('statut','=','envoye')->get();
        return view('cook.cook_page',['commande'=>$commande]);
    }

    public function commande_details($id){
        $commande = Commande::findOrFail($id);
        $pizzas = $commande->pizza;
        return view('cook.cook_cmd_details',['pizza'=>$pizzas]);
    }
}
