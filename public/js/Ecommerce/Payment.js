function Payment() {
    this.init = function () {
        $("#btnPay").click(this.pay);
        this.getDetail();
        this.getQuantity();
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


    this.getDetail = function () {
        var html = "", image = "";
        $.ajax({
            url: 'getDetail/',
            method: 'GET',
            dataType: 'JSON',
            beforeSend: function () {
                $("#loading-super").removeClass("hidden");
            },
            success: function (data) {

                $.each(data.detail, function (i, val) {
                    image = (val.image == null) ? "default.jpg" : val.image;
                    html += "<tr><td>" + (i + 1) + "</td>";
                    html += '<td><img src="/images/product/' + image + '" width="25px"></td>'
                    html += "<td>" + val.product + "</td><td><input type='number' value='" + val.quantity + "' class='form-control input-sm' onblur='obj.updateQuantity(" + val.order_id + "," + val.product_id + ",this)'></td><td>" + val.formateTotal + "</td>";
                    html += '<td><button type="button" class="close" aria-label="Close" onclick=obj.deleteItem(' + val.product_id + ',' + val.order_id + ')><span aria-hidden="true">&times;</span></button></td></tr>';
                })
                html += '</div>';

                $("#tblReview tbody").html(html);
                $("#tblReview tfoot").html('<tr><td colspan="4"><strong>Total</td><td>' + data.total + '</strong></td></tr>');
                $("#loading-super").addClass("hidden");
            }
        })
    }

    this.updateQuantity = function (order_id, product_id, obj) {
        toastr.remove();
        var param = {};
        param.product_id = product_id;
        param.quantity = obj.value;

        $.ajax({
            url: 'getDetailQuantity/' + order_id,
            method: 'PUT',
            data: param,
            dataType: 'JSON',
            success: function (data) {
                if (data.success == true) {
                    toastr.success("Cantidad editada");
                }
            }
        })
    }

    this.deleteItem = function (product_id, order_id) {
        var obj = {};
        obj.product_id = product_id;
        $.ajax({
            url: 'deleteDetail/' + order_id,
            method: 'DELETE',
            data: obj,
            dataType: 'JSON',
            success: function (data) {
                obj.getDetail();
            }
        })
    }
}

var obj = new Payment();
obj.init();
