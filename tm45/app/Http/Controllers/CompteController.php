<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Commande;
use App\Models\Pizza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CompteController extends Controller
{

    /*
    ===========================================================================
        Ce controlleur servira :
            - Pour la gestion du compte de User, Cook et Admin :
                Pour User :
                    = mon_compte()
                    = edit_mdp_form()
                    = edit_mdp(request)
                Pour Cook :
                    = cook_liste()
                    = commande_details(id)
                    = change_statut_traitement(id)
                    = change_statut_pret(id)
                    = change_statut_recupere(id)
                Pour Admin :
                    = admin_home()
                    = toutPizza()
                    = toutCommandes()
                    = details_commande(id)
                    = commande_par_date(request)
                    = tri_statut()
                    = tri_date()
                    = creation_form()
                    = admin_creation_form()
                    = admin_creation(request)
                    = pizzaiolo_creation_form()
                    = gestion_form()
                    = cook_edit_mdp_form(id)
                    = cook_edit_mdp(request,id)
                    = admin_supp_form(id)
                    = admin_supp(id)
            - Pour la gestion du panier et de la commande de user:
                = mon_panier()
                = cree_commande()
                = mes_commandes()
                = mes_commandes_nonRecup()
                = mes_commandes_details(id)
    ===========================================================================
    */

    /*
    ======================
        Codes pour User :
    ======================
    */

    //==Partie gestion du compte==

    public function mon_compte(){ //renvoie vers la page de connexion à l'espace de compte de l'utilisateur en cours (user,cook,admin)
        $user = Auth::user();
        return view('compte.mon_compte',['user'=>$user]);
    }

    public function edit_mdp_form(){ //renvoie vers la page d'edition de mot de passe 
        $user = Auth::user();
        return view('compte.edit_mdp_form',['user'=>$user]);
    }

    public function edit_mdp(Request $request){ //function pour la modification de mot de passe
        $valid = $request->validate([
            'ancien' => 'required|string|max:40|min:1',
            'mdp' => 'required|string|max:40|min:1|confirmed',
        ]);
        if(Hash::check($valid['ancien'],Auth::user()->getAuthPassword())){ //verifier si l'ancien mot de passe correspond bien avant de changer
            $user = Auth::user();
            $user->mdp = Hash::make($valid['mdp']);
            $user->save();
    
            $request->session()->flash('etat','Le mot de passe à été modifié avec succès !');
            return redirect()->route('index');
        }

        return redirect()->route('edit_mdp_form')->with('etat','L\'ancien mot de passe n\'est pas correcte');

    }

    //==Partie gestion du panier==
    
    public function mon_panier(){ //renvoie vers la page du panier
        $user = Auth::user();
        $commandes = $user->commandes; 
        $panier = session()->get('panier');
        // $panier = session()->get('panier')->paginate(4);
        return view('compte.mon_panier',['user'=>$user,'panier'=>$panier]);
    }

    public function cree_commande(){ //function de creation de la commande
        $user = Auth::user();
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
            
            session()->forget('panier');//enlever tout de la session panier une fois commander
            session()->flash('etat','La commande à été crée avec succès!');
    
            return view('compte.mon_panier',['user'=>$user,'panier'=>$panier]);
        }
    }

    public function mes_commandes(){ //renvoie la page pour voir tout les commandes passees par l'utilisateur
        $user = Auth::user();
        // $liste_commande = Commande::where('user_id','=',$user)->get();
        $liste_commande = $user->commandes()->orderBy('created_at','asc')->paginate(3);
        // dd($liste_commande);
        return view('user.mes_commandes',['liste'=>$liste_commande]);
    }

    public function mes_commandes_nonRecup(){ //renvoie la page pour voir les commandes passees par l'utilisateur different du statut "recupere"
        $user = Auth::user();
        $liste_commande_nonRecup = $user->commandes()->where('statut','!=','recupere')->paginate(3);
        return view('user.mes_commandes_nonRecup',['liste'=>$liste_commande_nonRecup]);
    }

    public function mes_commandes_details($id){ //renvoie sur la page qui donne les details de la commande
        $commande = Commande::findOrFail($id);
        $pizzas = $commande->pizza;
        return view('user.user_commandes_details',['pizza'=>$pizzas,'commande'=>$commande]);
    }

    /*
    =======================
        Codes pour Cook :
    =======================
    */

    //==Partie gestion des commandes==

    public function cook_liste(){ //renvoie la liste des commandes non traitées
        $commande = Commande::where('statut','!=','traitement')->orderBy('created_at','asc')->get();
        return view('cook.cook_page',['commande'=>$commande]);
    }

    public function commande_details($id){ //renvoie sur la page qui donne les details de la commande
        $commande = Commande::findOrFail($id);
        $pizzas = $commande->pizza;
        return view('cook.cook_cmd_details',['pizza'=>$pizzas,'commande'=>$commande]);
    }

    //==Partie changement des statuts de la commande==

    public function change_statut_traitement($id){ //change le statut de la commande en traitement
        $commande = Commande::findOrFail($id);
        $commande->statut = 'traitement';
        $commande->save();
        return redirect('/cook_liste')->with('etat','Le statut de la commande a été mis en "traitement" !');
    }

    public function change_statut_pret($id){ //change le statut de la commande en pret
        $commande = Commande::findOrFail($id);
        $commande->statut = 'pret';
        $commande->save();
        return redirect('/cook_liste')->with('etat','Le statut de la commande a été mis en "pret" !');
    }

    public function change_statut_recupere($id){ //change le statut de la commande en recupere
        $commande = Commande::findOrFail($id);
        $commande->statut = 'recupere';
        $commande->save();
        return redirect('/cook_liste')->with('etat','Le statut de la commande a été mis en "recupere" !');
    }

    /*
    ========================
        Codes pour Admin :
    ========================
    */

    public function admin_home(){ //renvoie la page admin
        return view('admin.admin_home');
    }

    public function toutPizza(){ //renvoie la page de toutes les pizzas avec les pizzas softdelete (affichage avancée)
        $pizzas = Pizza::withTrashed()->paginate(5);
        return view('admin.admin_toutPizza',['pizzas'=>$pizzas]);
    }

    public function toutCommandes(){ //renvoie la page de toutes les commandes
        $commandes = Commande::paginate(5);

        //code pour la recette du jour
        $commandes_du_jour = Commande::all();
        $recette = 0;
        if($commandes_du_jour){
            foreach($commandes_du_jour as $c){
                if($c->created_at->format('Y-m-d') == now()->format('Y-m-d')){
                    foreach($c->pizza as $p){
                        $recette += $p->prix;
                    }
                }
            }
        }

        return view('admin.admin_toutCommandes',['commandes'=>$commandes,'recette'=>$recette]);
    }

    public function details_commande($id){ //renvoie la page details de la commande
        $commande = Commande::findOrFail($id);
        $pizzas = $commande->pizza;
        return view('admin.admin_commandeDetails',['pizzas'=>$pizzas,'commande'=>$commande]);
    }

    public function commande_par_date(Request $request){
        $request->validate([
            'laDate' => 'required|date_format:Y-m-d',
        ]);

        $commandes = Commande::all();

        return view('admin.admin_commande_par_date',['commandes'=>$commandes,'date_verif'=>$request->laDate]);
    }

    public function tri_statut(){
        $commandes = Commande::orderBy('statut','asc')->paginate(5);

        return view('admin.admin_tri_statut',['commandes'=>$commandes]);
    }

    public function tri_date(){
        $commandes = Commande::orderBy('created_at','asc')->paginate(5);

        return view('admin.admin_tri_date',['commandes'=>$commandes]);
    }

    public function creation_form(){
        return view('admin.creation_form');
    }

    public function admin_creation_form(){
        return view('admin.admin_creation_form');
    }

    public function admin_creation(Request $request){
        $request->validate([
            'nom' => 'required|string|max:40|min:1',
            'prenom' => 'required|string|max:40|min:1',
            'login' => 'required|string|unique:users|max:30|min:1',
        ]);

        $user = new User();
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->login = $request->login;
        $user->type = 'admin';
        $user->mdp = Hash::make('admin');// mot de passe par defaut
        $user->save();

        return redirect()->route('admin.user_creation_form')->with('etat','Un nouveau compte administrateur a été crée !');
    }

    public function pizzaiolo_creation_form(){
        return view('admin.admin_pizzaiolo_creation_form');
    }

    public function pizzaiolo_creation(Request $request){
        $request->validate([
            'nom' => 'required|string|max:40|min:1',
            'prenom' => 'required|string|max:40|min:1',
            'login' => 'required|string|unique:users|max:30|min:1',
        ]);

        $user = new User();
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->login = $request->login;
        $user->type = 'cook';
        $user->mdp = Hash::make('cook');// mot de passe par defaut
        $user->save();

        return redirect()->route('admin.user_creation_form')->with('etat','Un nouveau compte pizzaiolo a été crée !');
    }

    public function gestion_form(){
        $cooks = User::where('type','=','cook')->get();
        $admins = User::where('type','=','admin')->get();

        return view('admin.admin_gestion',['cooks'=>$cooks,'admins'=>$admins]);
    }

    public function cook_edit_mdp_form($id){
        $cook = User::findOrFail($id);
        return view('admin.cook_edit_mdp_form',['cook'=>$cook]);
    }

    public function cook_edit_mdp(Request $request,$id){
        $request->validate([
            'mdp' => 'required|confirmed|max:60|min:8',
        ]);

        $cook = User::findOrFail($id);
        $cook->mdp = Hash::make($request->mdp);
        $cook->save();

        return redirect()->route('admin.gestion_form')->with('etat','Le mot de passe du pizzaiolo a été changé !');
    }

    public function admin_supp_form($id){
        $user = User::findOrFail($id);
        return view('admin.admin_supp_form',['user'=>$user]);
    }

    public function admin_supp($id){
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.gestion_form')->with('etat','L\'utilisateur a été supprimé !');
    }

}
