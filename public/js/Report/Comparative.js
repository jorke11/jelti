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
            success: function (data) {
                if (obj.type_report == 1) {
                    objCli.dataClient(data);
                } else if (obj.type_report == 2) {
                    objCli.dataProduct(data);
                } else if (obj.type_report == 3) {
                    objCli.dataCategory(data);
                }
            }
        });
    }

    this.dataClient = function (data) {
        var html = "<tr><td>Cliente</td>";
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

            html += "<tr><td>" + val.client + "</td>";
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

    this.dataProduct = function (data) {
        var html = "<tr><td>Productos</td>";
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

            html += "<tr><td>" + val.product + "</td>";
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

    this.dataCategory = function (data) {
        var html = "<tr><td>Categorias</td>";
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

            html += "<tr><td>" + val.category + "</td>";
            html += '<td align="center">' + val.quantity_packaging + "</td><td>" + val.total + "</td>";
            for (var j = 0; j < ((val.detail).length) > 0; j++) {
                if (data.header[cont] != undefined) {
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
    }
}

var objCli = new Client();
objCli.init();