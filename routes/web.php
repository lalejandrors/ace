<?php
use Illuminate\Routing\Router;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
$router->get('/', [ 
    'uses' => 'UserController@login',
    'as' => 'user.login',
    'middleware' => 'panel'
]);

//rutas para gestion de usuarios e ingreso al sistema
$router->group(['prefix' =>'/panel'], function (Router $router) {

	//gestion de sesiones
	$router->post('user/bienvenido', [ 
		'uses' => 'UserController@bienvenido',
		'as' => 'panel.user.bienvenido'
	]);
	$router->get('user/bienvenido', [ 
		'uses' => 'UserController@ingreso',
		'as' => 'panel.user.bienvenido',
		'middleware' => 'login'
	]);
	$router->get('user/logout', [ 
		'uses' => 'UserController@logout',
		'as' => 'panel.user.logout',
		'middleware' => 'login'
	]);
	//ruta asignacion de medico al asistente desde index
	$router->get('user/asignacion/{medico}', [
	    'uses' => 'UserController@asignacion',
	    'as' => 'panel.user.asignacion',
	    'middleware' => ['login','asignacion'],
	]);
	//end gestion de sesiones

	//crud de usuarios
	$router->get('user/listar', [ 
	    'uses' => 'UsersController@listar',
	    'as' => 'panel.user.listar',
	    'middleware' => ['login','sinAsignarMedico']
  	]);
  	$router->post('user/datatable', [ 
	    'uses' => 'UsersController@datatable',
	    'as' => 'panel.user.datatable'
  	]);
  	$router->get('user/crear/', [
	    'uses' => 'UsersController@crear',
	    'as' => 'panel.user.crear',
	    'middleware' => ['login','sinAsignarMedico'],
	]);
  	$router->post('user/almacenar', [ 
		'uses' => 'UsersController@almacenar',
	    'as' => 'panel.user.almacenar',
	]);
	$router->post('user/eliminar', [ 
		'uses' => 'UsersController@eliminar',
	    'as' => 'panel.user.eliminar',
	]);
	$router->get('user/edicion/{id}', [
	    'uses' => 'UsersController@edicion',
	    'as' => 'panel.user.edicion',
	    'middleware' => ['login','sinAsignarMedico'],
	]);
	$router->put('user/editar/{id}', [
	    'uses' => 'UsersController@editar',
	    'as' => 'panel.user.editar'
	]);
	$router->get('user/ver/{id}', [
	    'uses' => 'UsersController@ver',
	    'as' => 'panel.user.ver',
	    'middleware' => ['login','sinAsignarMedico'],
	]);
	$router->post('user/estado', [
	    'uses' => 'UsersController@estadoCambiar',
	    'as' => 'panel.user.estado',
	]);
	//end crud de usuarios

	//gestion de autocompletes
	$router->get('autocomplete/presentacion', [
	    'uses' => 'AutocompletesController@presentacion',
	    'as' => 'panel.autocomplete.presentacion',
	    'middleware' => ['login','sinAsignarMedico'],
	]);
	$router->get('autocomplete/laboratorio', [
	    'uses' => 'AutocompletesController@laboratorio',
	    'as' => 'panel.autocomplete.laboratorio',
	    'middleware' => ['login','sinAsignarMedico'],
	]);
	$router->get('autocomplete/ciudad', [
	    'uses' => 'AutocompletesController@ciudad',
	    'as' => 'panel.autocomplete.ciudad',
	    'middleware' => ['login','sinAsignarMedico'],
	]);
	$router->get('autocomplete/cie10', [
	    'uses' => 'AutocompletesController@cie10',
	    'as' => 'panel.autocomplete.cie10',
	    'middleware' => ['login','sinAsignarMedico'],
	]);
	$router->get('autocomplete/paciente', [
	    'uses' => 'AutocompletesController@paciente',
	    'as' => 'panel.autocomplete.paciente',
	    'middleware' => ['login','sinAsignarMedico'],
	]);
	$router->get('autocomplete/acompanante', [
	    'uses' => 'AutocompletesController@acompanante',
	    'as' => 'panel.autocomplete.acompanante',
	    'middleware' => ['login','sinAsignarMedico'],
	]);
	$router->get('autocomplete/eps', [
	    'uses' => 'AutocompletesController@eps',
	    'as' => 'panel.autocomplete.eps',
	    'middleware' => ['login','sinAsignarMedico'],
	]);
	$router->get('autocomplete/medicamento', [
	    'uses' => 'AutocompletesController@medicamento',
	    'as' => 'panel.autocomplete.medicamento',
	    'middleware' => ['login','sinAsignarMedico'],
	]);
	$router->get('autocomplete/tratamiento', [
	    'uses' => 'AutocompletesController@tratamiento',
	    'as' => 'panel.autocomplete.tratamiento',
	    'middleware' => ['login','sinAsignarMedico'],
	]);
	//end gestion de autocompletes

	//crud de pacientes
	$router->get('paciente/listar', [ 
	    'uses' => 'PacientesController@listar',
	    'as' => 'panel.paciente.listar',
	    'middleware' => ['login','sinAsignarMedico']
  	]);
  	$router->post('paciente/datatable', [ 
	    'uses' => 'PacientesController@datatable',
	    'as' => 'panel.paciente.datatable'
  	]);
  	$router->post('paciente/almacenar', [ 
		'uses' => 'PacientesController@almacenar',
	    'as' => 'panel.paciente.almacenar',
	]);
	$router->get('paciente/edicion/{id}', [
	    'uses' => 'PacientesController@edicion',
	    'as' => 'panel.paciente.edicion'
	]);
	$router->put('paciente/editar/{id}', [
	    'uses' => 'PacientesController@editar',
	    'as' => 'panel.paciente.editar'
	]);
	$router->get('paciente/acompanantes/{id}', [
	    'uses' => 'PacientesController@acompanantes',
	    'as' => 'panel.paciente.acompanantes',
	    'middleware' => ['login','sinAsignarMedico'],
	]);
	//ruta comprobacion existencia paciente
	$router->get('paciente/existencia/{identificacion}', [
	    'uses' => 'PacientesController@existencia',
	    'as' => 'panel.paciente.existencia',
	    'middleware' => ['login','gestionarPacientes','sinAsignarMedico'],
	]);
	//rutas para acceso por reportes
	$router->get('paciente/edicion2/{id}', [
	    'uses' => 'PacientesController@edicion2',
	    'as' => 'panel.paciente.edicion2',
	    'middleware' => ['login','gestionarPacientes','sinAsignarMedico'],
	]);
	$router->put('paciente/editar2/{id}', [
	    'uses' => 'PacientesController@editar2',
	    'as' => 'panel.paciente.editar2'
	]);
	$router->get('paciente/ver/{id}', [
	    'uses' => 'PacientesController@ver',
	    'as' => 'panel.paciente.ver',
	    'middleware' => ['login','sinAsignarMedico'],
	]);
	//end crud de pacientes

	//consultas en reportes
	$router->get('informe/consultas', [ 
	    'uses' => 'ConsultasController@consultas',
	    'as' => 'panel.informe.consultas',
	    'middleware' => ['login','generarReportes','sinAsignarMedico'],
  	]);
	$router->get('informe/consulta1/{genero}/{min}/{max}', [ 
	    'uses' => 'ConsultasController@consulta1',
	    'as' => 'panel.informe.consulta1',
	    'middleware' => ['login','generarReportes','sinAsignarMedico'],
  	]);
  	$router->get('informe/consulta2/{ciudad}', [ 
	    'uses' => 'ConsultasController@consulta2',
	    'as' => 'panel.informe.consulta2',
	    'middleware' => ['login','generarReportes','sinAsignarMedico'],
  	]);
  	$router->get('informe/consulta3/{min}/{max}', [ 
	    'uses' => 'ConsultasController@consulta3',
	    'as' => 'panel.informe.consulta3',
	    'middleware' => ['login','generarReportes','sinAsignarMedico'],
  	]);
  	$router->get('informe/consulta4/{eleccion}', [ 
	    'uses' => 'ConsultasController@consulta4',
	    'as' => 'panel.informe.consulta4',
	    'middleware' => ['login','generarReportes','sinAsignarMedico'],
  	]);
  	$router->get('informe/consulta5/{cie10}', [ 
	    'uses' => 'ConsultasController@consulta5',
	    'as' => 'panel.informe.consulta5',
	    'middleware' => ['login','generarReportes','sinAsignarMedico'],
  	]);
  	$router->get('informe/consulta6/{tratamiento}/{eleccion}', [ 
	    'uses' => 'ConsultasController@consulta6',
	    'as' => 'panel.informe.consulta6',
	    'middleware' => ['login','generarReportes','sinAsignarMedico'],
  	]);
  	$router->get('informe/consulta7/{tratamiento}', [ 
	    'uses' => 'ConsultasController@consulta7',
	    'as' => 'panel.informe.consulta7',
	    'middleware' => ['login','generarReportes','sinAsignarMedico'],
  	]);
  	//envio de correo en reportes
  	$router->get('informe/sender/{listadoEmails}', [ 
	    'uses' => 'ConsultasController@sender',
	    'as' => 'panel.informe.sender',
	    'middleware' => ['login','generarReportes','sinAsignarMedico'],
  	]);
  	$router->get('informe/formato/{formato}', [ 
	    'uses' => 'ConsultasController@formato',
	    'as' => 'panel.informe.formato',
	    'middleware' => ['login','generarReportes','sinAsignarMedico'],
  	]);
  	$router->post('informe/send', [ 
	    'uses' => 'ConsultasController@send',
	    'as' => 'panel.informe.send',
  	]);
	//end consultas en reportes

	//formatos
	$router->get('formato/listar', [ 
	    'uses' => 'FormatosController@listar',
	    'as' => 'panel.formato.listar',
	    'middleware' => ['login','personalizacion','sinAsignarMedico'],
  	]);
  	$router->post('formato/datatable', [ 
	    'uses' => 'FormatosController@datatable',
	    'as' => 'panel.formato.datatable'
  	]);
  	$router->get('formato/crear', [ 
	    'uses' => 'FormatosController@crear',
	    'as' => 'panel.formato.crear',
	    'middleware' => ['login','personalizacion','sinAsignarMedico'],
  	]);
  	$router->post('formato/almacenar', [ 
		'uses' => 'FormatosController@almacenar',
	    'as' => 'panel.formato.almacenar',
	]);
  	$router->post('formato/eliminar', [ 
		'uses' => 'FormatosController@eliminar',
	    'as' => 'panel.formato.eliminar',
	]);
	$router->get('formato/edicion/{id}', [
	    'uses' => 'FormatosController@edicion',
	    'as' => 'panel.formato.edicion',
	    'middleware' => ['login','personalizacion','sinAsignarMedico'],
	]);
	$router->put('formato/editar/{id}', [
	    'uses' => 'FormatosController@editar',
	    'as' => 'panel.formato.editar'
	]);
	//end formatos

	//agenda
	$router->get('agenda/cargar', [ 
	    'uses' => 'AgendasController@cargar',
	    'as' => 'panel.agenda.cargar',
	    'middleware' => ['login','gestionarAgenda','sinAsignarMedico'],
  	]);
	$router->get('agenda/mostrar', [ 
	    'uses' => 'AgendasController@mostrar',
	    'as' => 'panel.agenda.mostrar',
	    'middleware' => ['login','gestionarAgenda','sinAsignarMedico'],
  	]);
  	$router->post('agenda/almacenar', [ 
		'uses' => 'AgendasController@almacenar',
	    'as' => 'panel.agenda.almacenar',
	]);
	$router->delete('agenda/eliminar/{id}', [ 
		'uses' => 'AgendasController@eliminar',
	    'as' => 'panel.agenda.eliminar',
	]);
	$router->put('agenda/editar/{id}', [
	    'uses' => 'AgendasController@editar',
	    'as' => 'panel.agenda.editar'
	]);
	//end agenda

	//informacion del centro
	$router->get('informacion/edicion', [
	    'uses' => 'InformacionController@edicion',
	    'as' => 'panel.informacion.edicion',
	    'middleware' => ['login','administracion'],
	]);
	$router->put('informacion/editar', [
	    'uses' => 'InformacionController@editar',
	    'as' => 'panel.informacion.editar'
	]);
	//end informacion del centro

	//edicion de permisos
	$router->get('permiso/listar', [ 
	    'uses' => 'PermisosController@listar',
	    'as' => 'panel.permiso.listar',
	    'middleware' => ['login','administracion']
  	]);
  	$router->post('permiso/datatable', [ 
	    'uses' => 'PermisosController@datatable',
	    'as' => 'panel.permiso.datatable'
  	]);
	$router->get('permiso/edicion/{id}', [
	    'uses' => 'PermisosController@edicion',
	    'as' => 'panel.permiso.edicion',
	    'middleware' => ['login','administracion'],
	]);
	$router->put('permiso/editar/{id}', [
	    'uses' => 'PermisosController@editar',
	    'as' => 'panel.permiso.editar'
	]);
	//end edicion de permisos

	//backups
	$router->get('copia/listar', [ 
	    'uses' => 'CopiasController@listar',
	    'as' => 'panel.copia.listar',
	    'middleware' => ['login','administracion']
  	]);
  	$router->get('copia/crear', [ 
	    'uses' => 'CopiasController@crear',
	    'as' => 'panel.copia.crear',
	    'middleware' => ['login','administracion'],
  	]);
  	$router->post('copia/almacenar', [ 
		'uses' => 'CopiasController@almacenar',
	    'as' => 'panel.copia.almacenar',
	]);
	$router->get('copia/restablecer/{id}', [
	    'uses' => 'CopiasController@restablecer',
	    'as' => 'panel.copia.restablecer',
	    'middleware' => ['login','administracion'],
	]);
	//gestion de copias de seguridad manuales
	$router->get('copia/descargar', [
	    'uses' => 'CopiasController@descargar',
	    'as' => 'panel.copia.descargar',
	    'middleware' => ['login','administracion'],
	]);
	$router->post('copia/cargar', [ 
		'uses' => 'CopiasController@cargar',
	    'as' => 'panel.copia.cargar',
	]);
	//end backups

	//tratamientos
	$router->get('tratamiento/listar', [ 
	    'uses' => 'TratamientosController@listar',
	    'as' => 'panel.tratamiento.listar',
	    'middleware' => ['login','personalizacion','sinAsignarMedico'],
  	]);
  	$router->post('tratamiento/datatable', [ 
	    'uses' => 'TratamientosController@datatable',
	    'as' => 'panel.tratamiento.datatable'
  	]);
  	$router->post('tratamiento/almacenar', [ 
		'uses' => 'TratamientosController@almacenar',
	    'as' => 'panel.tratamiento.almacenar',
	]);
  	$router->post('tratamiento/eliminar', [ 
		'uses' => 'TratamientosController@eliminar',
	    'as' => 'panel.tratamiento.eliminar',
	]);
	$router->get('tratamiento/edicion/{id}', [
	    'uses' => 'TratamientosController@edicion',
	    'as' => 'panel.tratamiento.edicion',
	    'middleware' => ['login','personalizacion','sinAsignarMedico'],
	]);
	$router->put('tratamiento/editar/{id}', [
	    'uses' => 'TratamientosController@editar',
	    'as' => 'panel.tratamiento.editar'
	]);
	//end tratamientos

	//laboratorios
	$router->get('laboratorio/listar', [ 
	    'uses' => 'LaboratoriosController@listar',
	    'as' => 'panel.laboratorio.listar',
	    'middleware' => ['login','personalizacion','sinAsignarMedico'],
  	]);
  	$router->post('laboratorio/datatable', [ 
	    'uses' => 'LaboratoriosController@datatable',
	    'as' => 'panel.laboratorio.datatable'
  	]);
  	$router->post('laboratorio/almacenar', [ 
		'uses' => 'LaboratoriosController@almacenar',
	    'as' => 'panel.laboratorio.almacenar',
	]);
  	$router->post('laboratorio/eliminar', [ 
		'uses' => 'LaboratoriosController@eliminar',
	    'as' => 'panel.laboratorio.eliminar',
	]);
	$router->get('laboratorio/edicion/{id}', [
	    'uses' => 'LaboratoriosController@edicion',
	    'as' => 'panel.laboratorio.edicion',
	    'middleware' => ['login','personalizacion','sinAsignarMedico'],
	]);
	$router->put('laboratorio/editar/{id}', [
	    'uses' => 'LaboratoriosController@editar',
	    'as' => 'panel.laboratorio.editar'
	]);
	//end laboratorios

	//medicamentos
	$router->get('medicamento/listar', [ 
	    'uses' => 'MedicamentosController@listar',
	    'as' => 'panel.medicamento.listar',
	    'middleware' => ['login','personalizacion','sinAsignarMedico'],
  	]);
  	$router->post('medicamento/datatable', [ 
	    'uses' => 'MedicamentosController@datatable',
	    'as' => 'panel.medicamento.datatable'
  	]);
  	$router->post('medicamento/almacenar', [ 
		'uses' => 'MedicamentosController@almacenar',
	    'as' => 'panel.medicamento.almacenar',
	]);
  	$router->post('medicamento/eliminar', [ 
		'uses' => 'MedicamentosController@eliminar',
	    'as' => 'panel.medicamento.eliminar',
	]);
	$router->get('medicamento/edicion/{id}', [
	    'uses' => 'MedicamentosController@edicion',
	    'as' => 'panel.medicamento.edicion',
	    'middleware' => ['login','personalizacion','sinAsignarMedico'],
	]);
	$router->put('medicamento/editar/{id}', [
	    'uses' => 'MedicamentosController@editar',
	    'as' => 'panel.medicamento.editar'
	]);
	//end medicamentos

	//tipos de citas
	$router->get('citatipo/listar', [ 
	    'uses' => 'CitatiposController@listar',
	    'as' => 'panel.citatipo.listar',
	    'middleware' => ['login','personalizacion','sinAsignarMedico'],
  	]);
  	$router->post('citatipo/datatable', [ 
	    'uses' => 'CitatiposController@datatable',
	    'as' => 'panel.citatipo.datatable'
  	]);
  	$router->post('citatipo/almacenar', [ 
		'uses' => 'CitatiposController@almacenar',
	    'as' => 'panel.citatipo.almacenar',
	]);
  	$router->post('citatipo/eliminar', [ 
		'uses' => 'CitatiposController@eliminar',
	    'as' => 'panel.citatipo.eliminar',
	]);
	$router->get('citatipo/edicion/{id}', [
	    'uses' => 'CitatiposController@edicion',
	    'as' => 'panel.citatipo.edicion',
	    'middleware' => ['login','personalizacion','sinAsignarMedico'],
	]);
	$router->put('citatipo/editar/{id}', [
	    'uses' => 'CitatiposController@editar',
	    'as' => 'panel.citatipo.editar'
	]);
	//end tipos de citas

	//acompanantes
	$router->get('acompanante/edicion/{acompananteId}/{pacienteId}', [
	    'uses' => 'AcompanantesController@edicion',
	    'as' => 'panel.acompanante.edicion',
	    'middleware' => ['login','gestionarPacientes','sinAsignarMedico'],
	]);
	$router->put('acompanante/editar/{acompananteId}/{pacienteId}', [
	    'uses' => 'AcompanantesController@editar',
	    'as' => 'panel.acompanante.editar'
	]);
	//end acompanantes

	//historias clinicas
	$router->get('historia/listar', [ 
	    'uses' => 'HistoriasController@listar',
	    'as' => 'panel.historia.listar',
	    'middleware' => ['login','verHistorias','sinAsignarMedico']
  	]);
  	$router->post('historia/datatable', [ 
	    'uses' => 'HistoriasController@datatable',
	    'as' => 'panel.historia.datatable'
  	]);
	$router->get('historia/crear', [ 
	    'uses' => 'HistoriasController@crear',
	    'as' => 'panel.historia.crear',
	    'middleware' => ['login','gestionarHistorias'],
  	]);
  	$router->post('historia/almacenar', [ 
		'uses' => 'HistoriasController@almacenar',
	    'as' => 'panel.historia.almacenar',
	]);
	//ruta para detallar en una nueva vista todos los componentes de la historia
	$router->get('historia/detallar/{id}', [
	    'uses' => 'HistoriasController@detallar',
	    'as' => 'panel.historia.detallar',
	    'middleware' => ['login','verHistorias','sinAsignarMedico'],
	]);
	//ruta para visualizar la impresion de la historia completa, con todos sus detalles
	$router->get('historia/ver/{id}', [
	    'uses' => 'HistoriasController@ver',
	    'as' => 'panel.historia.ver',
	    'middleware' => ['login','verHistorias','sinAsignarMedico'],
	]);
	//ruta para visualizar la impresion de la historia sin los detalles
	$router->get('historia/versimple/{id}', [
	    'uses' => 'HistoriasController@versimple',
	    'as' => 'panel.historia.versimple',
	    'middleware' => ['login','verHistorias','sinAsignarMedico'],
	]);
	//ruta comprobacion existencia historia clinica
	$router->get('historia/existencia/{pacienteId}', [
	    'uses' => 'HistoriasController@existencia',
	    'as' => 'panel.historia.existencia',
	    'middleware' => ['login','gestionarHistorias'],
	]);
	//ruta para traer los datos del paciente a partir del autocomplete a la historia clinica, al control o a la sesion
	$router->get('historia/paciente/{pacienteId}', [
	    'uses' => 'HistoriasController@pacienteObtener',
	    'as' => 'panel.historia.paciente',
	    'middleware' => ['login','gestionarHistorias'],
	]);
	//ruta para traer los datos del acompanante a partir del autocomplete a la historia clinica, al control o a la sesion
	$router->get('historia/acompanante/{acompananteId}', [
	    'uses' => 'HistoriasController@acompananteObtener',
	    'as' => 'panel.historia.acompanante',
	    'middleware' => ['login','gestionarHistorias'],
	]);
	//end historias clinicas

	//controles
	$router->get('control/listar', [ 
	    'uses' => 'ControlesController@listar',
	    'as' => 'panel.control.listar',
	    'middleware' => ['login','verHistorias','sinAsignarMedico']
  	]);
  	$router->post('control/datatable', [ 
	    'uses' => 'ControlesController@datatable',
	    'as' => 'panel.control.datatable'
  	]);
	$router->get('control/crear', [ 
	    'uses' => 'ControlesController@crear',
	    'as' => 'panel.control.crear',
	    'middleware' => ['login','gestionarHistorias'],
  	]);
  	$router->post('control/almacenar', [ 
		'uses' => 'ControlesController@almacenar',
	    'as' => 'panel.control.almacenar',
	]);
	//ruta para detallar en una nueva vista todos los componentes del control
	$router->get('control/detallar/{id}', [
	    'uses' => 'ControlesController@detallar',
	    'as' => 'panel.control.detallar',
	    'middleware' => ['login','verHistorias','sinAsignarMedico'],
	]);
	//ruta para visualizar la impresion del control completa, con todos sus detalles
	$router->get('control/ver/{id}', [
	    'uses' => 'ControlesController@ver',
	    'as' => 'panel.control.ver',
	    'middleware' => ['login','verHistorias','sinAsignarMedico'],
	]);
	//ruta para visualizar la impresion del control sin los detalles
	$router->get('control/versimple/{id}', [
	    'uses' => 'ControlesController@versimple',
	    'as' => 'panel.control.versimple',
	    'middleware' => ['login','verHistorias','sinAsignarMedico'],
	]);
	//end controles

	//sesiones
	$router->get('sesion/listar', [ 
	    'uses' => 'SesionesController@listar',
	    'as' => 'panel.sesion.listar',
	    'middleware' => ['login','verHistorias','sinAsignarMedico']
  	]);
  	$router->post('sesion/datatable', [ 
	    'uses' => 'SesionesController@datatable',
	    'as' => 'panel.sesion.datatable'
  	]);
	$router->get('sesion/crear', [ 
	    'uses' => 'SesionesController@crear',
	    'as' => 'panel.sesion.crear',
	    'middleware' => ['login','gestionarHistorias'],
  	]);
  	$router->post('sesion/almacenar', [ 
		'uses' => 'SesionesController@almacenar',
	    'as' => 'panel.sesion.almacenar',
	]);
	//ruta para detallar en una nueva vista todos los componentes de la sesion
	$router->get('sesion/detallar/{id}', [
	    'uses' => 'SesionesController@detallar',
	    'as' => 'panel.sesion.detallar',
	    'middleware' => ['login','verHistorias','sinAsignarMedico'],
	]);
	//ruta para visualizar la impresion de la sesion completa, con todos sus detalles
	$router->get('sesion/ver/{id}', [
	    'uses' => 'SesionesController@ver',
	    'as' => 'panel.sesion.ver',
	    'middleware' => ['login','verHistorias','sinAsignarMedico'],
	]);
	//ruta para visualizar la impresion de la sesion sin los detalles
	$router->get('sesion/versimple/{id}', [
	    'uses' => 'SesionesController@versimple',
	    'as' => 'panel.sesion.versimple',
	    'middleware' => ['login','verHistorias','sinAsignarMedico'],
	]);
	//ruta comprobacion asignacion tratamiento a un paciente
	$router->get('sesion/asignacion/{pacienteId}/{tratamientoId}', [
	    'uses' => 'SesionesController@asignacion',
	    'as' => 'panel.sesion.asignacion',
	    'middleware' => ['login','gestionarHistorias'],
	]);
	//end sesiones

	//formulas
	$router->get('formula/listar', [ 
	    'uses' => 'FormulasController@listar',
	    'as' => 'panel.formula.listar',
	    'middleware' => ['login','verHistorias','sinAsignarMedico']
  	]);
  	$router->post('formula/datatable', [ 
	    'uses' => 'FormulasController@datatable',
	    'as' => 'panel.formula.datatable'
  	]);
	$router->get('formula/ver/{id}', [
	    'uses' => 'FormulasController@ver',
	    'as' => 'panel.formula.ver',
	    'middleware' => ['login','verHistorias','sinAsignarMedico'],
	]);
	//end formulas

	//formulas de tratamientos
	$router->get('formulatratamiento/listar', [ 
	    'uses' => 'FormulastratamientoController@listar',
	    'as' => 'panel.formulatratamiento.listar',
	    'middleware' => ['login','verHistorias','sinAsignarMedico']
  	]);
  	$router->post('formulatratamiento/datatable', [ 
	    'uses' => 'FormulastratamientoController@datatable',
	    'as' => 'panel.formulatratamiento.datatable'
  	]);
	$router->get('formulatratamiento/ver/{id}', [
	    'uses' => 'FormulastratamientoController@ver',
	    'as' => 'panel.formulatratamiento.ver',
	    'middleware' => ['login','verHistorias','sinAsignarMedico'],
	]);
	//end formulas de tratamientos

	//incapacidades
	$router->get('incapacidad/listar', [ 
	    'uses' => 'IncapacidadesController@listar',
	    'as' => 'panel.incapacidad.listar',
	    'middleware' => ['login','verHistorias','sinAsignarMedico']
  	]);
  	$router->post('incapacidad/datatable', [ 
	    'uses' => 'IncapacidadesController@datatable',
	    'as' => 'panel.incapacidad.datatable'
  	]);
	$router->get('incapacidad/ver/{id}', [
	    'uses' => 'IncapacidadesController@ver',
	    'as' => 'panel.incapacidad.ver',
	    'middleware' => ['login','verHistorias','sinAsignarMedico'],
	]);
	//end incapacidades

	//certificados
	$router->get('certificado/listar', [ 
	    'uses' => 'CertificadosController@listar',
	    'as' => 'panel.certificado.listar',
	    'middleware' => ['login','verHistorias','sinAsignarMedico']
  	]);
  	$router->post('certificado/datatable', [ 
	    'uses' => 'CertificadosController@datatable',
	    'as' => 'panel.certificado.datatable'
  	]);
	$router->get('certificado/ver/{id}', [
	    'uses' => 'CertificadosController@ver',
	    'as' => 'panel.certificado.ver',
	    'middleware' => ['login','verHistorias','sinAsignarMedico'],
	]);
	//end certificados

	//consentimientos
	$router->get('consentimiento/listar', [ 
	    'uses' => 'ConsentimientosController@listar',
	    'as' => 'panel.consentimiento.listar',
	    'middleware' => ['login','verHistorias','sinAsignarMedico']
  	]);
  	$router->post('consentimiento/datatable', [ 
	    'uses' => 'ConsentimientosController@datatable',
	    'as' => 'panel.consentimiento.datatable'
  	]);
	$router->get('consentimiento/ver/{id}', [
	    'uses' => 'ConsentimientosController@ver',
	    'as' => 'panel.consentimiento.ver',
	    'middleware' => ['login','verHistorias','sinAsignarMedico'],
	]);
	//end consentimientos
});




