<?php

namespace Ace\Http\Controllers;

use Illuminate\Http\Request;
use Ace\CertificadoMedico;
use Ace\Repositories\CertificadosRepository;
use Ace\InfoCentro;
use Ace\Repositories\PacientesRepository;
use Auth;
use Session;
use PDF;

class CertificadosController extends Controller
{
    private $certificados;
    private $pacientes;

    public function __construct(CertificadosRepository $certificados, PacientesRepository $pacientes)
    {
        $this->certificados = $certificados;
        $this->pacientes = $pacientes;
    }

    public function listar()
    {
        return view('panel.certificado.listar');
    }

    public function datatable(Request $request)
    {
        $certificadosRequest = $request->all();
        //variables traidas por post para server side
        $start = $certificadosRequest['start'];
        $length = $certificadosRequest['length'];
        $search = $certificadosRequest['search']['value'];
        $draw = $certificadosRequest['draw'];
        $certificados = null;
        $certificadosNumero = null;

        //si el usuario logueado es un super o un medico se deben listar solo sus pacientes
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){
            if($search){
                $certificados = $this->certificados->findCertificadosDatatableSearch($start, $length, $search, Auth::user()->id);
                $certificadosNumero = $this->certificados->findCertificadosDatatableSearchNum($search, Auth::user()->id);
            }else{
                $certificados = $this->certificados->findCertificadosDatatable($start, $length, Auth::user()->id);
                $certificadosNumero = $this->certificados->findCertificadosDatatableNum(Auth::user()->id);
            }
        }

        //si el usuario logueado es un asistente se deben listar los pacientes que le pertenecen al medico con el que esta actualmente trabajando
        if(Auth::user()->perfil_id == 3){
            if($search){
                $certificados = $this->certificados->findCertificadosDatatableSearch($start, $length, $search, Session::get('medicoActual')->user->id);
                $certificadosNumero = $this->certificados->findCertificadosDatatableSearchNum($search, Session::get('medicoActual')->user->id);
            }else{
                $certificados = $this->certificados->findCertificadosDatatable($start, $length, Session::get('medicoActual')->user->id);
                $certificadosNumero = $this->certificados->findCertificadosDatatableNum(Session::get('medicoActual')->user->id);
            }
        }

        $datosFinales = count($certificados->toArray());//numero de registros a mostrar por pagina
        $datosProcesados = count($certificadosNumero->toArray());//numero de registros totales

        $datos = array();
        foreach ($certificados as $certificado) {
            $array = array();
            $array['id'] = $certificado->id;
            $array['numero'] = $certificado->numero;
            $array['paciente'] = $certificado->nombres.' '.$certificado->apellidos.'<br>'.'('.$certificado->identificacion.')';

            $entorno = "";//guarda el valor de entorno, segun la formula se haya creado en una historia, control o sesion
            if($certificado->historia != null){
                $entorno = "Certificado creado junto con la historia de número <a href='/panel/historia/ver/" . $certificado->historiaId . "' target='_blank'>" . $certificado->historia . "</a>.";
            }
            if($certificado->control != null){
                $entorno = "Certificado creado junto con el control de número <a href='/panel/control/ver/" . $certificado->controlId . "' target='_blank'>" . $certificado->control . "</a>.";
            }
            if($certificado->sesion != null){
                $entorno = "Certificado creado junto con la sesión de número <a href='/panel/sesion/ver/" . $certificado->sesionId . "' target='_blank'>" . $certificado->sesion . "</a>.";
            }
            
            $array['origen'] = $entorno;
            $array['creado'] = $certificado->created_at;

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

    public function ver($id)
    {
        //envio de datos a la vista
        $certificado = CertificadoMedico::find($id);
        $paciente = $this->pacientes->findPacienteById($certificado->paciente_id);
        $informacion = InfoCentro::find(1);

        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico...
            $this->authorize('ownerOne', $certificado);
        }

        if(Auth::user()->perfil_id == 3){//si mi usuario actual es un asistente, la policy cambia ya que se compara el id del medico que esta en la sesion, no del usuario actual
            $this->authorize('ownerTwo', $certificado);
        }

        $pdf = PDF::loadView('panel.certificado.ver', ['certificado' => $certificado, 'paciente' => $paciente, 'informacion' => $informacion]);
        return $pdf->stream();
    }

}
