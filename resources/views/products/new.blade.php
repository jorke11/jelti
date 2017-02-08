<div class="modal fade" tabindex="-1" role="dialog" id='modalNew'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">New Product</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'frm','route'=>'products.store']) !!}
                <input type="hidden" id="id" name="id">
                {!!form::text('name',null,['id'=>'name','class'=>'form-control','placeholder'=>'Name'])!!}<br>
                {!!form::text('last_name',null,['id'=>'last_name','class'=>'form-control','placeholder'=>'Last Name'])!!}<br>
                {!!form::text('address',null,['id'=>'address','class'=>'form-control','placeholder'=>'Address'])!!}<br>
                {!!form::text('document',null,['id'=>'document','class'=>'form-control','placeholder'=>'Document'])!!}<br>
                {!!form::text('phone',null,['id'=>'phone','class'=>'form-control','placeholder'=>'phone'])!!}<br>
                {!!form::text('contact',null,['id'=>'contact','class'=>'form-control','placeholder'=>'Name Contact'])!!}<br>
                {!!form::text('phone_contact',null,['id'=>'phone_contact','class'=>'form-control','placeholder'=>'Phone Contact'])!!}<br>
                <select class="form-control"  id="type_regimen_id" name="type_regimen_id">

                </select><br>

                <select id="type_person_id" name="type_person_id" class="form-control">
                </select><br>
                {!!Form::close()!!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id='new'>Save</button>
            </div>
        </div>
    </div>
</div>