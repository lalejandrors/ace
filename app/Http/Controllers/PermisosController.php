<?php

namespace Ace\Http\Controllers;

use Illuminate\Http\Request;
use Ace\User;
use Ace\Permiso;
use Ace\Repositories\PermisosRepository;

class PermisosController extends Controller
{
    private $permisos;

    public function __construct(PermisosRepository $permisos)
    {
        $this->permisos = $permisos;
    }

    public function listar()
    {
        return view('panel.permiso.listar');
    }

    public function datatable(Request $request)
    {
        $permisosRequest = $request->all();
        //variables traidas por post para server side
        $start = $permisosRequest['start'];
        $length = $permisosRequest['length'];
        $search = $permisosRequest['search']['value'];
        $draw = $permisosRequest['draw'];
        $permisos = null;
        $permisosNumero = null;

        //si el usuario logueado es un asistente se deben listar los pacientes que le pertenecen al medico con el que esta actualmente trabajando
        if($search){
            $permisos = $this->permisos->findPermisosDatatableSearch($start, $length, $search);
            $permisosNumero = $this->permisos->findPermisosDatatableSearchNum($search);
        }else{
            $permisos = $this->permisos->findPermisosDatatable($start, $length);
            $permisosNumero = $this->permisos->findPermisosDatatableNum();
        }

        $datosFinales = count($permisos->toArray());//numero de registros a mostrar por pagina
        $datosProcesados = count($permisosNumero->toArray());//numero de registros totales

        $datos = array();
        foreach ($permisos as $permiso) {
            $array = array();
            $array['id'] = $permiso->id;
            $array['nombre'] = $permiso->nombres.' '.$permiso->apellidos.'<br>('.$permiso->username.')';
            
            $medicosCadena = '<ul style="padding-left: 20px;text-align: left;">';         
            $medicos = $this->permisos->findMedicosPermisosDatatable($permiso->id);
            foreach ($medicos as $medico) {
                $medicosCadena = $medicosCadena.'<li>'.$medico->nombres.' '.$medico->apellidos.'</li>';
            }
            $medicosCadena = $medicosCadena.'</ul>';
            $array['medicos'] = $medicosCadena;
            
            $estado = '';
            if($permiso->activo == 0){
                $estado = '<span class="label label-default">Inactivo</span>';
            }
            if($permiso->activo == 1){
                $estado = '<span class="label label-success">Activo</span>';
            }
            $array['estado'] = $estado;

            $permisosListaCadena = '<ul style="padding-left: 20px;text-align: left;">';         
            $permisosLista = $this->permisos->findPermisosListaPermisosDatatable($permiso->id);
            foreach ($permisosLista as $permisoLista) {
                $permisosListaCadena = $permisosListaCadena.'<li>'.$permisoLista->nombre.'</li>';
            }
            $permisosListaCadena = $permisosListaCadena.'</ul>';
            $array['permisos'] = $permisosListaCadena;

            $datos[] = $array;
        }
        
        $json_data = array(
            "draw" => intval($draw),
            "recordsTotal" => intval($datosFinales),
            "recordsFiltered" => intval($datosProcesados),
            "data" => $datos
        );

        echo json_encode($json_data);
    }

    public function edicion($id)
    {
        $user = User::find($id);
        
        $permisos = Permiso::where('id','not like',2)->where('id','not like',7)->pluck('nombre','id');//cargamos todos los permisos, menos el 2 y el 7 que son exvlusivos de los super y medicos

        $misPermisos = $user->permisos->pluck('id')->toArray();//obtengo los permisos que ya se encuentran asociados con el asistente en cuestion

        return Response()->json(array('permisos'=>$permisos,'user'=>$user,'misPermisos'=>$misPermisos));
    }

    public function editar($id, Request $request)
    {
        if($request->ajax()){    
            $user = User::find($id);

            //llenado de la tabla intermedia, entre usuarios y permisos
            if(isset($request['permisos'])){//si hay algo de permisos, que se sincronice
                $user->permisos()->sync($request['permisos']);
            }else{//si no se eligio ninguno, que se borren los que habian antes
                $user->permisos()->detach();
            }

            return response()->json([
                "mensaje" => "Ok"
            ]);
        }
    }

}
