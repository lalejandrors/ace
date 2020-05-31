<?php 

namespace Ace\Repositories;

use DB;

class PacientesRepository{

	//PARA DATATABLES
	public function findPacientesDatatableSearch($start, $length, $search, $usuarioId){

	    return DB::table('pacientes')->select('pacientes.id', 'identificacion', 'nombres', 'apellidos', 'fechaNacimiento', 'telefonoFijo', 'telefonoCelular', 'ciudads.nombre as ciudad', 'departamentos.nombre as departamento', 'direccion', 'email', 'created_at')->join('ciudads', 'ciudads.id', '=', 'pacientes.ciudad_id')->join('departamentos', 'departamentos.id', '=', 'ciudads.departamento_id')->where('pacientes.user_id', $usuarioId)->where('identificacion', 'like', '%'.$search.'%')->orWhere('nombres', 'like', '%'.$search.'%')->orWhere('apellidos', 'like', '%'.$search.'%')->offset($start)->limit($length)->orderBy('pacientes.id','DESC')->get();
	}

	public function findPacientesDatatableSearchNum($search, $usuarioId){

	    return DB::table('pacientes')->select('pacientes.id', 'identificacion', 'nombres', 'apellidos', 'fechaNacimiento', 'telefonoFijo', 'telefonoCelular', 'ciudads.nombre as ciudad', 'departamentos.nombre as departamento', 'direccion', 'email', 'created_at')->join('ciudads', 'ciudads.id', '=', 'pacientes.ciudad_id')->join('departamentos', 'departamentos.id', '=', 'ciudads.departamento_id')->where('pacientes.user_id', $usuarioId)->where('identificacion', 'like', '%'.$search.'%')->orWhere('nombres', 'like', '%'.$search.'%')->orWhere('apellidos', 'like', '%'.$search.'%')->orderBy('pacientes.id','DESC')->get();
	}

	public function findPacientesDatatable($start, $length, $usuarioId){

	    return DB::table('pacientes')->select('pacientes.id', 'identificacion', 'nombres', 'apellidos', 'fechaNacimiento', 'telefonoFijo', 'telefonoCelular', 'ciudads.nombre as ciudad', 'departamentos.nombre as departamento', 'direccion', 'email', 'created_at')->join('ciudads', 'ciudads.id', '=', 'pacientes.ciudad_id')->join('departamentos', 'departamentos.id', '=', 'ciudads.departamento_id')->where('pacientes.user_id', $usuarioId)->offset($start)->limit($length)->orderBy('pacientes.id','DESC')->get();
	}

	public function findPacientesDatatableNum($usuarioId){

	    return DB::table('pacientes')->select('pacientes.id', 'identificacion', 'nombres', 'apellidos', 'fechaNacimiento', 'telefonoFijo', 'telefonoCelular', 'ciudads.nombre as ciudad', 'departamentos.nombre as departamento', 'direccion', 'email', 'created_at')->join('ciudads', 'ciudads.id', '=', 'pacientes.ciudad_id')->join('departamentos', 'departamentos.id', '=', 'ciudads.departamento_id')->where('pacientes.user_id', $usuarioId)->orderBy('pacientes.id','DESC')->get();
	}
	//END PARA DATATABLES

	public function findPacienteById($pacienteId){

	    //para traer los datos del paciente a la historia clinica a partir del autocomplete en historia clinica
	    return DB::table('pacientes')->select('identificacion', 'tipoId', 'nombres', 'apellidos', DB::raw('TIMESTAMPDIFF(YEAR,fechaNacimiento,CURDATE()) as edad'), 'genero', 'hijos', 'estadoCivil', 'telefonoFijo', 'telefonoCelular', 'ciudads.nombre as ciudad', 'departamentos.nombre as departamento', 'direccion', 'ubicacion', 'email', 'eps.nombre as eps', 'ocupacion')->join('ciudads', 'ciudads.id', '=', 'pacientes.ciudad_id')->join('departamentos', 'departamentos.id', '=', 'ciudads.departamento_id')->join('eps', 'eps.id', '=', 'pacientes.eps_id')->where('pacientes.id', $pacienteId)->first();
	}

	//consultas de los reportes////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function findConsulta1ConGenero($genero, $min, $max, $usuarioId){

