<?php 

namespace Ace\Repositories;

use DB;

class CertificadosRepository{

	//PARA DATATABLES
	public function findCertificadosDatatableSearch($start, $length, $search, $usuarioId){

	    return DB::table('certificado_medicos')->select('certificado_medicos.id', 'certificado_medicos.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'certificado_medicos.created_at', 'historia_clinicas.numero as historia', 'historia_clinicas.id as historiaId', 'controls.numero as control', 'controls.id as controlId', 'sesions.numero as sesion', 'sesions.id as sesionId')->join('pacientes', 'pacientes.id', '=', 'certificado_medicos.paciente_id')->leftJoin('historia_clinicas', 'historia_clinicas.id', '=', 'certificado_medicos.historiaClinica_id')->leftJoin('controls', 'controls.id', '=', 'certificado_medicos.control_id')->leftJoin('sesions', 'sesions.id', '=', 'certificado_medicos.sesion_id')->where('certificado_medicos.user_id', $usuarioId)->where('certificado_medicos.numero', 'like', '%'.$search.'%')->orWhere('pacientes.identificacion', 'like', '%'.$search.'%')->orWhere('pacientes.nombres', 'like', '%'.$search.'%')->orWhere('pacientes.apellidos', 'like', '%'.$search.'%')->offset($start)->limit($length)->orderBy('certificado_medicos.id','DESC')->get();
	}

	public function findCertificadosDatatableSearchNum($search, $usuarioId){

	    return DB::table('certificado_medicos')->select('certificado_medicos.id', 'certificado_medicos.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'certificado_medicos.created_at', 'historia_clinicas.numero as historia', 'historia_clinicas.id as historiaId', 'controls.numero as control', 'controls.id as controlId', 'sesions.numero as sesion', 'sesions.id as sesionId')->join('pacientes', 'pacientes.id', '=', 'certificado_medicos.paciente_id')->leftJoin('historia_clinicas', 'historia_clinicas.id', '=', 'certificado_medicos.historiaClinica_id')->leftJoin('controls', 'controls.id', '=', 'certificado_medicos.control_id')->leftJoin('sesions', 'sesions.id', '=', 'certificado_medicos.sesion_id')->where('certificado_medicos.user_id', $usuarioId)->where('certificado_medicos.numero', 'like', '%'.$search.'%')->orWhere('pacientes.identificacion', 'like', '%'.$search.'%')->orWhere('pacientes.nombres', 'like', '%'.$search.'%')->orWhere('pacientes.apellidos', 'like', '%'.$search.'%')->orderBy('certificado_medicos.id','DESC')->get();
	}

	public function findCertificadosDatatable($start, $length, $usuarioId){

	    return DB::table('certificado_medicos')->select('certificado_medicos.id', 'certificado_medicos.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'certificado_medicos.created_at', 'historia_clinicas.numero as historia', 'historia_clinicas.id as historiaId', 'controls.numero as control', 'controls.id as controlId', 'sesions.numero as sesion', 'sesions.id as sesionId')->join('pacientes', 'pacientes.id', '=', 'certificado_medicos.paciente_id')->leftJoin('historia_clinicas', 'historia_clinicas.id', '=', 'certificado_medicos.historiaClinica_id')->leftJoin('controls', 'controls.id', '=', 'certificado_medicos.control_id')->leftJoin('sesions', 'sesions.id', '=', 'certificado_medicos.sesion_id')->where('certificado_medicos.user_id', $usuarioId)->offset($start)->limit($length)->orderBy('certificado_medicos.id','DESC')->get();
	}

	public function findCertificadosDatatableNum($usuarioId){

	    return DB::table('certificado_medicos')->select('certificado_medicos.id', 'certificado_medicos.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'certificado_medicos.created_at', 'historia_clinicas.numero as historia', 'historia_clinicas.id as historiaId', 'controls.numero as control', 'controls.id as controlId', 'sesions.numero as sesion', 'sesions.id as sesionId')->join('pacientes', 'pacientes.id', '=', 'certificado_medicos.paciente_id')->leftJoin('historia_clinicas', 'historia_clinicas.id', '=', 'certificado_medicos.historiaClinica_id')->leftJoin('controls', 'controls.id', '=', 'certificado_medicos.control_id')->leftJoin('sesions', 'sesions.id', '=', 'certificado_medicos.sesion_id')->where('certificado_medicos.user_id', $usuarioId)->orderBy('certificado_medicos.id','DESC')->get();
	}
	//END PARA DATATABLES

}