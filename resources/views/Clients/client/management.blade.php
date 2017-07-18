<div class="row">
    <div class="col-lg-8">
        <div class="panel panel-default">
            <div class="page-title">
                <div class="row">
                    <div class="col-lg-5 col-lg-offset-7">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Extra <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" onclick="obj.showModalJustif()">Activar / Desactivar</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <button class="btn btn-primary btn-sm" id='btnNew'>
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"> Nuevo</span>
                                </button>
                                <button class="btn btn-primary btn-sm" id='btnSave' disabled="">
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
                    <div class="col-lg-12">
                        <br>
                        <br>
                        <div class="panel panel-default">
                            <div class="panel-heading">Información Cuenta</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="address">Cuenta *</label>
                                            <input type="text" class="form-control input-clients input-sm" id="business" name="business" required disabled="">
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label for="address">Razón Social *</label>
                                            <input type="text" class="form-control input-clients input-sm" id="business_name" name="business_name" required disabled="">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="address" class="control-label">Tipo Documento *</label>
                                            <select id="type_document" name="type_document" class="form-control input-clients input-sm" required disabled>
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
                                            <input type="text" class="form-control input-clients input-sm" id="document" name="document"  required disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="address" class="control-label">Dígito de Verificación *</label>
                                            <input type="text" class="form-control input-clients input-sm" id="verification" name="verification" readonly disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <input type="hidden" id="id" name="id" class="input-clients">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="address" class="control-label">Tipo Persona*</label>
                                            <select class="form-control input-clients input-sm"  id="type_regime_id" name="type_regime_id" required disabled>
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
                                            <select id="type_person_id" name="type_person_id" class="form-control input-clients input-sm" required disabled>
                                                <option value="0">Selección</option>
                                                @foreach($type_regimen as $val)
                                                <option value="{{$val->code}}">{{$val->description}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="address">Plazo de Pago *</label>
                                            <input type="text" class="form-control input-clients input-sm" id="term" name="term" required disabled>
                                        </div>
                                    </div>

                                </div>


                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="address">Ciudad</label>
                                            <select class="form-control input-clients input-sm"  id="city_id" name="city_id" data-api="/api/getCity" disabled>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="address">Teléfono</label>
                                            <input type="text" class="form-control input-clients input-sm" id="phone" name="phone" disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="address" class="control-label">Responsable</label>
                                            <select class="form-control input-clients"  id="responsible_id" name="responsible_id" data-api="/api/getResponsable" required disabled>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="address">Correo</label>
                                            <input type="text" class="form-control input-clients input-sm" id="email" name="email" disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="address">Sitio Web</label>
                                            <input type="text" class="form-control input-clients input-sm" id="web_site" name="web_site" disabled>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="row">
                                            <div class="col-lg-11">
                                                <div class="form-group">
                                                    <label for="address">Cuenta Principal</label>
                                                    <select class="form-control input-clients"  id="stakeholder_id" name="stakeholder_id" data-api="/api/getClient" disabled>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-1">
                                                <span class="glyphicon glyphicon-remove" aria-hidden="true"  style="top:30px;cursor:pointer" id="cleanSelect2"></span>
                                            </div>
                                        </div>


                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="address" class="control-label">Sector *</label>
                                            <select id="sector_id" name="sector_id" class="form-control input-clients input-sm" required="" disabled>
                                                <option value="0">Selección</option>
                                                @foreach($sector as $val)
                                                <option value="{{$val->code}}">{{$val->description}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="address">Flete *</label>
                                            <input type="checkbox" id="shipping_cost" name="shipping_cost" class="form-control input-clients" checked disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="address">Precio Especial *</label>
                                            <input type="checkbox" id="special_price" name="special_price" class="form-control input-clients " disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">Información Envio</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="email">Ciudad Envio *</label>
                                            <select class="form-control input-clients input-sm" id="send_city_id" name="send_city_id" data-api="/api/getCity" required disabled>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label for="email">Dirección Envio *</label>
                                            <input class="form-control input-clients input-sm" id="address_send" name="address_send" required disabled>    
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">Información Facturación</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="email">Ciudad Facturación</label>
                                            <select class="form-control input-clients input-sm" id="invoice_city_id" name="invoice_city_id" data-api="/api/getCity" disabled>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label for="email">Dirección Facturación</label>
                                            <input class="form-control input-clients input-sm" id="address_invoice" name="address_invoice" disabled>    
                                        </div>
                                    </div>
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
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-3"><button type="button" class="btn btn-info btn-sm" id="btnComment">Comentar</button></div>
                    <div class="col-lg-9">
                        <textarea class="form-control" id="txtComment"></textarea>
                    </div>

                </div>
                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="list-group" id="listComments">
                        </ul>
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
                    <input class="input-justify" type="hidden" id="clients_id" name="clients_id">
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


@include('Clients.client.modalUpload')