	    //consulta 1
	    return DB::table('pacientes')->select('pacientes.id', 'nombres', 'apellidos', 'identificacion', 'fechaNacimiento', 'email', 'direccion', 'ciudads.nombre as ciudad', 'departamentos.nombre as departamento', DB::raw('TIMESTAMPDIFF(YEAR,fechaNacimiento,CURDATE()) as edad'), 'pacientes.created_at')->join('ciudads', 'ciudads.id', '=', 'pacientes.ciudad_id')->join('departamentos', 'departamentos.id', '=', 'ciudads.departamento_id')->where('user_id', $usuarioId)->where('genero', $genero)->whereBetween('fechaNacimiento', [$max, $min])->orderBy('pacientes.id','DESC')->get();
	}

	public function findConsulta1SinGenero($min, $max, $usuarioId){

	    //tambien consulta 1
	    return DB::table('pacientes')->select('pacientes.id', 'nombres', 'apellidos', 'identificacion', 'fechaNacimiento', 'email', 'direccion', 'ciudads.nombre as ciudad', 'departamentos.nombre as departamento', DB::raw('TIMESTAMPDIFF(YEAR,fechaNacimiento,CURDATE()) as edad'), 'pacientes.created_at')->join('ciudads', 'ciudads.id', '=', 'pacientes.ciudad_id')->join('departamentos', 'departamentos.id', '=', 'ciudads.departamento_id')->where('user_id', $usuarioId)->whereBetween('fechaNacimiento', [$max, $min])->orderBy('pacientes.id','DESC')->get();
	}

	public function findConsulta2($ciudad, $usuarioId){

	    //consulta 2
	    return DB::table('pacientes')->select('pacientes.id', 'nombres', 'apellidos', 'identificacion', 'fechaNacimiento', 'email', 'direccion', 'ciudads.nombre as ciudad', 'departamentos.nombre as departamento', DB::raw('TIMESTAMPDIFF(YEAR,fechaNacimiento,CURDATE()) as edad'), 'pacientes.created_at')->join('ciudads', 'ciudads.id', '=', 'pacientes.ciudad_id')->join('departamentos', 'departamentos.id', '=', 'ciudads.departamento_id')->where('user_id', $usuarioId)->where('ciudad_id', $ciudad)->orderBy('pacientes.id','DESC')->get();
	}

	public function findConsulta3($min, $max, $usuarioId){

	    //consulta 3
	    return DB::table('pacientes')->select('pacientes.id', 'nombres', 'apellidos', 'identificacion', 'fechaNacimiento', 'email', 'direccion', 'ciudads.nombre as ciudad', 'departamentos.nombre as departamento', DB::raw('TIMESTAMPDIFF(YEAR,fechaNacimiento,CURDATE()) as edad'), 'pacientes.created_at')->join('ciudads', 'ciudads.id', '=', 'pacientes.ciudad_id')->join('departamentos', 'departamentos.id', '=', 'ciudads.departamento_id')->where('user_id', $usuarioId)->where('hijos', 1)->whereBetween('fechaNacimiento', [$max, $min])->orderBy('pacientes.id','DESC')->get();
	}

	public function findConsulta4Semana($usuarioId){

	    //consulta 4
	    $query = "SELECT * FROM (SELECT pacientes.id, nombres, apellidos, identificacion, fechaNacimiento, email, direccion, ciudads.nombre as ciudad, departamentos.nombre as departamento, TIMESTAMPDIFF(YEAR,fechaNacimiento,CURDATE()) as edad, pacientes.created_at FROM pacientes JOIN ciudads ON ciudads.id = pacientes.ciudad_id JOIN departamentos ON departamentos.id = ciudads.departamento_id WHERE user_id LIKE $usuarioId AND DATE_ADD(fechaNacimiento, INTERVAL YEAR(CURDATE())-YEAR(fechaNacimiento) + IF(DAYOFYEAR(CURDATE()) > DAYOFYEAR(fechaNacimiento),1,0) YEAR) BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY) ORDER BY pacientes.id DESC) as pacientes";

	    return DB::select(DB::raw($query));
	}

	public function findConsulta4Dia($usuarioId){

	    //tambien consulta 4
	    return DB::table('pacientes')->select('pacientes.id', 'nombres', 'apellidos', 'identificacion', 'fechaNacimiento', 'email', 'direccion', 'ciudads.nombre as ciudad', 'departamentos.nombre as departamento', DB::raw('TIMESTAMPDIFF(YEAR,fechaNacimiento,CURDATE()) as edad'), 'pacientes.created_at')->join('ciudads', 'ciudads.id', '=', 'pacientes.ciudad_id')->join('departamentos', 'departamentos.id', '=', 'ciudads.departamento_id')->where('user_id', $usuarioId)->whereMonth('fechaNacimiento', DB::raw('MONTH(CURDATE())'))->whereDay('fechaNacimiento', DB::raw('DAY(CURDATE())'))->orderBy('pacientes.id','DESC')->get();
	}

	public function findConsulta5($cie10, $usuarioId){

	    //consulta 5
	    return DB::table('pacientes')->select('pacientes.id', 'nombres', 'apellidos', 'identificacion', 'fechaNacimiento', 'email', 'direccion', 'ciudads.nombre as ciudad', 'departamentos.nombre as departamento', DB::raw('TIMESTAMPDIFF(YEAR,fechaNacimiento,CURDATE()) as edad'), 'pacientes.created_at')->join('ciudads', 'ciudads.id', '=', 'pacientes.ciudad_id')->join('departamentos', 'departamentos.id', '=', 'ciudads.departamento_id')->join('pacientes_cie10s', 'paciente_id', '=', 'pacientes.id')->join('cie10s', 'cie10_id', '=', 'cie10s.id')->where('user_id', $usuarioId)->where('cie10_id', $cie10)->orderBy('pacientes.id','DESC')->distinct()->get();
	}

	public function findConsulta6Recibido($tratamiento, $usuarioId){

	    //consulta 6
	    return DB::table('pacientes')->select('pacientes.id', 'nombres', 'apellidos', 'identificacion', 'fechaNacimiento', 'email', 'direccion', 'ciudads.nombre as ciudad', 'departamentos.nombre as departamento', DB::raw('TIMESTAMPDIFF(YEAR,fechaNacimiento,CURDATE()) as edad'), 'pacientes.created_at')->join('ciudads', 'ciudads.id', '=', 'pacientes.ciudad_id')->join('departamentos', 'departamentos.id', '=', 'ciudads.departamento_id')->join('formula_tratamientos', 'paciente_id', '=', 'pacientes.id')->join('item_formula_tratamientos', 'formulaTratamiento_id', '=', 'formula_tratamientos.id')->join('tratamientos', 'tratamientos.id', '=', 'item_formula_tratamientos.tratamiento_id')->where('pacientes.user_id', $usuarioId)->where('tratamientos.id', $tratamiento)->orderBy('pacientes.id','DESC')->get();
	}

	public function findConsulta6NoRecibido($tratamiento, $usuarioId){

	    //tambien consulta 6
	    return DB::table('pacientes')->select('pacientes.id', 'nombres', 'apellidos', 'identificacion', 'fechaNacimiento', 'email', 'direccion', 'ciudads.nombre as ciudad', 'departamentos.nombre as departamento', DB::raw('TIMESTAMPDIFF(YEAR,fechaNacimiento,CURDATE()) as edad'), 'pacientes.created_at')->join('ciudads', 'ciudads.id', '=', 'pacientes.ciudad_id')->join('departamentos', 'departamentos.id', '=', 'ciudads.departamento_id')->where('pacientes.user_id', $usuarioId)->whereNotIn('pacientes.id', function($q) use($usuarioId, $tratamiento){$q->select('pacientes.id')->from('pacientes')->join('formula_tratamientos', 'paciente_id', '=', 'pacientes.id')->join('item_formula_tratamientos', 'formulaTratamiento_id', '=', 'formula_tratamientos.id')->join('tratamientos', 'tratamientos.id', '=', 'item_formula_tratamientos.tratamiento_id')->where('pacientes.user_id', $usuarioId)->where('tratamientos.id', $tratamiento);
		})->orderBy('pacientes.id','DESC')->get();
	}

	public function findConsulta7($tratamiento, $usuarioId){

	    //consulta 6
	    return DB::table('pacientes')->select('pacientes.id', 'nombres', 'apellidos', 'identificacion', 'fechaNacimiento', 'email', 'direccion', 'ciudads.nombre as ciudad', 'departamentos.nombre as departamento', DB::raw('TIMESTAMPDIFF(YEAR,fechaNacimiento,CURDATE()) as edad'), 'pacientes.created_at')->join('ciudads', 'ciudads.id', '=', 'pacientes.ciudad_id')->join('departamentos', 'departamentos.id', '=', 'ciudads.departamento_id')->join('formula_tratamientos', 'paciente_id', '=', 'pacientes.id')->join('item_formula_tratamientos', 'formulaTratamiento_id', '=', 'formula_tratamientos.id')->join('tratamientos', 'tratamientos.id', '=', 'item_formula_tratamientos.tratamiento_id')->where('pacientes.user_id', $usuarioId)->where('tratamientos.id', $tratamiento)->where('item_formula_tratamientos.fechaPosibleTerminacion', '<', DB::raw('CURDATE()'))->where('item_formula_tratamientos.activo', 1)->orderBy('pacientes.id','DESC')->get();
	}

}