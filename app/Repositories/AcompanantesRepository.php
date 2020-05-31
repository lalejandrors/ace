<?php 

namespace Ace\Repositories;

use DB;

class AcompanantesRepository{

	public function findAcompanantes($pacienteId){

	    //para obtener los acompanantes del paciente y mostratlos en su informacion
	    $query = "SELECT DISTINCT a.id as id, CONCAT(a.nombres, ' ', a.apellidos, ' (', a.identificacion, ')') AS acompanante, CONCAT('Teléfono Fijo: ', a.telefonoFijo) AS telefonoFijo, CONCAT('Teléfono Celular: ', a.telefonoCelular) AS telefonoCelular, pa.parentesco AS parentesco FROM pacientes_acompanantes pa JOIN acompanantes a ON a.id = pa.acompanante_id WHERE pa.paciente_id = $pacienteId";

	    return DB::select(DB::raw($query));
	}

	public function findParentescoAcompanante($pacienteId, $acompananteId){

	    //para obtener el parentesco del acompanante del paciente en la impresion de la historia, control o sesion
	    return DB::table('pacientes_acompanantes')->select('parentesco')->where('paciente_id', $pacienteId)->where('acompanante_id', $acompananteId)->first();
	}

}