<?php

namespace Ace\Policies;

use Ace\User;
use Ace\Paciente;
use Illuminate\Auth\Access\HandlesAuthorization;
use Session;

class PacientesPolicy
{
    use HandlesAuthorization;

    //para que el user registrado, gestione solo sus pacientes
    public function ownerOne(User $user, Paciente $paciente){
        return $user->id == $paciente->user_id;
    }

    //o si es un asistente, que pueda gestionar los pacientes de su medico
    public function ownerTwo(User $user, Paciente $paciente){
        return Session::get('medicoActual')->user->id == $paciente->user_id;
    }
}
