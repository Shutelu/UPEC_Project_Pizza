<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        return view('compte.mon_panier',['user'=>$user,'commandes'=>$commandes]);
    }
}
