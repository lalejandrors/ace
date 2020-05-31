<?php

namespace Ace\Policies;

use Ace\User;
use Ace\Formula;
use Illuminate\Auth\Access\HandlesAuthorization;
use Session;

class FormulasPolicy
{
    use HandlesAuthorization;

    //para que el user registrado, gestione solo sus formulas
    public function ownerOne(User $user, Formula $formula){
        return $user->id == $formula->user_id;
    }

    //o si es un asistente, que pueda ver solo las formulas de su medico
    public function ownerTwo(User $user, Formula $formula){
        return Session::get('medicoActual')->user->id == $formula->user_id;
    }
}
