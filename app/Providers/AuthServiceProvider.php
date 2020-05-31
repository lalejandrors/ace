<?php

namespace Ace\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'Ace\Paciente' => 'Ace\Policies\PacientesPolicy',
        'Ace\Formato' => 'Ace\Policies\FormatosPolicy',
        'Ace\HistoriaClinica' => 'Ace\Policies\HistoriasPolicy',
        'Ace\Control' => 'Ace\Policies\ControlesPolicy',
        'Ace\Sesion' => 'Ace\Policies\SesionesPolicy',
        'Ace\Formula' => 'Ace\Policies\FormulasPolicy',
        'Ace\FormulaTratamiento' => 'Ace\Policies\FormulastratamientoPolicy',
        'Ace\IncapacidadMedica' => 'Ace\Policies\IncapacidadesPolicy',
        'Ace\CertificadoMedico' => 'Ace\Policies\CertificadosPolicy',
        'Ace\Consentimiento' => 'Ace\Policies\ConsentimientosPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
