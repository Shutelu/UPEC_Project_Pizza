<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Models\Commande;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pizza extends Model
{
    use HasFactory;
    
    use SoftDeletes;

    //relation *:* avec pizza
    public function commandes(){
        return $this->belongsToMany(Commande::class);
    }
}
