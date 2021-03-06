<div class="row">
    <input type="hidden" class="input-contact" id="id" name="id" value="{{(isset($row->id))?$row->id:''}}">
    <div class="col-lg-12">
        <div class="form-group">
            <label for="name" class="control-label">Titulo*</label>
            <input type="text" class="form-control input-contact" id="title" name="title" placeholder="Titulo" value="{{(isset($row->title))?$row->title:''}}"required>
        </div>
    </div>
</div>
<div class="row">    
    <div class="col-lg-12">
        <div class="form-group">
            <label for="last_name" class="control-label">Contenido*</label>
            <textarea class="form-control" cols="10" rows="10" id="content" name="content">{{(isset($row->content))?$row->content:''}}</textarea>
        </div>
    </div>
</div>
<div class="row">    
    <div class="col-lg-6">
        <div class="form-group">
            <label for="last_name" class="control-label">Categoria*</label>
            <select id="category_id" name="category_id" class="form-control">
                <option value="0">Seleccione</option>
                @foreach($category as $val)
                <option value="{{$val->id}}">{{$val->description}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label for="last_name" class="control-label">Productos Relacionados</label>
            <select class="form-control input-detail" id="products_id" name='products_id[]' data-api="/api/getProduct" multiple="">
            </select>
        </div>
    </div>
</div>
<div class="row">    
    <div class="col-lg-12">
        <div class="form-group">
            <label for="last_name" class="control-label">Tags</label>
            <input type="text" class="form-control input-blog" id="tags" name="tags" placeholder="Tags"  value="{{(isset($row->tags))?$row->tags:''}}">
        </div>
    </div>
</div>
<div class="row">    
    <div class="col-lg-12">
        <div class="form-group">
            <label for="last_name" class="control                -label">Imagen*</label>
            <input type="file" class="form-control input-blog" id="img" name="img">
        </div>
    </div>
</div>