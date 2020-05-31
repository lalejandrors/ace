<?php

namespace Ace\Policies;

use Ace\User;
use Ace\Consentimiento;
use Illuminate\Auth\Access\HandlesAuthorization;
use Session;

class ConsentimientosPolicy
{
    use HandlesAuthorization;

    //para que el user registrado, gestione solo sus consentimientos
    public function ownerOne(User $user, Consentimiento $consentimiento){
        return $user->id == $consentimiento->user_id;
    }

    //o si es un asistente, que pueda ver solo los consentimientos de su medico
    public function ownerTwo(User $user, Consentimiento $consentimiento){
        return Session::get('medicoActual')->user->id == $consentimiento->user_id;
    }
}
