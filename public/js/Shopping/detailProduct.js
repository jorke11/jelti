function detailProduct() {
    this.init = function () {
        $("#addComment").click(this.addComment);
        $("#AddProduct").click(this.addProduct);
        $("#contentComment").empty();
        this.getComment();
    }

    this.addProduct = function () {
        var obj = {};
        obj.product_id = $("#product_id").val();
        obj.quantity = $("#quantity").val();
        $.ajax({
            url: '../addDetail',
            method: 'POST',
            data: obj,
            dataType: 'JSON',
            success: function (data) {
               $("#quantityOrders").html(data);
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
            url: '../addComment',
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
