function Payment() {
    this.init = function () {
        $("#addComment").click(this.addComment);
        this.getDetail();
    }

    this.getDetail = function () {
        var html = "", image = "";
        $.ajax({
            url: 'getDetail/',
            method: 'GET',
            dataType: 'JSON',
            success: function (data) {

                $.each(data.detail, function (i, val) {
                    image = (val.image == null) ? "default.jpg" : val.image;
                    console.log(image)
                    html += "<tr><td>" + (i + 1) + "</td>";
                    html += '<td><img src="/images/product/' + image + '" width="25px"></td>'
                    html += "<td>" + val.product + "</td><td>" + val.quantity + "</td><td>" + val.formateTotal + "</td>";
                    html += '<td><button type="button" class="close" aria-label="Close" onclick=obj.deleteItem(' + val.product_id + ',' + val.order_id + ')><span aria-hidden="true">&times;</span></button></td></tr>';
                })
                html += '</div>';

                $("#tblReview tbody").html(html);
                $("#tblReview tfoot").html('<tr><td colspan="4"><strong>Total</td><td>' + data.total + '</strong></td></tr>');
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
