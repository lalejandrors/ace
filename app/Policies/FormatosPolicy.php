<?php

namespace Ace\Policies;

use Ace\User;
use Ace\Formato;
use Illuminate\Auth\Access\HandlesAuthorization;
use Session;

class FormatosPolicy
{
    use HandlesAuthorization;

    //para que el user registrado, gestione solo sus formatos
    public function ownerOne(User $user, Formato $formato){
        return $user->id == $formato->user_id;
    }

    //o si es un asistente, que pueda gestionar los formatos de su medico
    public function ownerTwo(User $user, Formato $formato){
        return Session::get('medicoActual')->user->id == $formato->user_id;
    }
}
