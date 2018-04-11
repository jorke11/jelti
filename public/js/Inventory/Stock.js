function Stock() {
    var table;
    this.init = function () {
        table = this.table();

        $("#btnFind").click(function () {
            obj.table();
        })


        $("#tabTransit").click(function () {
            obj.tableTransit();
        })

    }

    this.delete = function (id) {
        toastr.remove();
        if (confirm("Deseas eliminar")) {
            var token = $("input[name=_token]").val();
            var url = "/stock/" + id;
            $.ajax({
                url: url,
                headers: {'X-CSRF-TOKEN': token},
                method: "DELETE",
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == true) {
                        table.ajax.reload();
                        toastr.warning("Ok");
                    }
                }, error: function (err) {
                    toastr.error("No se puede borrra Este registro");
                }
            })
        }
    }

    this.tableTransit = function () {
        var param = {};
        param.warehouse_id = $("#warehouse_id").val();
        param.bar_code = $("#bar_code").val();
        return $('#tblHold').DataTable({
            "dom":
                    "R<'row'<'col-sm-4'l><'col-sm-2 toolbar text-right'><'col-sm-3'B><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12't>>" +
                    "<'row'<'col-xs-3 col-sm-3 col-md-3 col-lg-3'i><'col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center'p><'col-xs-3 col-sm-3 col-md-3 col-lg-3'>>",
//            processing: true,
//            serverSide: true,
            destroy: true,
            lengthMenu: [[30, 100, 300, -1], [30, 100, 300, 'All']],
            ajax: {
                url: "/api/listStockTransit",
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
                {data: "id"},
                {data: "reference"},
                {data: "stakeholder"},
                {data: "category"},
                {data: "product"},
                {data: "lot"},
                {data: "expiration_date"},
                {data: "quantity"},
                {data: "price_sf", render: $.fn.dataTable.render.number(',', '.', 0), "visible": true},
            ],
            order: [[5, 'ASC']],
            aoColumnDefs: [
                {
                    aTargets: [2],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.showModal(' + full.id + ')">' + data + '</a>';
                    }
                },
                {
                    targets: [9],
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


                total = api
                        .column(8)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                quantity = api
                        .column(7)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                $(api.column(7).footer()).html(
                        '(' + quantity + ')'
                        );
                $(api.column(8).footer()).html(
                        '(' + obj.formatCurrency(total, "$") + ')'
                        );

            }
        });
    }
    
    this.table = function () {
        var param = {};
        param.warehouse_id = $("#warehouse_id").val();
        param.bar_code = $("#bar_code").val();
        return $('#tbl').DataTable({
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
                {data: "id"},
                {data: "reference"},
                {data: "stakeholder"},
                {data: "category"},
                {data: "product"},
                {data: "lot"},
                {data: "expiration_date"},
                {data: "quantity"},
                {data: "price_sf", render: $.fn.dataTable.render.number(',', '.', 0), "visible": true},
            ],
            order: [[5, 'ASC']],
            aoColumnDefs: [
                {
                    aTargets: [2],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.showModal(' + full.id + ')">' + data + '</a>';
                    }
                },
                {
                    targets: [9],
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


                total = api
                        .column(8)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                quantity = api
                        .column(7)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                $(api.column(7).footer()).html(
                        '(' + quantity + ')'
                        );
                $(api.column(8).footer()).html(
                        '(' + obj.formatCurrency(total, "$") + ')'
                        );


                console.log(total)
            }
        });
    }

    this.formatCurrency = function (n, currency) {
        return currency + " " + n.toFixed(2).replace(/./g, function (c, i, a) {
            return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
        });
    }

}

var obj = new Stock();
obj.init();