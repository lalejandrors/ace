<?php

namespace Ace\Policies;

use Ace\User;
use Ace\HistoriaClinica;
use Illuminate\Auth\Access\HandlesAuthorization;
use Session;

class HistoriasPolicy
{
    use HandlesAuthorization;

    //para que el user registrado, gestione solo sus historias
    public function ownerOne(User $user, HistoriaClinica $historia){
        return $user->id == $historia->user_id;
    }

    //o si es un asistente, que pueda ver solo las historias de su medico
    public function ownerTwo(User $user, HistoriaClinica $historia){
        return Session::get('medicoActual')->user->id == $historia->user_id;
    }
}
