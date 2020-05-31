<?php

namespace Ace\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Ace\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \Ace\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Ace\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \Ace\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        // mis middleware
        // acceso
        'login' => \Ace\Http\Middleware\AccesoMiddleware\LoginMiddleware::class,
        'panel' => \Ace\Http\Middleware\AccesoMiddleware\PanelMiddleware::class,
        'asignacion' => \Ace\Http\Middleware\AccesoMiddleware\AsignacionMedicoMiddleware::class,
        'sinAsignarMedico' => \Ace\Http\Middleware\AccesoMiddleware\SinAsignarMedicoMiddleware::class,
        // permisos
        'administracion' => \Ace\Http\Middleware\PermisosMiddleware\AdministracionMiddleware::class,
        'gestionarPacientes' => \Ace\Http\Middleware\PermisosMiddleware\GestionarPacientesMiddleware::class,
        'generarReportes' => \Ace\Http\Middleware\PermisosMiddleware\GenerarReportesMiddleware::class,
        'personalizacion' => \Ace\Http\Middleware\PermisosMiddleware\PersonalizacionMiddleware::class,
        'gestionarAgenda' => \Ace\Http\Middleware\PermisosMiddleware\GestionarAgendaMiddleware::class,
        'gestionarHistorias' => \Ace\Http\Middleware\PermisosMiddleware\GestionarHistoriasMiddleware::class,
        'verHistorias' => \Ace\Http\Middleware\PermisosMiddleware\VerHistoriasMiddleware::class,
        // mis middleware
    ];
}
