function Client() {
    var header = "";
    this.init = function () {

        $("#Detail #finit").datetimepicker({format: 'Y-m-d'});
        $("#Detail #fend").datetimepicker({format: 'Y-m-d'});

        $(".input-client").cleanFields();

        $("#btnSearch").click(function () {
            objCli.table();
        });
    }

    this.table = function (obj) {
        $("#btnSearch").attr("disabled", true);
        var obj = {};
        obj.type_report = $("#Detail #type_report").val();
        obj.warehouse_id = $("#Detail #warehouse_id").val();
        obj.client_id = $("#Detail #client_id").val();
        obj.city_id = $("#Detail #city_id").val();
        obj.product_id = $("#Detail #product_id").val();
        obj.commercial_id = $("#Detail #commercial_id").val();
        obj.supplier_id = $("#Detail #supplier_id").val();
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();
        $.ajax({
            url: "comparatives/salesClient",
            method: 'GET',
            data: obj,
            beforeSend: function () {
                $("#loading-super").removeClass("hidden");

            },
            success: function (data) {
                var title = "";
                if (obj.type_report == 1) {
                    title = "Clientes";
                } else if (obj.type_report == 2) {
                    title = "Productos";
                } else if (obj.type_report == 3) {
                    title = "Categoria";
                } else if (obj.type_report == 4) {
                    title = "Proveedor";
                } else if (obj.type_report == 5) {
                    title = "Comercial";
                } else if (obj.type_report == 6) {
                    objCli.setBriefacase(data);
                    $("#loading-super").addClass("hidden");
                    $("#btnSearch").attr("disabled", false);
                    return;
                }else if (obj.type_report == 7) {
                    title = "Sector";
                } 

                objCli.setData(data, title);

                $("#loading-super").addClass("hidden");
                $("#btnSearch").attr("disabled", false);
            }
        });
    }

    this.setBriefacase = function (data) {
        var html = "<tr><td>Cliente</td>";
        html += '<td colspan="2" align="center">Total</td>';
        var subheader = '<tr><td></td>';
        subheader += "<td align='center'>Unidades</td><td align='center'>Subtotal</td>";
        header = data.header;
        $.each(data.header, function (i, val) {
            html += '<td colspan="2" align="center">' + val.dates + "</td>";
            subheader += "<td align='center'>Total</td><td align='center'>Total Pagado</td>";
        });

        html += "</tr>";

        subheader += "</tr>";

        html += subheader;

        $("#tblClient thead").html(html);

        html = '';
        var cont = 0;

        $.each(data.data, function (i, val) {

            html += "<tr><td>" + val.description + "</td>";
            html += '<td align="center">' + val.total + "</td><td>" + val.totalpayed + "</td>";
            for (var j = 0; j < val.detail.length; j++) {
                if (data.header[cont].dates == val.detail[j].dates) {
                    html += "<td align='center'>" + val.detail[j].total + "</td><td align='center'>" + val.detail[j].totalpayed + "</td>";
                } else {
                    html += "<td align='center'>0</td><td align='center'>0</td>";
                    j--;
                }
                cont++;
            }
            cont = 0;


            html += "</tr>";
        });
        $("#tblClient tbody").html(html);
    }

    this.setData = function (data, title) {
        var html = "<tr><td>" + title + "</td>";
        html += '<td colspan="2" align="center">Total</td>';
        var subheader = '<tr><td></td>';
        subheader += "<td align='center'>Unidades</td><td align='center'>Subtotal</td>";
        header = data.header;
        $.each(data.header, function (i, val) {
            html += '<td colspan="2" align="center">' + val.dates + "</td>";
            subheader += "<td align='center'>Unidades</td><td align='center'>Subtotal</td>";
        });

        html += "</tr>";

        subheader += "</tr>";

        html += subheader;

        $("#tblClient thead").html(html);

        html = '';
        var cont = 0;

        $.each(data.data, function (i, val) {

            html += "<tr><td>" + val.description + "</td>";
            html += '<td align="center">' + val.quantity_packaging + "</td><td>" + val.total + "</td>";
            for (var j = 0; j < val.detail.length; j++) {
                if (data.header[cont].dates == val.detail[j].dates) {
                    html += "<td align='center'>" + val.detail[j].quantity_packaging + "</td><td align='center'>" + val.detail[j].total + "</td>";
                } else {
                    html += "<td align='center'>0</td><td align='center'>0</td>";
                    j--;
                }
                cont++;
            }
            cont = 0;


            html += "</tr>";
        });
        $("#tblClient tbody").html(html);
    }
}

var objCli = new Client();
objCli.init();