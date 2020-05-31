<?php

namespace Ace\Policies;

use Ace\User;
use Ace\CertificadoMedico;
use Illuminate\Auth\Access\HandlesAuthorization;
use Session;

class CertificadosPolicy
{
    use HandlesAuthorization;

    //para que el user registrado, gestione solo sus certificados
    public function ownerOne(User $user, CertificadoMedico $certificadoMedico){
        return $user->id == $certificadoMedico->user_id;
    }

    //o si es un asistente, que pueda ver solo los certificados de su medico
    public function ownerTwo(User $user, CertificadoMedico $certificadoMedico){
        return Session::get('medicoActual')->user->id == $certificadoMedico->user_id;
    }
}
