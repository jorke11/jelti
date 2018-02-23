<div class="row">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
            <div class="page-title">
                <div class="row">
                    <div class="col-lg-12 text-right">
                        <button class="btn btn-success btn-sm" id='btnNew'>
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button class="btn btn-success btn-sm" id='btnSave'>
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                {!! Form::open(['id'=>'frm']) !!}
                <div class="row">
                    <input type="hidden" id="id" name="id" class="input-activity">                
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="address" class="control-label">Usuario *</label>
                            <select class="form-control input-activity"  id="commercial_id" name="commercial_id" data-api="/api/getCommercial" required>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="name" class="control-label">Asunto*</label>
                            <input type="text" class="form-control input-activity input-sm" id="subject" name="subject"required>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="last_name" class="control-label">Vincular *</label>
                            <select class="form-control input-activity input-sm"  id="vinculo_id" name="vinculo_id">
                                <option value="0">Selección</option>
                                <option value="1">Cuenta</option>
                                <option>Posible Cliente</option>
                                <option>Administrativo</option>
                                <option>Contacto</option>
                            </select>
                        </div>
                    </div>


                </div>

                <div class="row"> 
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="last_name" class="control-label">Buscar Vínculo</label>
                            <select class="form-control input-activity"  id="client_id" name="client_id" data-api="/api/getClient">
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="last_name" class="control-label">Estado *</label>
                            <select class="form-control input-activity input-sm"  id="status_id" name="status_id">
                                <option value="0">Selección</option>
                                <option value="0">No iniciado</option>
                                <option value="1">Aplazado</option>
                                <option value="2">En curso</option>
                                <option value="3">Completado</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="last_name" class="control-label">Prioridad*</label>
                            <select class="form-control input-activity input-sm"  id="priority_id" name="priority_id">
                                <option value="0">Selección</option>
                                <option value="1">Urgente e importante</option>
                                <option value="2">Urgente pero no importante</option>
                                <option value="3">Importante pero no urgente</option>
                                <option value="4">Ni importante ni urgente</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="last_name" class="control-label">Tipo Notificación</label>
                            <select class="form-control input-activity"  id="notification" name="notification" data-api="/api/getNotification" multiple="">
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="last_name" class="control-label">Fecha Vencimiento</label>
                            <input type="datetime" class="form-control  input-activity input-sm form_datetime" id="expiration_date" name="expiration_date" required value="<?php echo date("Y-m-d H:i") ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="last_name" class="control-label">Pre-Alertar</label>
                            <select class="form-control input-activity input-sm"  id="priority_id" name="priority_id">
                                <option value="0">Selección</option>
                                <option value="1">15 Minutos</option>
                                <option value="1">30 Minutos</option>
                                <option value="1">45 Minutos</option>
                                <option value="4">1 Hora</option>
                            </select>
                        </div>
                    </div>
                </div>
                 <div class="row">
                     <div class="col-lg-4">
                        <div class="form-group">
                            <label for="name" class="control-label">Descripción </label>
                            <textarea class="form-control input-activity input-sm" id="subject" name="subject"required rows="4"></textarea>
                        </div>
                    </div>
                    </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
</div>
