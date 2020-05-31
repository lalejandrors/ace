<div class="box-body">

    <h3 style="color: #3097d1;">Crear Formulación de Tratamientos</h3>
    <p>Todos los campos son requeridos excepto "Observación".</p>

    {{-- Aca generamos los tratamientos dinamicamente --}}
    <button class="btn btn-info btnAgregarTratamiento">Agregar Tratamiento</button>
    {!! Form::hidden('numeroTratamientos', 1, ['id' => 'numeroTratamientos']) !!}
        
    <div class="table-responsive">    
        <table class="table table-bordered table-hover table-striped tabla_formulasTratamiento" style="margin-top: 30px; table-layout: fixed;">
            <thead>
                <tr>
                    <th style="width: 250px; overflow: auto;">Tratamiento</th>
                    <th style="width: 250px; overflow: auto;">Número de Sesiones</th>
                    <th style="width: 250px; overflow: auto;">Fecha Posible Terminación</th>
                    <th style="width: 250px; overflow: auto;">Observación (Opcional)</th>
                    <th style="width: 70px; overflow: auto;">Quitar</th>
                </tr>
            </thead>
            <tbody class="tratamientosConjunto">
                <tr>
                    <td>
                        <div class="form-group">
                            <input id="tratamiento1" type="text" class="form-control" style="background-color:#F5F5F5;" placeholder="Nombre del tratamiento..."/>
                            <input id="tratamiento_id1" type="hidden"/>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="number" id="tratamientoNumeroSesiones1" class="form-control" min="1" onkeypress="return event.charCode >= 48">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input id="tratamientoFechaPosibleTerminacion1" type="text" class="datepickermindynamic form-control" placeholder="Seleccione una fecha..."/>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <textarea id="tratamientoObservacion1" rows="2" class="form-control" placeholder="Observación" style="resize: none;"></textarea>
                        </div>
                    </td>
                    <td class="quitar_tratamiento">
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
                {!! Form::label('tratamientos__observacion', 'Observación general (Opcional)') !!}
                {!! Form::textarea('tratamientos__observacion', null, ['class' => 'form-control', 'placeholder' => 'Observación', 'rows' => '2', 'style' => 'resize:none', 'id' => 'tratamientos__observacion']) !!}
            </div>
        </div>
    </div>
    
</div>