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

    /*
    ============
        User
    ============
    */
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

        $request->session()->flash('etat','Le mot de passe à été modifié !');

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
            session()->flash('etat','La commande à été crée avec succès!');
    
            return view('compte.mon_panier',['user'=>$user,'panier'=>$panier]);
        }
    }

    //voir les commandes passees
    public function mes_commandes(){
        $user = Auth::user();
        // $liste_commande = Commande::where('user_id','=',$user)->get();
        $liste_commande = $user->commandes()->paginate(3);
        // dd($liste_commande);
        return view('user.mes_commandes',['liste'=>$liste_commande]);
    }

    public function mes_commandes_nonRecup(){
        $user = Auth::user();
        $liste_commande_nonRecup = $user->commandes()->where('statut','!=','recupere')->paginate(3);
        return view('user.mes_commandes_nonRecup',['liste'=>$liste_commande_nonRecup]);
    }

    //voir les details de la commande
    public function mes_commandes_details($id){
        $user = Auth::user();
        $commande = Commande::findOrFail($id);
        $pizzas = $commande->pizza;
        return view('user.user_commandes_details',['pizza'=>$pizzas,'commande'=>$commande]);
    }

    /*
    ============
        Cook
    ============
    */

    //cook list 
    public function cook_liste(){
        $commande = Commande::where('statut','=','envoye')->get();
        return view('cook.cook_page',['commande'=>$commande]);
    }

    public function commande_details($id){
        $commande = Commande::findOrFail($id);
        $pizzas = $commande->pizza;
        return view('cook.cook_cmd_details',['pizza'=>$pizzas,'commande'=>$commande]);
    }

    //les changements de statut
    public function change_statut_traitement($id){
        $commande = Commande::findOrFail($id);
        $commande->statut = 'traitement';
        $commande->save();
        return redirect('/cook_liste')->with('etat','Le statut de la commande a été mis en "traitement" !');
    }

    public function change_statut_pret($id){
        $commande = Commande::findOrFail($id);
        $commande->statut = 'pret';
        $commande->save();
        return redirect('/cook_liste')->with('etat','Le statut de la commande a été mis en "pret" !');
    }

    public function change_statut_recupere($id){
        $commande = Commande::findOrFail($id);
        $commande->statut = 'recupere';
        $commande->save();
        return redirect('/cook_liste')->with('etat','Le statut de la commande a été mis en "recupere" !');
    }
}
