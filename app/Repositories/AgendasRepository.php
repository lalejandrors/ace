<?php 

namespace Ace\Repositories;

use DB;

class AgendasRepository{

	public function findMisAgendas($usuarioId){

	    //encuentra las agendas del usuario actual, teniendo en cuenta que se usa DB y el no soporte de softdelete. En la conexion con la tabla tratamiento se usa el left join, ya que ese campo puede ser nulo en algunas citas
	    return DB::table('agendas')->select(DB::raw('CONCAT(pacientes.nombres, " ", pacientes.apellidos) as title'), 'cita_tipos.color as color', 'fechaHoraInicio as start', 'fechaHoraFin as end', 'agendas.id as id', 'citaTipo_id as citaTipo', 'cita_tipos.nombre as citaTipoNombre', 'tratamiento_id as tratamiento', 'observacion', 'estado', DB::raw('CONCAT(pacientes.nombres, " ", pacientes.apellidos, " (", pacientes.identificacion, ")") as paciente'), 'pacientes.id as pacienteId')->join('pacientes', 'pacientes.id', '=', 'agendas.paciente_id')->join('cita_tipos', 'cita_tipos.id', '=', 'agendas.citaTipo_id')->leftJoin('tratamientos', 'tratamientos.id', '=', 'agendas.tratamiento_id')->where('agendas.user_id', $usuarioId)->where('agendas.deleted_at', null)->where('cita_tipos.deleted_at', null)->where('tratamientos.deleted_at', null)->get();
	}

	public function validateSolape($fechaHoraInicio, $fechaHoraFin, $usuarioId){

	    //se valida que las fechas y horas entre agendas no se crucen, teniendo en cuenta que se usa DB y el no soporte de softdelete
	    $query = "SELECT * FROM (SELECT * FROM agendas WHERE $fechaHoraInicio < fechaHoraInicio AND fechaHoraInicio < $fechaHoraFin OR $fechaHoraInicio < fechaHoraFin AND fechaHoraFin < $fechaHoraFin OR fechaHoraInicio < $fechaHoraInicio AND $fechaHoraInicio < fechaHoraFin OR $fechaHoraInicio LIKE DATE_FORMAT(fechaHoraInicio, '%Y-%m-%d %H:%i') AND $fechaHoraFin LIKE DATE_FORMAT(fechaHoraFin, '%Y-%m-%d %H:%i')) AS agendas WHERE deleted_at IS NULL AND user_id LIKE $usuarioId";

		return DB::select(DB::raw($query));
	}

	public function validateSolapeEdit($fechaHoraInicio, $fechaHoraFin, $agendaId, $usuarioId){

	    //se valida que las fechas y horas entre agendas no se crucen, en edicion, NO teniendo en cuenta la fecha de la cita que estamos editando
	    $query = "SELECT * FROM (SELECT * FROM agendas WHERE $fechaHoraInicio < fechaHoraInicio AND fechaHoraInicio < $fechaHoraFin OR $fechaHoraInicio < fechaHoraFin AND fechaHoraFin < $fechaHoraFin OR fechaHoraInicio < $fechaHoraInicio AND $fechaHoraInicio < fechaHoraFin OR $fechaHoraInicio LIKE DATE_FORMAT(fechaHoraInicio, '%Y-%m-%d %H:%i') AND $fechaHoraFin LIKE DATE_FORMAT(fechaHoraFin, '%Y-%m-%d %H:%i')) AS agendas WHERE deleted_at IS NULL AND id NOT LIKE $agendaId AND user_id LIKE $usuarioId";

		return DB::select(DB::raw($query));
	}
}