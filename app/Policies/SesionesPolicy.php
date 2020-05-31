<?php

namespace Ace\Policies;

use Ace\User;
use Ace\Sesion;
use Illuminate\Auth\Access\HandlesAuthorization;
use Session;

class SesionesPolicy
{
    use HandlesAuthorization;

    //para que el user registrado, gestione solo sus sesiones
    public function ownerOne(User $user, Sesion $sesion){
        return $user->id == $sesion->user_id;
    }

    //o si es un asistente, que pueda ver solo las sesiones de su medico
    public function ownerTwo(User $user, Sesion $sesion){
        return Session::get('medicoActual')->user->id == $sesion->user_id;
    }
}
