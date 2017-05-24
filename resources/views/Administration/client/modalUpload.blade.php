<div class="modal fade" tabindex="-1" role="dialog" id="modalUpload">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Upload Image</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'frmFile','files' => true]) !!}
                <input type="hidden" id="stakeholder_id" name="stakeholder_id">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Type Document:</label>
                            <select class="form-control" id="document_id" name="document_id">
                                <option value="0">Selection</option>
                                @foreach($type_document as $val)
                                <option value="{{$val->code}}">{{$val->description}}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <input id="document_file" name="document_file" type="file">
                    </div>
                </div>
                {!!Form::close()!!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="btnUpload">Upload</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->