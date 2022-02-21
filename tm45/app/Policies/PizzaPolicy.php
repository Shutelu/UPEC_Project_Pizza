<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Pizza;
use Illuminate\Auth\Access\HandlesAuthorization;

class PizzaPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //si user a le droit de voir les pizzas
    public function view(User $user,Pizza $pizza){
        return true;
    }

    //si user a le droit de cree les pizzas
    public function create(User $user){
        return true;
    }

    //si user a le droit de modifier les pizzas
    public function update(User $user,Pizza $pizza){
        return $user->id == $pizza->id;
    }

    //si user a le droit de supprimer les pizzas
    public function delete(User $user,Pizza $pizza){
        return $user->isAdmin() || $user->id == $pizza->id;
    }
}
