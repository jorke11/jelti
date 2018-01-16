function Payment() {
    this.init = function () {
        $("#frm").submit(function () {
            $.ajax({
                url: PATH + '/generatekey',
                method: 'GET',
                dataType: 'JSON',
                success: function (data) {
                    $("#frm #signature").val(data.key);
                }
            });

        });

        $("#btnPayU").click(this.payu);

    }

    this.payu = function () {
        window.location.href = PATH + "/payment/" + $("#frm #order_id").val()

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
