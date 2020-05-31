<?php

namespace Ace;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password', 'tipoId', 'identificacion', 'nombres', 'apellidos', 'telefonoFijo', 'telefonoCelular', 'perfil_id', 'activo', 'medico_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['deleted_at'];

    public function perfil()
    {
        return $this->belongsTo('Ace\Perfil');
    }

    public function permisos()
    {
        return $this->belongsToMany('Ace\Permiso','users_permisos')->withTimestamps();
    }

    public function formatos()
    {
        return $this->hasMany('Ace\Formato');
    }

    public function citasTipos()
    {
        return $this->hasMany('Ace\citaTipo');
    }

    public function tratamientos()
    {
        return $this->hasMany('Ace\Tratamiento');
    }

    public function laboratorios()
    {
        return $this->hasMany('Ace\Laboratorio');
    }

    public function medicamentos()
    {
        return $this->hasMany('Ace\Medicamento');
    }

    public function sesiones()
    {
        return $this->hasMany('Ace\Sesion');
    }

    public function agendas()
    {
        return $this->hasMany('Ace\Agenda');
    }

    public function controles()
    {
        return $this->hasMany('Ace\Control');
    }

    public function pacientes()
    {
        return $this->hasMany('Ace\Paciente');
    }

    public function historiasClinicas()
    {
        return $this->hasMany('Ace\HistoriaClinica');
    }

    public function certificadosMedicos()
    {
        return $this->hasMany('Ace\CertificadoMedico');
    }

    public function formulas()
    {
        return $this->hasMany('Ace\Formula');
    }

    public function consentimientos()
    {
        return $this->hasMany('Ace\Consentimiento');
    }

    public function incapacidadesMedicas()
    {
        return $this->hasMany('Ace\IncapacidadMedica');
    }

    public function formulasTratamientos()
    {
        return $this->hasMany('Ace\FormulaTratamiento');
    }

    public function medicos()
    {
        return $this->belongsToMany('Ace\Medico','users_medicos')->withTimestamps();
    }

    public function medico()
    {
        return $this->belongsTo('Ace\Medico');
    }
}
