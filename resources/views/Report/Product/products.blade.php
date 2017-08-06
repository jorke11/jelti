<div class="container-fluid">
    {!! Form::open(['id'=>'Detail']) !!}
    <div class="row">
        <div class="col-lg-12">

            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table" id="tblProducts">
                        <thead>
                            <tr>
                                <td>Ciudad</td>
                                <td>Producto</td>
                                <td>Total Unidades</td>
                                <td>Total Ventas</td>
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
