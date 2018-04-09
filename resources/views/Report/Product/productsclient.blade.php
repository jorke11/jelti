<div class="container-fluid">
    {!! Form::open(['id'=>'Detail']) !!}
    <div class="row">
        <div class="col-lg-12">
            <select class="form-control input-product" id="client_id" name='client_id' data-api="/api/getClient" required>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table" id="tblProductsClient">
                        <thead>
                            <tr>
                                <!--<td>Fecha</td>-->
                                <td>Cliente</td>
                                <td>Producto</td>
                                <td>Total Unidades</td>
                                <td>Total</td>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    {!!Form::close()!!}
</div>
