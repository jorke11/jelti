<div class="modal fade" tabindex="-1" role="dialog" id='modalEdit'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Products</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'frmEdit','url'=>'category.edit']) !!}
                <input type="hidden" id="city_id" name="city_id">
                {!! Form::text('description',null,['id'=>'description','class'=>'form-control','placeholder'=>'Detail'])!!}<br>
                {!!Form::close()!!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id='edit'>Save</button>
            </div>
        </div>
    </div>
</div>