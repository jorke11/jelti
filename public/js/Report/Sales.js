function Sales() {
    this.init = function () {
        objSale.getInfo($("#frmSale #finit").val(), $("#frmSale #fend").val());

        $("#frmSale #btnSearch").click(function () {
            objSale.getInfo($("#frmSale #finit").val(), $("#frmSale #fend").val());
        })
    }

    this.getInfo = function (init, end) {
        $.ajax({
            url: '/report/sale/' + init + "/" + end,
            method: 'get',
            dataType: 'json',
            success: function (data) {
                $("#frmSale #quantityTotal").html("Venta Total:<strong>" + data.total + "</strong><br><br><p>Quantiy: <strong>" +
                        data.quantity.quantity + "</strong> Units <br>Product: <strong>" + data.quantity.title + "</strong></p>");
            }
        })

    }
}

var objSale = new Sales();
objSale.init();