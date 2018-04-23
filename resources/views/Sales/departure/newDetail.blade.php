<div class="modal fade" role="dialog" id='modalDetail'>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agrega Item</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'frmDetail']) !!}
                <input type="hidden" id="id" name="id" class="input-detail">
                <input type="hidden" id="departure_id" name="departure_id">
                <input type="hidden" id="rowItem">


                <div class="row">
                    <div class="col-lg-6">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="email">Product:</label>
                                    <select class="form-control input-detail" id="product_id" name='product_id' data-product="/api/getProduct" required>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="email">Quantity <span id="quantityMax" style="color: red;"></span></label>
                                    <input type="text" class="form-control input-detail input-sm input-number" id="quantity" name='quantity' placeholder="Quantity" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-6">
                                <ul class="list-group">
                                    <li class="list-group-item active">Información</li>
                                    <li class="list-group-item" id="txtCategory">Sin seleccionar</li>
                                    <li class="list-group-item" id="txtValue">$0</li>
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <img src="" id="imgProduct" width="80%">
                            </div>
                        </div>
                    </div>

                    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5)
                    <div id="lotes">

                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-bordered table-condensed" id="tableLot">
                                    <thead>
                                        <tr>
                                            <th>Lote</th>
                                            <th>Disponible</th>
                                            <th>Vencimiento</th>
                                            <th>Cantidad necesaria</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                    {!!Form::close()!!}

                    <div id="hold_inventory">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-bordered table-condensed" id="tableHold">
                                    <thead>
                                        <tr style="background: #0ab8ec">
                                            <th colspan="4" style=" text-align: center;">Inventario Hold</th>
                                        </tr>
                                        <tr style="background: #0ab8ec">
                                            <th>Cliente</th>
                                            <th>Cantidad</th>
                                            <th>Fecha Creacion</th>
                                            <th>Bodega</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" >Cerrar</button>
                    <button type="button" class="btn btn-success" id='newDetail'>Guardar</button>
                </div>
            </div>
        </div>
    </div>