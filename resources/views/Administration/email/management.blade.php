<div class="row">
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
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address" class="control-label">Commecial</label>
                        <select class="form-control input-activity"  id="commercial_id" name="commercial_id" data-api="/api/getCommercial" required>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="last_name" class="control-label">Contact*</label>
                        <select class="form-control input-activity"  id="contact_id" name="contact_id" data-api="/api/getContact">
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="name" class="control-label">Attach*</label>
                        <input type="text" class="form-control input-activity" id="subject" name="subject" placeholder="subject" required>
                    </div>
                </div>


                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="last_name" class="control-label">Client*</label>
                        <select class="form-control input-activity"  id="client_id" name="client_id" data-api="/api/getClient">
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="last_name" class="control-label">Type Notification*</label>
                        <select class="form-control input-activity"  id="notification" name="notification" data-api="/api/getNotification" multiple="">
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="last_name" class="control-label">Priority*</label>
                        <select class="form-control input-activity"  id="priority_id" name="priority_id">
                            <option value="0">Alto</option>
                            <option value="1">Mas alto</option>
                            <option value="2">Bajo</option>
                            <option value="3">Mas Bajo</option>
                            <option value="4">Normal</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="last_name" class="control-label">Status*</label>
                        <select class="form-control input-activity"  id="status_id" name="status_id">
                            <option value="0">No iniciado</option>
                            <option value="1">Aplazado</option>
                            <option value="2">En curso</option>
                            <option value="3">Completado</option>
                            <option value="4">En espera de entrada</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="last_name" class="control-label">Expiration Date*</label>
                        <input type="datetime" class="form-control  input-activity" id="expiration_date" name="expiration_date" placeholder="expiration date" required value="<?php echo date("Y-m-d H:i") ?>">
                    </div>
                </div>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>
