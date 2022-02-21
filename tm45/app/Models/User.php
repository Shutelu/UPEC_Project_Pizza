<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    public $timestamps = false; // enlever les meta information 

    protected $hidden = ['mdp']; //controller et vue n'auront pas acces direct

    protected $fillable = ['nom','prenom','login', 'mdp', 'type']; //mettre a jour au moment de la creation

    protected $attributes = ['type' => 'user']; // valeur par defaut de type

    //renvoie le mdp
    public function getAuthPassword(){
        return $this->mdp;
    }

    public function isAdmin(){
         return $this->type == 'admin';
    }

    // relation 1:* cote principal user
    public function commandes(){
        return $this->hasMany(Commande::class,'id');
    }
}