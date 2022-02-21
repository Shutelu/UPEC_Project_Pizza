<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Models\User;
use App\Http\Models\Pizza;

class Commande extends Model
{
    use HasFactory;

    // protected $primaryKey = 'cid';

    // // relation 1:* cote multiple
    // public function user(){
    //     return $this->belongsTo(User::class,'uid');
    // }
        
    // //relation *:*
    // public function pizza(){
    //     return $this->belongsToMany(Pizza::class,'com_pizza','cid','pid')->withPivot('commande_pizza');
    // }
}
