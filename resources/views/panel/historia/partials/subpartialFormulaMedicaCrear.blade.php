<div class="box-body">

    <h3 style="color: #3097d1;">Crear Formula Médica</h3>
    <p>Todos los campos son requeridos excepto "Observación".</p>

    {{-- Aca generamos los cie10 dinamicamente --}}
    <button class="btn btn-info btnAgregarMedicamento">Agregar Medicamento</button>
    {!! Form::hidden('numeroMedicamentos', 1, ['id' => 'numeroMedicamentos']) !!}
    
    <div class="table-responsive">    
        <table class="table table-bordered table-hover table-striped tabla_formulas" style="margin-top: 30px; table-layout: fixed;">
            <thead>
                <tr>
                    <th style="width: 250px; overflow: auto;">Medicamento</th>
                    <th style="width: 250px; overflow: auto;">Cantidad</th>
                    <th style="width: 250px; overflow: auto;">Dosis/Frecuencia</th>
                    <th style="width: 250px; overflow: auto;">Horas</th>
                    <th style="width: 250px; overflow: auto;">Duración del Tratamiento</th>
                    <th style="width: 250px; overflow: auto;">Vía Medicamento</th>
                    <th style="width: 250px; overflow: auto;">Observación (Opcional)</th>
                    <th style="width: 70px; overflow: auto;">Quitar</th>
                </tr>
            </thead>
            <tbody class="medicamentosConjunto">
                <tr>
                    <td>
                        <div class="form-group">
                            <input id="medicamento1" type="text" class="form-control" style="background-color:#F5F5F5;" placeholder="Nombre del medicamento..."/>
                            <input id="medicamento_id1" type="hidden"/>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="number" id="medicamentoCantidad1" class="form-control" placeholder="Ej: 1 botella, 2 cajas, etc..." min="1" onkeypress="return event.charCode >= 48">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input id="medicamentoDosisFrecuencia1" type="text" class="form-control" placeholder="100 mg cada 6 horas"/>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input id="medicamentoHoras1" type="text" class="form-control" placeholder="9 am, 3 pm..."/>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="text" id="medicamentoDuracion1" class="form-control" placeholder="Ej: 30 días">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <select id="medicamentoVia1" class="form-control">
                                <option value="">----------</option>
                                <option value="1">Oral</option>
                                <option value="2">Sublingual</option>
                                <option value="3">Tópica</option>
                                <option value="4">Transdérmica</option>
                                <option value="5">Oftálmica</option>
                                <option value="6">Ótica</option>
                                <option value="7">Intranasal</option>
                                <option value="8">Inhalatoria</option>
                                <option value="9">Rectal</option>
                                <option value="10">Vaginal</option>
                                <option value="11">Intravenosa</option>
                                <option value="12">Intramuscular</option>
                                <option value="13">Subcutánea</option>
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <textarea id="medicamentoObservacion1" rows="2" class="form-control" placeholder="Observación" style="resize: none;"></textarea>
                        </div>
                    </td>
                    <td class="quitar_medicamento">
                        <a href="#" style="display: block;text-align: center;"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <br>    

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label('formulas__observacion', 'Observación general (Opcional)') !!}
                {!! Form::textarea('formulas__observacion', null, ['class' => 'form-control', 'placeholder' => 'Observación', 'rows' => '2', 'style' => 'resize:none', 'id' => 'formulas__observacion']) !!}
            </div>
        </div>
    </div>
    
</div>