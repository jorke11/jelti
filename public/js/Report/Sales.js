function Sales() {
    this.init = function () {

        $("#frmSale #finit").datetimepicker({format: 'Y-m-d'});
        $("#frmSale #fend").datetimepicker({format: 'Y-m-d'});

        objSale.getInfo($("#frmSale #finit").val(), $("#frmSale #fend").val());

        $("#frmSale #btnSearch").click(function () {
            objSale.getInfo($("#frmSale #finit").val(), $("#frmSale #fend").val());
        })
    }

    this.see = function () {
        window.open("departure/" + 0 + "/" + $("#frmSale #finit").val() + "/" + $("#frmSale #fend").val());
    }

    this.getInfo = function (init, end) {
        var link = "";
        $.ajax({
            url: '/report/sale/' + init + "/" + end,
            method: 'get',
            dataType: 'json',
            success: function (data) {
                link = '<span style="cursor:pointer" class="glyphicon glyphicon-search" aria-hidden="true" onclick=objSale.see()></span>';
                $("#frmSale #quantityTotal").html("Venta Total:<strong>" + data.total + "</strong>"
                        + "<br>Total con Iva:<strong>" + data.totalwithtax + "</strong><br>"
                        + "Nota incluido credito: <strong>" + data.totalwithtaxn + "</strong><br>" +
                        "Facturado: <strong>" + data.topay + "</strong>&nbsp;" + link + "<br><br><p>Quantiy: <strong>" +
                        data.quantity.quantity + "</strong> Units <br>Product: <strong>" + data.quantity.title + "</strong></p>");
            }
        })

    }
}

var objSale = new Sales();
objSale.init();