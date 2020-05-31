<?php 

namespace Ace\Repositories;

use DB;

class PermisosRepository{

	public function findMedicosPermisosDatatable($asistente){

	    return DB::table('users_medicos')->select('users.nombres', 'users.apellidos')->join('medicos', 'users_medicos.medico_id', '=', 'medicos.id')->join('users', 'medicos.id', '=', 'users.medico_id')->where('user_id', $asistente)->whereNull('users.deleted_at')->orderBy('users.id','DESC')->get();
	}

	public function findPermisosListaPermisosDatatable($asistente){

	    return DB::table('users_permisos')->select('permisos.nombre')->join('permisos', 'users_permisos.permiso_id', '=', 'permisos.id')->where('users_permisos.user_id', $asistente)->orderBy('permisos.id','DESC')->get();
	}

	//PARA DATATABLES
	public function findPermisosDatatableSearch($start, $length, $search){

	    return DB::table('users')->select('id', 'username', 'nombres', 'apellidos', 'activo')->where('perfil_id', 3)->where('nombres', 'like', '%'.$search.'%')->orWhere('apellidos', 'like', '%'.$search.'%')->whereNull('deleted_at')->offset($start)->limit($length)->orderBy('id','DESC')->get();
	}

	public function findPermisosDatatableSearchNum($search){

	    return DB::table('users')->select('id', 'username', 'nombres', 'apellidos', 'activo')->where('perfil_id', 3)->where('nombres', 'like', '%'.$search.'%')->orWhere('apellidos', 'like', '%'.$search.'%')->whereNull('deleted_at')->orderBy('id','DESC')->get();
	}

	public function findPermisosDatatable($start, $length){

	    return DB::table('users')->select('id', 'username', 'nombres', 'apellidos', 'activo')->where('perfil_id', 3)->whereNull('deleted_at')->offset($start)->limit($length)->orderBy('id','DESC')->get();
	}

	public function findPermisosDatatableNum(){

	    return DB::table('users')->select('id', 'username', 'nombres', 'apellidos', 'activo')->where('perfil_id', 3)->whereNull('deleted_at')->orderBy('id','DESC')->get();
	}
	//END PARA DATATABLES

}