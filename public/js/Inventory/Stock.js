function Stock() {

    var tab = 0;

    this.init = function () {
        this.table()

        $("#tabLog").click(function () {
            obj.tableLog();
            tab = 1;
        })

        $("#tabList").click(function () {
            obj.tableLog();
            tab = 1;
        })

        $("#btnFind").click(function () {
            obj.table();
        })



    }

    this.tableLog = function () {
        var param = {};
        param.warehouse_id = $("#warehouse_id").val();
        param.bar_code = $("#bar_code").val();
        table = $('#tblLog').DataTable({
            "dom":
                    "R<'row'<'col-sm-4'l><'col-sm-2 toolbar text-right'><'col-sm-3'B><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12't>>" +
                    "<'row'<'col-xs-3 col-sm-3 col-md-3 col-lg-3'i><'col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center'p><'col-xs-3 col-sm-3 col-md-3 col-lg-3'>>",
//            processing: true,
//            serverSide: true,
            destroy: true,
            lengthMenu: [[30, 100, 300, -1], [30, 100, 300, 'All']],
            ajax: {
                url: "/api/listStockLog",
                data: param
            },
            buttons: [
                {
                    extend: 'excelHtml5',
                    className: 'btn btn-primary glyphicon glyphicon-download',
                    titleAttr: 'Excel'
                },
            ],
            columns: [
//                {
//                    className: 'details-control',
//                    orderable: false,
//                    data: null,
//                    defaultContent: '',
//                    searchable: false,
//                },
                {data: "id"},
                {data: "product"},
                {data: "quantity"},
                {data: "previous_quantity"},
                {data: "type_move"},
                {data: "lot"},
                {data: "cost_sf"},
                {data: "price_sf"},
                {data: "expiration_date"},
                {data: "warehouse"},
                {data: "order"},
                {data: "invoice"},
                {data: "created_at"},
            ],
            order: [[4, 'ASC']],
            aoColumnDefs: [
                {
                    aTargets: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    mRender: function (data, type, full) {

                        return '<a href="#" onclick="Stock.showModal(' + full.id + ')">' + data + '</a>';
                    }
                }
                ,
//                {
//                    targets: [1],
//                    searchable: false,
//                    mData: null,
//                    mRender: function (data, type, full) {
////                        return '<button class="btn btn-danger btn-xs" onclick="obj.delete(' + data.id + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
//                    }
//                }
            ],
            footerCallback: function (row, data, start, end, display) {
                var api = this.api(), data, subtotal, total, quantity = 0, note = 0;
                var intVal = function (i) {
                    return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                };
//                total = api
//                        .column(8)
//                        .data()
//                        .reduce(function (a, b) {
//                            return intVal(a) + intVal(b);
//                        }, 0);
//                quantity = api
//                        .column(7)
//                        .data()
//                        .reduce(function (a, b) {
//                            return intVal(a) + intVal(b);
//                        }, 0);
//
//                $(api.column(7).footer()).html(
//                        '(' + quantity + ')'
//                        );
//                $(api.column(8).footer()).html(
//                        '(' + obj.formatCurrency(total, "$") + ')'
//                        );
//
//
//                console.log(total)
            }
        });
//        $('#tbl tbody').on('click', 'td.details-control', function () {
//            var tr = $(this).closest('tr');
//            var row = table.row(tr);
//            if (row.child.isShown()) {
//                row.child.hide();
//                tr.removeClass('shown');
//            } else {
//
//                row.child(Stock.format(row.data())).show();
//                tr.addClass('shown');
//            }
//        });
        return table;
    }


    this.table = function () {
        var param = {};
        param.warehouse_id = $("#warehouse_id").val();
        param.bar_code = $("#bar_code").val();
        table = $('#tbl').DataTable({
            "dom":
                    "R<'row'<'col-sm-4'l><'col-sm-2 toolbar text-right'><'col-sm-3'B><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12't>>" +
                    "<'row'<'col-xs-3 col-sm-3 col-md-3 col-lg-3'i><'col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center'p><'col-xs-3 col-sm-3 col-md-3 col-lg-3'>>",
//            processing: true,
//            serverSide: true,
            destroy: true,
            lengthMenu: [[30, 100, 300, -1], [30, 100, 300, 'All']],
            ajax: {
                url: "/api/listStock",
                data: param
            },
            buttons: [
                {
                    extend: 'excelHtml5',
                    className: 'btn btn-primary glyphicon glyphicon-download',
                    titleAttr: 'Excel'
                },
            ],
            columns: [
                {
                    className: 'details-control',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                    searchable: false,
                },
                {data: "reference"},
                {data: "supplier"},
                {data: "category"},
                {data: "product"},
                {data: "in_warehouse"},
                {data: "request_client"},
                {data: "in_hold"},
                {data: "request_supplier"},
                {data: "in_hold"},
                {data: "cost_sf", render: $.fn.dataTable.render.number(',', '.', 0), "visible": true},
            ],
            order: [[6, 'ASC']],
            aoColumnDefs: [
                {
                    aTargets: [2],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="Stock.showModal(' + full.id + ')">' + data + '</a>';
                    }
                },
                {
                    targets: [10],
                    searchable: false,
                    mData: null,
                    mRender: function (data, type, full) {
                        return '<button class="btn btn-danger btn-xs" onclick="obj.delete(' + data.id + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                    }
                }
            ],
            footerCallback: function (row, data, start, end, display) {
                var api = this.api(), data, subtotal, total, quantity = 0, note = 0;
                var intVal = function (i) {
                    return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                };
//                total = api
//                        .column(8)
//                        .data()
//                        .reduce(function (a, b) {
//                            return intVal(a) + intVal(b);
//                        }, 0);
//                quantity = api
//                        .column(7)
//                        .data()
//                        .reduce(function (a, b) {
//                            return intVal(a) + intVal(b);
//                        }, 0);
//
//                $(api.column(7).footer()).html(
//                        '(' + quantity + ')'
//                        );
//                $(api.column(8).footer()).html(
//                        '(' + obj.formatCurrency(total, "$") + ')'
//                        );
//
//
//                console.log(total)
            }
        });
        $('#tbl tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {

                row.child(obj.format(row.data())).show();
                tr.addClass('shown');
            }
        });
        return table;
    }

    this.format = function (d) {
        var url = "/stock/" + d.id + "/detailInventory";

        var html = `<br>
                    <table class="table-detail">
                        <thead>
                            <tr>
                                <th colspan="8" align="center">Disponible en Bodega</th>
                            </tr>
                            <tr>
                                <th>Bodega</th>
                                <th>Lote</th>
                                <th>Vencimiento</th>
                                <th>Costo</th>
                                <th>Precio</th>
                                <th>Disponible</th>
                                <th>Total Costo</th>
                                <th>Total Precio</th>
                            </tr>
                        </thead>`;
        $.ajax({
            url: url,
            method: "GET",
            dataType: 'JSON',
            async: false,
            success: function (data) {
                html += "<tbody>";
                var total_cost = 0, total_price = 0, total_quantity = 0;
                $.each(data.inventory, function (i, val) {
                    html += `
                        <tr>
                            <td>${val.warehouse}</td>
                            <td>${val.lot}</td>
                            <td>${val.expiration_date}</td>
                            <td>${$.formatNumber(val.cost_sf)}</td>
                            <td>${$.formatNumber(val.price_sf)}</td>
                            <td>${val.quantity}</td>
                            <td>${$.formatNumber(val.total_cost)}</td>
                            <td>${$.formatNumber(val.total_price)}</td>
                        </tr>`;
                    total_cost += parseInt(val.total_cost);
                    total_price += parseInt(val.total_price);
                    total_quantity += val.quantity;
                });
                html += `
                            <tr>
                                <td colspan="5" align="right"><b>Totales</b></td><td>${total_quantity}</td><td>${$.formatNumber(total_cost)}</td><td>${$.formatNumber(total_price)}</td>
                            <tr>
                        </tbody>
                        </table>
                    <br>
                        `;
            }
        })
        return html;
    }
}


var obj = new Stock;
obj.init();