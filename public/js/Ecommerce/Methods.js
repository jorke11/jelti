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

        $('.input-number').on('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        
        $('.input-date').on('input', function () {
            
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        
//        $("#btnPayment").click(this.payu);

    }

    this.payu = function () {
        var form = $("#frm").serialize();
        $.ajax({
            url: PATH + '/payment/target',
            data: form,
            method: "post",
            success: function () {

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
