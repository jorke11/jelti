<div class="row">
    <div class="col-lg-8">
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
                                        <li><a href="#" onclick="obj.showModalJustif()">Activar / Desactivar</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6">
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
                                            <input type="text" class="form-control input-prospect input-sm" id="business" name="business" required disabled="">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="address" class="control-label">Nombre*</label>
                                            <input type="text" class="form-control input-prospect input-sm" id="name" name="name" required="" disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="address" class="control-label">Apellido*</label>
                                            <input type="text" class="form-control input-prospect input-sm" id="last_name" name="last_name" required="" disabled>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="id" name="id" class="input-prospect">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="address">Teléfono</label>
                                            <input type="text" class="form-control input-prospect input-sm" id="phone" name="phone" disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="address">Correo</label>
                                            <input type="text" class="form-control input-prospect input-sm" id="email" name="email" disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="address" class="control-label">Responsable</label>
                                            <select class="form-control input-prospect"  id="responsible_id" name="responsible_id" data-api="/api/getResponsable" disabled>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="address" class="control-label">Fuente Posible Cliente *</label>
                                            <select id="sector_id" name="sector_id" class="form-control input-prospect input-sm" disabled>
                                                <option value="0">Selección</option>
                                                @foreach($sector as $val)
                                                <option value="{{$val->code}}">{{$val->description}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!!Form::close()!!}
            </div>

        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-2"><button class="btn btn-info btn-sm">Comentar</button></div>
                    <div class="col-lg-10">
                        <textarea class="form-control"></textarea>
                    </div>

                </div>
                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <span class="badge">Fiorella</span>
                                [<?php echo date("Y-m-d") ?>] Cras justo odio
                            </li>
                            <li class="list-group-item">
                                <span class="badge badge-success">Sebastian</span>
                                [<?php echo date("Y-m-d") ?>] Other comment
                            </li>
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

