<div class="row">
    <div class="panel panel-default">
        <div class="page-title">
            <div class="row">
                <div class="col-lg-5 col-lg-offset-8">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Extra <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#" onclick="obj.showModalJustif()">Activo / Inactivo</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <button class="btn btn-success btn-sm" id='btnNew'>
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"> Nuevo</span>
                            </button>
                            <button class="btn btn-success btn-sm" id='btnSave' disabled>
                                <span class="glyphicon glyphicon-ok" aria-hidden="true"> Guardar</span>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body">
            {!! Form::open(['id'=>'frm','files' => true]) !!}
            <div class="row">
                <div class="col-lg-8 col-center">
                    <div class="row">
                        <input type="hidden" id="id" name="id" class="input-stakeholder">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="address">Cuenta</label>
                                <input type="text" class="form-control input-stakeholder input-sm" id="business" name="business">
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="address">Razón Social</label>
                                <input type="text" class="form-control input-stakeholder input-sm" id="business_name" name="business_name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="address" class="control-label ">Tipo Documento *</label>
                                <select id="type_document" name="type_document" class="form-control input-stakeholder input-sm" required>
                                    <option value="0">Selección</option>
                                    @foreach($type_document as $val)
                                    <option value="{{$val->code}}">{{$val->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="address" class="control-label">Documento *</label>
                                <input type="text" class="form-control input-stakeholder input-sm" id="document" name="document"required>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="address" class="control-label">Dígito de Verificación</label>
                                <input type="text" class="form-control input-stakeholder input-sm" id="verification" name="verification"  readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="address" class="control-label">Tipo Persona*</label>
                                <select class="form-control input-stakeholder input-sm"  id="type_regime_id" name="type_regime_id" required>
                                    <option value="0">Selección</option>
                                    @foreach($type_person as $val)
                                    <option value="{{$val->code}}">{{$val->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="address" class="control-label">Tipo Regimen*</label>
                                <select id="type_person_id" name="type_person_id" class="form-control input-stakeholder input-sm" required>
                                    <option value="0">Selección</option>
                                    @foreach($type_regimen as $val)
                                    <option value="{{$val->code}}">{{$val->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="address">Plazo de Pago</label>
                                <input type="text" class="form-control input-stakeholder input-sm" id="term" name="term">
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="address">Ciudad</label>
                                <select class="form-control input-stakeholder input-sm"  id="city_id" name="city_id" data-api="/api/getCity">
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="address" class="control-label">Dirección *</label>
                                <input type="text" class="form-control input-stakeholder input-sm" id="address" name="address"  required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="address">Teléfono</label>
                                <input type="text" class="form-control input-stakeholder input-sm" id="phone" name="phone" >
                            </div>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="address">Sitio Web</label>
                                <input type="text" class="form-control input-stakeholder" id="web_site" name="web_site">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="address">Correo</label>
                                <input type="text" class="form-control input-stakeholder" id="email" name="email">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="address" class="control-label">Terminación de Contrato</label>
                                <input type="datetime" class="form-control input-stakeholder" id="contract_expiration" name="contract_expiration"
                                       value="{{date("Y-m-d H:i")}}">
                            </div>
                        </div>  

                    </div>

                    <div class="row">
                        
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="address" class="control-label">Responsable</label>
                                <select class="form-control input-stakeholder"  id="responsible_id" name="responsible_id" data-api="/api/getResponsable" required>
                                </select>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            {!!Form::close()!!}
            <div class="row">
                <div class="col-lg-8 col-center">
                    <div class="row">
                        <div class="col-lg-1">
                            <button class="btn btn-success" type="button" id="modalImage"><i class="fa fa-cloud-upload" aria-hidden="true"></i></button>
                        </div>
                        <div class="col-lg-5">
                            <div class="row" i>
                                <table class="table table-condensed table-striped" id="contentAttach">
                                    <thead>
                                        <tr>
                                            <th>Documento</th>
                                            <th>Archivo</th>
                                            <th>Ver</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="modelActive">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Activar / Desactivar</h4>
            </div>
            <div class="modal-body">
                <form id="frmJustify">
                    <input class="input-justify" type="hidden" id="stakeholder_id" name="stakeholder_id">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="address" class="control-label">Estatus</label>
                                <select id="status_id" name="status_id" class="form-control input-justify" required>
                                    <option value="0">Selección</option>
                                    @foreach($status as $val)
                                    <option value="{{$val->code}}">{{$val->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="address" class="control-label">Justificación</label>
                                <textarea class="form-control input-justify" name="justification" id="justification" required></textarea>
                            </div>
                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-success" id="addJustify">Guardar</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div>


@include('Suppliers.Supplier.modalUpload')
