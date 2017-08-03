function CEO() {
    this.init = function () {

        $("#Detail #finit").datetimepicker({format: 'Y-m-d'});
        $("#Detail #fend").datetimepicker({format: 'Y-m-d'});

        $("#btnSearch").click(function () {
            $(this).attr("disabled", true);
            $("#loading-super").removeClass("hidden");
            obj.getOverView();
        });
        obj.getOverView();
    }

    this.getOverView = function () {
        var param = {}, html = '';
        param.init = $("#Detail #finit").val();
        param.end = $("#Detail #fend").val();

        $.ajax({
            url: "overview/getOverview",
            method: 'GET',
            data: param,
            dataType: 'json',
            beforeSend: function () {
                $("#loading-super").removeClass("hidden");
            },
            success: function (data) {
                $("#total_client").html(data.client);
                $("#total_invoice").html(data.invoices);
                $("#average").html(data.average);
                $("#category").html(data.category);
                $("#supplier").html(data.supplier);

//html += '<tr><td>' + val.dates + 'Total Ventas (' + val.total + ') Subtotal: (' + val.subtotal + ")"

                $.each(data.valuesdates, function (i, val) {
                    html += '<tr><td>' + val.dates + '</td><td>' + val.total + '</td><td>' + val.subtotal + "</td>"
                    html += "<td>" + val.tax19 + "</td>";
                    html += "<td>" + val.tax5 + "</td>";
                    html += "<td>" + val.shipping_cost + "</td>";
                    html += '<td>' + val.units + '</td></tr>';
                });

                
                $("#tblSales tbody").html(html);
                html = "<tr><td>Totales</td><td></td><td>" + data.totalvalues + "</td> Unidades " + data.totalquantity + "</td></tr>";
                $("#tblSales tfoot").html(html);
                

                $("#tblClient tbody").empty();
                html = '';
                $.each(data.listClient, function (i, val) {
                    html += '<tr><td>' + val.client + '</td><td>' + val.unidades + '</td><td>' + val.total + '</td></tr>';
                });

                html += "<tr><td colspan='3'><hr></td></tr><tr><td>Total</td><td>" + data.quantitycli + " -> " + data.quantitypercent.toFixed(2)
                        + "%</td><td>" + data.totalcli + " -> " + data.pertotal.toFixed(2) + " %</td></tr>";

                $("#tblClient tbody").html(html);

                html = '';
                $.each(data.listProducts, function (i, val) {
                    html += '<tr><td>' + val.product + '</td><td>' + val.quantity + '</td><td>' + val.total + '</td></tr>';
                });

                html += "<tr><td colspan='3'><hr></td></tr><tr><td>Total</td><td>" + data.quantitypro + " -> " + data.perquantitypro.toFixed(2)
                        + "%</td><td>" + data.totalpro + " -> " + data.pertotalpro.toFixed(2) + " %</td></tr>";
                $("#tblProduct tbody").html(html);

                html = '';
                $.each(data.listCategory, function (i, val) {
                    html += '<tr><td>' + val.category + '</td><td>' + val.quantity + '</td><td>' + val.total + '</td></tr>';
                });

                html += "<tr><td colspan='3'><hr></td></tr><tr><td>Total</td><td>" + data.quantitycat + " -> " + data.perquantitycat.toFixed(2)
                        + "%</td><td>" + data.totalcat + " -> " + data.pertotalcat.toFixed(2) + " %</td></tr>";
                $("#tblCategory tbody").html(html);

                html = '';
                $.each(data.listSupplier, function (i, val) {
                    html += '<tr><td>' + val.supplier + '</td><td>' + val.quantity + '</td><td>' + val.total + '</td></tr>';
                });

                html += "<tr><td colspan='3'><hr></td></tr><tr><td>Total</td><td>" + data.quantitysupplier + " -> " + data.perquantitysup.toFixed(2)
                        + "%</td><td>" + data.totalsupplier + " -> " + data.pertotalsup.toFixed(2) + " %</td></tr>";

                $("#tblSuppplier tbody").html(html);

                html = '';
                $.each(data.listCommercial, function (i, val) {
                    html += '<tr><td>' + val.vendedor + '</td><td>' + val.quantity + '</td><td>' + val.total + '</td></tr>';
                });

                html += "<tr><td colspan='3'><hr></td></tr><tr><td>Total</td><td>" + data.quantitycom + " -> " + data.perquantitycom.toFixed(2)
                        + "%</td><td>" + data.totalcom + " -> " + data.pertotalcom.toFixed(2) + " %</td></tr>";
                $("#tblCommercial tbody").html(html);


                $("#loading-super").addClass("hidden");
                $("#btnSearch").attr("disabled", false);
            }
        });


    }

    this.getClient = function (id) {
        $.ajax({
            url: "/profile/" + id + "/getClient",
            method: 'GET',
            success: function (data) {
                $("#client_until").html(data.client.created_at);
                $("#responsible").html(data.client.responsible);
                $("#name_client").html(data.client.business);
                $("#city_address").html(data.client.address_invoice + " / " + data.client.city_invoice);
                $("#lead_time").html(0);
                $("#last_sale").html(0);
                $("#frecuency").html(data.frecuency + " días");
                $("#sector").html(data.client.sector);
            }
        });
    }

    this.tableProduct = function () {
        var obj = {};
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();
        obj.client_id = $("#Detail #client_id").val();
        return $('#tblProduct').DataTable({
            destroy: true,
            order: [[2, "desc"]],
            ajax: {
                url: "api/reportProductByClient",
                data: obj,
            },
            columns: [
                {data: "product"},
                {data: "quantityproducts"},
                {data: "total", render: $.fn.dataTable.render.number('.', ',', 2)},
            ],

            aoColumnDefs: [
                {
                    aTargets: [0, 1],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="objCli.getDetail(' + full.id + ')">' + data + '</a>';
                    }
                }

            ]
        });
    }
}

var obj = new CEO();
obj.init();