<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;

class RegisterUserController extends Controller
{

    //retourne le formulaire de register
    public function register_form(){
        return view('auth.reg_form');
    }

    //traitement du formulaire register
    public function enregistrer(Request $request){
        $valid = $request->validate([
            'nom' => 'required|string|max:40',
            'prenom' => 'required|string|max:40',
            'login' => 'required|string|max:30|unique:users',
            'mdp' => 'required|string|confirmed|max:60|min:8'
        ]);

        $user = new User();
        $user->nom = $valid['nom'];
        $user->prenom = $valid['prenom'];
        $user->login = $valid['login'];
        $user->mdp = Hash::make($valid['mdp']); //ne pas stocker mdp en clair et verifie
        $user->save();

        //msg flash
        $request->session()->flash('etat','Utilisateur enregistrer !');

        Auth::login($user); //connecter directement user

        return redirect()->route('home');

    }
}
