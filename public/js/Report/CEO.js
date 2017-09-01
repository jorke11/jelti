function CEO() {
    this.init = function () {

        $("#Detail #finit").datetimepicker({format: 'Y-m-d'});
        $("#Detail #fend").datetimepicker({format: 'Y-m-d'});

        $("#btnSearch").click(function () {
            $(this).attr("disabled", true);
            $("#loading-super").removeClass("hidden");
            obj.getSalesUnits();
            obj.getOverView();

        });
        obj.getSalesUnits();
        obj.getOverView();
    }

    this.getSalesUnits = function () {
        var param = {}, html = '';
        param.init = $("#Detail #finit").val();
        param.end = $("#Detail #fend").val();

        return $('#tblSales').DataTable({
            destroy: true,
            scrollX: true,
            order: [[2, "desc"]],
            ajax: {
                url: "CEO/getSalesUnits",
                data: param,
            },
            columns: [
                {data: "dates"},
                {data: "invoices"},
                {data: "quantity"},
                {data: "shipping_cost", render: $.fn.dataTable.render.number('.', ',', 2)},
                {data: "tax5", render: $.fn.dataTable.render.number('.', ',', 2)},
                {data: "tax19", render: $.fn.dataTable.render.number('.', ',', 2)},
                {data: "subtotal", render: $.fn.dataTable.render.number('.', ',', 2)},
                {data: "total", render: $.fn.dataTable.render.number('.', ',', 2)},
            ],

            aoColumnDefs: [
                {
                    aTargets: [0, 1],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="objCli.getDetail(' + full.id + ')">' + data + '</a>';
                    }
                }

            ],
            footerCallback: function (row, data, start, end, display) {
                var api = this.api(), subtotal, total, quantity = 0, tax5 = 0, tax19 = 0, shipping = 0, invoices = 0;

                var intVal = function (i) {
                    return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                };

                invoices = api
                        .column(1)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                $(api.column(1).footer()).html(
                        '(' + invoices + ')'
                        );
                quantity = api
                        .column(2)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);


                $(api.column(2).footer()).html(
                        '(' + quantity + ')'
                        );

                shipping = api
                        .column(3)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);


                $(api.column(3).footer()).html(
                        '(' + obj.formatCurrency(shipping, "$") + ')'
                        );


                tax5 = api
                        .column(4)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                $(api.column(4).footer()).html(
                        '(' + obj.formatCurrency(tax5, "$") + ')'
                        );


                tax19 = api
                        .column(5)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                $(api.column(5).footer()).html(
                        '(' + obj.formatCurrency(tax19, "$") + ')'
                        );

                subtotal = api
                        .column(6)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                $(api.column(6).footer()).html(
                        '(' + obj.formatCurrency(subtotal, "$") + ')'
                        );

                total = api
                        .column(7)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);


                $(api.column(7).footer()).html(
                        '(' + obj.formatCurrency(total, "$") + ')'
                        );
            }
        });

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


                $("#tblClient tbody").empty();
                html = '';
                $.each(data.listClient, function (i, val) {
                    html += '<tr><td>' + val.client + '</td><td>' + val.unidades + '</td><td>' + obj.formatCurrency(parseFloat(val.subtotal),"$") + '</td></tr>';
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

    this.formatCurrency = function (n, currency) {
        return currency + " " + n.toFixed(2).replace(/./g, function (c, i, a) {
            return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
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