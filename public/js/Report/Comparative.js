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
                } else if (obj.type_report == 7) {
                    title = "Sector";
                }

                objCli.setData(data, title);

                $("#loading-super").addClass("hidden");
                $("#btnSearch").attr("disabled", false);
            }
        });
    }

    this.setBriefacase = function (data) {
        var html = "<tr><th rowspan='2'>Cliente</th>";
        html += '<th colspan="2" align="center">Total</th>';
        var subheader = '<tr>';
        subheader += "<th align='center'>Unidades</th><th align='center'>Subtotal</th>";
        header = data.header;
        $.each(data.header, function (i, val) {
            html += '<th colspan="2" align="center">' + val.dates + "</th>";
            subheader += "<th align='center'>Total</td><td align='center'>Total Pagado</th>";
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
        var html = "<tr><th rowspan='2' width=200px>" + title + "</th>";
        html += '<th colspan="2" align="center">Total</th>';
        var subheader = '<tr>';
        subheader += "<th align='center'>Unidades</th><th align='center'>Subtotal</th>";
        header = data.header;
        $.each(data.header, function (i, val) {
            html += '<th colspan="2" align="center">' + val.dates + "</th>";
            subheader += "<th align='center'>Unidades</th><th align='center' width=200px>Subtotal</th>";
        });

        html += "</tr>";

        subheader += "</tr>";

        html += subheader;

        $("#tblClient thead").html(html);

        html = '';
        var cont = 0;
        console.log(data.header)
        $.each(data.data, function (i, val) {

            html += "<tr><td>" + val.description + "</td>";
            html += '<td align="center">' + val.quantity_packaging + "</td><td>" + val.total + "</td>";
            console.log(val.detail);
            for (var j = 0; j < val.detail.length; j++) {
         
                if (val.detail[j] != undefined && data.header[cont]!=undefined) {
                    if (data.header[cont].dates == val.detail[j].dates) {
                        html += "<td align='center'>" + val.detail[j].quantity_packaging + "</td><td align='center'>" + val.detail[j].total + "</td>";
                    } else {
                        html += "<td align='center'>0</td><td align='center'>0</td>";
                        j--;
                    }
                    cont++;
                }
            }
            cont = 0;


            html += "</tr>";
        });
        $("#tblClient tbody").html(html);
//        $("#tblClient").DataTable();
    }
}

var objCli = new Client();
objCli.init();