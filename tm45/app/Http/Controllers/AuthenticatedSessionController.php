<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    
    //login form
    public function login_form(){
        return view('auth.log_form');
    }

    public function login(Request $request){
        $request->validate([
            'login' => 'required|string|max:40|min:1',
            'mdp' => 'required|string|max:40|min:1',
        ]);

        //on sauvegarde le login et le mot de passe
        //laveral utilise let champ de base'password' nous on utilise 'mdp'
        $credit = [
            'login'=>$request->input('login'),
            'password'=>$request->input('mdp')
        ];

        //reussi
        if(Auth::attempt($credit)){
            $request->session()->regenerate();//regenerer la session
            $request->session()->flash('etat','Login reussi !');
            return redirect()->intended('/home');//rediriger la ou il voulait aller
        }

        //si fail renvoie page precedente
        return back()->withErrors([
            'login'=>'Les informations saisis exite pas',
        ]);

    }

    public function logout(Request $request){
        Auth::logout();//deco
        $request->session()->invalidate();//lutte attaque
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
