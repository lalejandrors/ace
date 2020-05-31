<?php

namespace Ace\Policies;

use Ace\User;
use Ace\IncapacidadMedica;
use Illuminate\Auth\Access\HandlesAuthorization;
use Session;

class IncapacidadesPolicy
{
    use HandlesAuthorization;

    //para que el user registrado, gestione solo sus incapacidades
    public function ownerOne(User $user, IncapacidadMedica $incapacidad){
        return $user->id == $incapacidad->user_id;
    }

    //o si es un asistente, que pueda ver solo las incapacidades de su medico
    public function ownerTwo(User $user, IncapacidadMedica $incapacidad){
        return Session::get('medicoActual')->user->id == $incapacidad->user_id;
    }
}
