function detailProduct() {
    this.init = function () {
        $("#addComment").click(this.addComment);
        $("#AddProduct").click(this.addProduct);
        $("#contentComment").empty();
        this.getComment();
        this.getQuantity();
    }

    this.modalComment = function () {
        $("#modalComment").modal("show");
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
                $.each(data, function (i, val) {
                    html += '<a href="#" class="list-group-item"><span class="label label-success">' + val.name + '</span> ' + val.description + ' <div class="pull-right">' + val.created_at + '</div></a>'
                })

                $("#contentComment").html(html);
            }
        })
    }

    this.addComment = function () {
        var html = "";
        var obj = {};
        obj.product_id = $("#product_id").val();
        obj.description = $("#txtComment").val();
        $.ajax({
            url: PATH + '/addComment',
            method: 'POST',
            data: obj,
            dataType: 'JSON',
            success: function (data) {
                $.each(data, function (i, val) {
                    html += '<a href="#" class="list-group-item"><span class="label label-success">' + val.name + '</span> ' + val.description + ' <div class="pull-right">' + val.created_at + '</div></a>'
                })

                $("#contentComment").html(html);
            }
        })

    }
}

var obj = new detailProduct();
obj.init();
