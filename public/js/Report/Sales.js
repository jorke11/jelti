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
                $("#frmSale #quantityTotal").html("Venta Total:<strong>" + data.total + "</strong>");
            }
        })

    }
}

var objSale = new Sales();
objSale.init();