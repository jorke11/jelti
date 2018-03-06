function detailProduct() {
    this.init = function () {
        $("#addComment").click(this.addComment);
        $("#AddProduct").click(this.addProduct);
        $("#btnOpenModal").click(this.modalComment);
        $("#contentComment").empty();
        this.getComment();
        this.getQuantity();
    }

    this.modalComment = function () {
        $("#txtTitle").val("");
        $("#txtComment").val("");
        $("#modalComment").modal("show");
    }
    
     this.redirectProduct = function (url) {
        window.location = PATH + "/productDetail/" + url;
    }

    this.addProduct = function () {
        toastr.remove()
        var obj = {};
        obj.product_id = $("#product_id").val();
        obj.quantity = $("#quantity").val();

        $.ajax({
            url: PATH + '/addDetail',
            method: 'POST',
            data: obj,
            dataType: 'JSON',
            beforeSend: function () {
                $("#loading-super").removeClass("hidden");
            },
            success: function (data) {
                $("#quantityOrders").html(data);
                toastr.success("Item add")
                $("#loading-super").addClass("hidden");
            }, error: function (xhr, ajaxOptions, thrownError) {

            }
        })
    }

    this.getQuantity = function () {
        var html = "";
        $.ajax({
            url: PATH + '/getCounter',
            method: 'GET',
            dataType: 'JSON',
            success: function (data) {
                $("#quantityOrders").html(data.quantity);
            }
        })
    }

    this.getComment = function () {
        var html = "";
        $.ajax({
            url: '../getComment/' + $("#product_id").val(),
            method: 'GET',
            dataType: 'JSON',
            success: function (data) {
                obj.loadTable(data);
            }
        })
    }

    this.loadTable = function (data) {
        var html = '';
        $.each(data, function (i, val) {
            html += `
                        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <h4>${val.title}</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <p class="text-muted">${val.name} ${val.last_name}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <p class="text-muted">${val.created_at}</p>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-lg-12">
                                <p class="text-justify">
                                   ${val.content}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true" style='cursor: pointer;font-size: 25px;'></span>&nbsp;<span class="badge">42</span>&nbsp;&nbsp;
                                <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true" style='cursor: pointer;font-size: 25px'></span>&nbsp;<span class="badge">0</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                <span class="glyphicon glyphicon-comment" aria-hidden="true" style='cursor: pointer;font-size: 25px' onclick="obj.modalComment({{$product->id}})"></span>&nbsp;<span class="badge" >0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`
                    ;
        })

        $("#contentComment").html(html);
    }

    this.addComment = function () {
        var html = "";
        var param = {};
        param.product_id = $("#product_id").val();
        param.content = $("#txtComment").val();
        param.title = $("#txtTitle").val();
        $.ajax({
            url: PATH + '/addComment',
            method: 'POST',
            data: param,
            dataType: 'JSON',
            success: function (data) {
                obj.loadTable(data)
                $("#modalComment").modal("hide");
            }
        })

    }
}

var obj = new detailProduct();
obj.init();
