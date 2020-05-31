<?php

namespace Ace\Policies;

use Ace\User;
use Ace\FormulaTratamiento;
use Illuminate\Auth\Access\HandlesAuthorization;
use Session;

class FormulastratamientoPolicy
{
    use HandlesAuthorization;

    //para que el user registrado, gestione solo sus formulas de tratamiento
    public function ownerOne(User $user, FormulaTratamiento $formulaTratamiento){
        return $user->id == $formulaTratamiento->user_id;
    }

    //o si es un asistente, que pueda ver solo las formulas de tratamiento de su medico
    public function ownerTwo(User $user, FormulaTratamiento $formulaTratamiento){
        return Session::get('medicoActual')->user->id == $formulaTratamiento->user_id;
    }
}
