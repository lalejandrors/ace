<?php

namespace Ace;

use Illuminate\Database\Eloquent\Model;

class HistoriaClinica extends Model
{
    protected $table = "historia_clinicas";

    protected $fillable = ['numero', 'paciente_id', 'acompanante_id', 'parentescoDiabetes', 'parentescoHipertension', 'parentescoCardiopatia', 'parentescoHepatopatia', 'parentescoNefropatia', 'parentescoEnfermedadesMentales', 'parentescoAsma', 'parentescoCancer', 'parentescoEnfermedadesAlergicas', 'parentescoEnfermedadesEndocrinas', 'otrosDescripcion', 'parentescoOtros', 'descripcionQuirurgicos', 'descripcionTransfusionales', 'descripcionAlergias', 'descripcionTraumaticos', 'descripcionHospitalizacionesPrevias', 'descripcionAdicciones', 'descripcionOtros', 'bano', 'banoDientes', 'servicioAguaPotable', 'cigarrillosDiarios', 'anosFumando', 'alcoholismoFrecuencia', 'comidasDiarias', 'calidadComida', 'actividadFisica', 'inmunizaciones', 'inmunizacionesPendientes', 'ultimaDesparacitacion', 'menarca', 'ritmoMenstrual', 'dismenorrea', 'fum', 'ivsa', 'numeroParejas', 'fpp', 'fup', 'menopausia', 'metodoPlanificacion', 'citologiaVaginal', 'examenMamas', 'padecimientoActual', 'astenia', 'adinamia', 'anorexia', 'fiebre', 'perdidaPeso', 'aparatoDigestivo', 'aparatoCardiovascular', 'aparatoRespiratorio', 'aparatoUrinario', 'aparatoGenital', 'aparatoHematologico', 'sistemaEndocrino', 'sistemaOsteomuscular', 'sistemaNervioso', 'sistemaSensorial', 'psicosomatico', 'terapeuticaAnterior', 'ta', 'fc', 'fr', 'temp', 'peso', 'talla', 'conciencia', 'hidratacion', 'coloracion', 'marcha', 'otrasAlteraciones', 'normocefalo', 'cabello', 'pupilas', 'faringe', 'amigdalas', 'nariz', 'adenomegaliasCabeza', 'cuello', 'adenomegaliasCuello', 'pulsos', 'torax', 'movResp', 'camposPulmonares', 'ruidosCardiacos', 'adenomegaliasAxilares', 'adenomegaliasAxilaresDescripcion', 'abdomen', 'dolorPalpacion', 'dolorPalpacionDescripcion', 'visceromegalias', 'peristalsis', 'peristalsisDescripcion', 'miembrosSuperiores', 'miembrosInferiores', 'genitales', 'impresionDiagnostica', 'tratamiento', 'observacion', 'user_id'];

    public function user()
    {
        return $this->belongsTo('Ace\User');
    }

    public function paciente()
    {
        return $this->belongsTo('Ace\Paciente');
    }

    public function acompanante()
    {
        return $this->belongsTo('Ace\Acompanante');
    }

    public function certificadosMedicos()
    {
        return $this->hasMany('Ace\CertificadoMedico');
    }

    public function formulas()
    {
        return $this->hasMany('Ace\Formula');
    }

    public function consentimientos()
    {
        return $this->hasMany('Ace\Consentimiento');
    }

    public function incapacidadesMedicas()
    {
        return $this->hasMany('Ace\IncapacidadMedica');
    }

    public function formulasTratamientos()
    {
        return $this->hasMany('Ace\FormulaTratamiento');
    }

    public function cie10s()
    {
        return $this->belongsToMany('Ace\Cie10','historia_clinicas_cie10s','historiaClinica_id','cie10_id')->withTimestamps();
    }
}
