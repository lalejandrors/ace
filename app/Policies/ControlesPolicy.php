<?php

namespace Ace\Policies;

use Ace\User;
use Ace\Control;
use Illuminate\Auth\Access\HandlesAuthorization;
use Session;

class ControlesPolicy
{
    use HandlesAuthorization;

    //para que el user registrado, gestione solo sus controles
    public function ownerOne(User $user, Control $control){
        return $user->id == $control->user_id;
    }

    //o si es un asistente, que pueda ver solo los controles de su medico
    public function ownerTwo(User $user, Control $control){
        return Session::get('medicoActual')->user->id == $control->user_id;
    }
}
