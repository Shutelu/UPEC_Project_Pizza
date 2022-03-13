<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Pizza;

class Commande extends Model
{
    use HasFactory;

    // relation 1:* cote multiple
    public function user(){
        return $this->belongsTo(User::class);
    }
        
    //relation *:* avec commande
    public function pizza(){
        return $this->belongsToMany(Pizza::class)->withPivot('qte');
    }
}
