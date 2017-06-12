
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-3">Peticion</div>
                        <div class="col-lg-9 text-right">
                            <button class="btn btn-success btn-sm" type="button" id="btnNew">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"> New</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">Tipo de Documento</label>
                                <select class="form-control input-sm" id="document_id">
                                    <option value="0">Seleccione</option>
                                    @foreach($type_document as $val)
                                    <option value="{{$val->code}}">{{$val->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">Documento</label>
                                <input type="text" class="form-control input-courses input-sm" id="document" name='document' required="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">Nombre</label>
                                <input type="text" class="form-control input-courses input-sm" id="description" name='description' required="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">Apellido</label>
                                <input type="text" class="form-control input-courses input-sm" id="description" name='description' required="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">Departamento</label>
                                <select class="form-control input-sm" id="department_id">
                                    <option value="0">Seleccione</option>
                                    @foreach($department as $val)
                                    <option value="{{$val->code}}">{{$val->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">Ciudad</label>
                                <select class="form-control input-sm" id="city_id" name="city_id">
                                    <option value="0">Seleccione</option>
                                    @foreach($cities as $val)
                                    <option value="{{$val->code}}">{{$val->description}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">Direccion</label>
                                <input type="text" class="form-control input-courses input-sm" id="address" name='address' required="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">Barrio</label>
                                <input type="text" class="form-control input-courses input-sm" id="barrio" name='barrio' required="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">Telefono</label>
                                <input type="text" class="form-control input-courses input-sm" id="phone" name='phone' required="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">Celular</label>
                                <input type="text" class="form-control input-courses input-sm" id="mobile" name='mobile' required="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row">
                <?php
                foreach ($esquemas as $i => $val) {
                    ?>
                    <div class="col-lg-6">
                        <div class="thumbnail">
                            <img src="..." alt="...">
                            <div class="caption">
                                <h3>{{$val->description}}</h3>
                                <p>Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum </p>
                                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($i > 0) {
                        if ($i % 2 == 0) {
//                            echo $i;
//                            Exit;
                            ?>
                        </div><div class="row">
                            <?php
                        } else {
                            ?>
                        </div>
                        <?php
                    }
                }
                ?>
                <?php
            }
            ?>

        </div>
    </div>
</div>