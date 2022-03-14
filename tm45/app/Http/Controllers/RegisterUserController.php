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

    /*
    ===========================================================================
        Ce controlleur servira pour l'authentification des utilisateurs :
            = register_form()
            = enregister(request)
    ===========================================================================
    */

    public function register_form(){ //renvoie sur le formulaire d'enregistrement
        return view('auth.reg_form');
    }

    public function enregistrer(Request $request){ //function pour le traitement du formulaire d'enregistrement
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
        $user->mdp = Hash::make($valid['mdp']); //ne pas stocker le mot de passe en clair et verifie
        $user->save();

        $request->session()->flash('etat','Utilisateur enregistrer !');
        Auth::login($user); //connecter directement l'utilisateur

        return redirect()->route('home');

    }
}
