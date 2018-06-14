function Operations() {
    this.init = function () {
        this.table();
        this.tableProductWeek();
        this.tableProductDay();
        this.tableClientAverage();
        this.tableShipping_cost();
        this.tableTotal_cost();
        this.tableMaxMin();

        this.tableNivel();
        this.tableNoShipped();

        var init = $("#Detail #finit").val();
        var end = $("#Detail #fend").val();

        $(".input-operations").cleanFields();

        $("#Detail #finit").datetimepicker({format: 'Y-m-d'});
        $("#Detail #fend").datetimepicker({format: 'Y-m-d'});

        $("#Detail #finit").val(init);
        $("#Detail #fend").val(end);

        $("#btnSearch").click(function () {
            objCli.table();
            objCli.tableProductWeek();
            objCli.tableProductDay();
            objCli.tableClientAverage();
            objCli.tableShipping_cost();
            objCli.tableNivel();
            objCli.tableNoShipped();
        })
    }

    this.getDetail = function (client_id) {
        window.open("departure/" + client_id + "/" + $("#Detail #finit").val() + "/" + $("#Detail #fend").val());
    }

    this.tableMaxMin = function () {
        var param = {};
        param.init = $("#Detail #finit").val();
        param.end = $("#Detail #fend").val();
        param.warehouse_id = $("#Detail #warehouse_id").val();
        param.client_id = $("#Detail #client_id").val();


        $.ajax({
            url: "operations/getMaxMin/",
            method: 'GET',
            data: param,
            beforeSend: function () {
                $("#loading-super").removeClass("hidden");
            },
            dataType: 'json',
            success: function (data) {
                var html = '<tr><td>SF</td><td>Proveedor</td><td>Producto</td>';
                $.each(data.date, function (i, val) {
                    html += '<td>' + val + '</td>';
                })

                html += '<td>Cantidad</td>';
                html += '<td>Total</td>';

                html += '<tr>';
                $("#tblmaxmin thead").html(html);

                html = '';
                var cont = 0, del = [];

                $.each(data.data, function (i, val) {
                    cont = 0;

                    html += "<tr id='row_" + i + "'><td>" + val.reference + "</td>";


                    html += "<td>" + val.supplier + "</td>";
                    html += "<td>" + val.title + "</td>";

                    $.each(val.date, function (j, val) {
                        let det = Object.entries(val)[0]
                        html += "<td>" + det[1] + "</td>";
//                        cont += parseInt(value.quantity);
//
                    })

                    if (cont == 0) {
                        del.push(i);
                    }

                    console.log(val.quantity);
                    html += "<td>" + val.quantity + "</td>";
                    html += "<td>" + val.totalF + "</td>";
                    html += "</tr>";

                })



                $("#tblmaxmin tbody").html(html);
//                $.each(del, function (i, val) {
//                    $("#row_" + val).remove();
//                });

            },
            complete: function () {
                $("#loading-super").addClass("hidden");
            }
        });
    }

    this.tableNoShipped = function () {
        var obj = {};
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();
        obj.warehouse_id = $("#Detail #warehouse_id").val();
        obj.client_id = $("#Detail #client_id").val();

        return $('#tblNo_shipped').DataTable({
            "dom":
                    "R<'row'<'col-sm-4'l><'col-sm-2 toolbar text-right'><'col-sm-3'B><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12't>>" +
                    "<'row'<'col-xs-3 col-sm-3 col-md-3 col-lg-3'i><'col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center'p><'col-xs-3 col-sm-3 col-md-3 col-lg-3'>>",
            buttons: [
                {
                    extend: 'excelHtml5',
//                    text: '<i class="fa fa-file-excel-o"></i>',
                    className: 'btn btn-primary glyphicon glyphicon-download',
                    titleAttr: 'Excel'
                },
            ],
            destroy: true,
            ajax: {
                url: "/operations/getNoShipped",
                data: obj,
            },
            scrollX: true,
            columns: [
                {data: "product"},
                {data: "warehouse"},
                {data: "no_shipped_units"},
                {data: "value_dispatched", render: $.fn.dataTable.render.number('.', ',', 0)},
            ],
            aoColumnDefs: [
                {
                    aTargets: [0, 1],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="objCli.getDetail(' + full.id + ')">' + data + '</a>';
                    }
                }

            ],
        });
    }

    this.tableNivel = function () {
        var obj = {};
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();
        obj.warehouse_id = $("#Detail #warehouse_id").val();
        obj.client_id = $("#Detail #client_id").val();

        return $('#tblService').DataTable({
            "dom":
                    "R<'row'<'col-sm-4'l><'col-sm-2 toolbar text-right'><'col-sm-3'B><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12't>>" +
                    "<'row'<'col-xs-3 col-sm-3 col-md-3 col-lg-3'i><'col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center'p><'col-xs-3 col-sm-3 col-md-3 col-lg-3'>>",
            buttons: [
                {
                    extend: 'excelHtml5',
//                    text: '<i class="fa fa-file-excel-o"></i>',
                    className: 'btn btn-primary glyphicon glyphicon-download',
                    titleAttr: 'Excel'
                },
            ],
            destroy: true,
            ajax: {
                url: "/operations/getNivelService",
                data: obj,
            },

            scrollX: true,
            columns: [
                {data: "warehouse"},
                {data: "invoices"},
                {data: "orders_units"},
                {data: "dispatched_units"},
                {data: "not_shipped_units"},
                {data: "nivel"},
                {data: "orders_value"},
                {data: "dispatched_value"},
                {data: "not_shipped_value"},
                {data: "nivel_value"},
            ],
            aoColumnDefs: [
                {
                    aTargets: [0, 1],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="objCli.getDetail(' + full.id + ')">' + data + '</a>';
                    }
                }

            ],
        });
    }

    this.tableShipping_cost = function () {
        var obj = {};
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();
        obj.warehouse_id = $("#Detail #warehouse_id").val();
        obj.client_id = $("#Detail #client_id").val();

        return $('#tblShipping_cost').DataTable({
            "dom":
                    "R<'row'<'col-sm-4'l><'col-sm-2 toolbar text-right'><'col-sm-3'B><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12't>>" +
                    "<'row'<'col-xs-3 col-sm-3 col-md-3 col-lg-3'i><'col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center'p><'col-xs-3 col-sm-3 col-md-3 col-lg-3'>>",
            buttons: [
                {
                    extend: 'excelHtml5',
//                    text: '<i class="fa fa-file-excel-o"></i>',
                    className: 'btn btn-primary glyphicon glyphicon-download',
                    titleAttr: 'Excel'
                },
            ],
            destroy: true,
            ajax: {
                url: "/operations/getShippingCostClient",
                data: obj,
            },
            scrollX: true,
            columns: [
                {data: "client"},
                {data: "pedidos"},
                {data: "valor", render: $.fn.dataTable.render.number('.', ',', 0)},
            ],
            aoColumnDefs: [
                {
                    aTargets: [0, 1],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="objCli.getDetail(' + full.id + ')">' + data + '</a>';
                    }
                }

            ],
        });
    }

    this.tableTotal_cost = function () {
        console.log("asd");
        var obj = {};
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();
        obj.warehouse_id = $("#Detail #warehouse_id").val();
        obj.client_id = $("#Detail #client_id").val();

        return $('#tblTotal_cost').DataTable({
            "dom":
                    "R<'row'<'col-sm-4'l><'col-sm-2 toolbar text-right'><'col-sm-3'B><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12't>>" +
                    "<'row'<'col-xs-3 col-sm-3 col-md-3 col-lg-3'i><'col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center'p><'col-xs-3 col-sm-3 col-md-3 col-lg-3'>>",
            buttons: [
                {
                    extend: 'excelHtml5',
//                    text: '<i class="fa fa-file-excel-o"></i>',
                    className: 'btn btn-primary glyphicon glyphicon-download',
                    titleAttr: 'Excel'
                },
            ],
            destroy: true,
            ajax: {
                url: "/operations/getTotalCost",
                data: obj,
            },
            scrollX: true,
            columns: [
                {data: "warehouse"},
                {data: "total", render: $.fn.dataTable.render.number('.', ',', 0)},
            ],
            aoColumnDefs: [
                {
                    aTargets: [0, 1],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="objCli.getDetail(' + full.id + ')">' + data + '</a>';
                    }
                }

            ],
        });
    }

    this.tableNivelService = function () {
        var obj = {};
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();
        obj.warehouse_id = $("#Detail #warehouse_id").val();
        obj.client_id = $("#Detail #client_id").val();

        return $('#tblservice').DataTable({
            destroy: true,
            ajax: {
                url: "/operations/getNivelService",
                data: obj,
            },
            scrollX: true,
            columns: [
                {data: "client"},
                {data: "pedidos"},
                {data: "valor", render: $.fn.dataTable.render.number(',', '.', 0)},
            ],
            aoColumnDefs: [
                {
                    aTargets: [0, 1],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="objCli.getDetail(' + full.id + ')">' + data + '</a>';
                    }
                }

            ],
        });
    }

    this.tableClientAverage = function () {
        var obj = {};
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();
        obj.warehouse_id = $("#Detail #warehouse_id").val();
        obj.client_id = $("#Detail #client_id").val();
        return $('#tblAverageClient').DataTable({
            "dom":
                    "R<'row'<'col-sm-4'l><'col-sm-2 toolbar text-right'><'col-sm-3'B><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12't>>" +
                    "<'row'<'col-xs-3 col-sm-3 col-md-3 col-lg-3'i><'col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center'p><'col-xs-3 col-sm-3 col-md-3 col-lg-3'>>",
            buttons: [
                {
                    extend: 'excelHtml5',
//                    text: '<i class="fa fa-file-excel-o"></i>',
                    className: 'btn btn-primary glyphicon glyphicon-download',
                    titleAttr: 'Excel'
                },
            ],
            destroy: true,
            ajax: {
                url: "/operations/getAverageTime",
                data: obj,
            },
            scrollX: true,
            columns: [
                {data: "business"},
                {data: "promedio"},
            ],
            aoColumnDefs: [
                {
                    aTargets: [0, 1],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="objCli.getDetail(' + full.id + ')">' + data + '</a>';
                    }
                }

            ],
        });
    }

    this.table = function () {
        var obj = {};
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();
        obj.warehouse_id = $("#Detail #warehouse_id").val();
        obj.client_id = $("#Detail #client_id").val();

        return $('#tbl').DataTable({
            "dom":
                    "R<'row'<'col-sm-4'l><'col-sm-2 toolbar text-right'><'col-sm-3'B><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12't>>" +
                    "<'row'<'col-xs-3 col-sm-3 col-md-3 col-lg-3'i><'col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center'p><'col-xs-3 col-sm-3 col-md-3 col-lg-3'>>",
            buttons: [
                {
                    extend: 'excelHtml5',
//                    text: '<i class="fa fa-file-excel-o"></i>',
                    className: 'btn btn-primary glyphicon glyphicon-download',
                    titleAttr: 'Excel'
                },
            ],
            destroy: true,
            order: [[2, "desc"]],
            ajax: {
                url: "/api/reportResponse",
                data: obj,
            },
            scrollX: true,
            columns: [
                {data: "client"},
                {data: "invoice"},
                {data: "created"},
                {data: "dispatched"},
                {data: "dias"},
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


    this.tableProductWeek = function () {
        var obj = {};
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();
        obj.warehouse_id = $("#Detail #warehouse_id").val();
        obj.client_id = $("#Detail #client_id").val();

        return $('#tblproductweek').DataTable({
            "dom":
                    "R<'row'<'col-sm-4'l><'col-sm-2 toolbar text-right'><'col-sm-3'B><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12't>>" +
                    "<'row'<'col-xs-3 col-sm-3 col-md-3 col-lg-3'i><'col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center'p><'col-xs-3 col-sm-3 col-md-3 col-lg-3'>>",
            buttons: [
                {
                    extend: 'excelHtml5',
//                    text: '<i class="fa fa-file-excel-o"></i>',
                    className: 'btn btn-primary glyphicon glyphicon-download',
                    titleAttr: 'Excel'
                },
            ],
            destroy: true,
            ajax: {
                url: "/operations/getProductWeek",
                data: obj,
            },
            scrollX: true,
            columns: [
                {data: "fecha"},
                {data: "dia"},
                {data: "subtotal", render: $.fn.dataTable.render.number('.', ',', 2)},
            ],
            aoColumnDefs: [
                {
                    aTargets: [0, 1, 2],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="objCli.getDetail(' + full.id + ')">' + data + '</a>';
                    }
                }

            ],
        });
    }

    this.tableProductDay = function () {
        var obj = {};
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();
        obj.warehouse_id = $("#Detail #warehouse_id").val();
        obj.client_id = $("#Detail #client_id").val();

        return $('#tblproductday').DataTable({
            "dom":
                    "R<'row'<'col-sm-4'l><'col-sm-2 toolbar text-right'><'col-sm-3'B><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12't>>" +
                    "<'row'<'col-xs-3 col-sm-3 col-md-3 col-lg-3'i><'col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center'p><'col-xs-3 col-sm-3 col-md-3 col-lg-3'>>",
            buttons: [
                {
                    extend: 'excelHtml5',
//                    text: '<i class="fa fa-file-excel-o"></i>',
                    className: 'btn btn-primary glyphicon glyphicon-download',
                    titleAttr: 'Excel'
                },
            ],
            destroy: true,
            ajax: {
                url: "/operations/getProductDay",
                data: obj,
            },
            scrollX: true,
            columns: [
                {data: "dia"},
                {data: "subtotal", render: $.fn.dataTable.render.number('.', ',', 2)},
            ],
            aoColumnDefs: [
                {
                    aTargets: [0, 1],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="objCli.getDetail(' + full.id + ')">' + data + '</a>';
                    }
                }

            ],
        });
    }

    this.tableProduct = function () {
        var obj = {};
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();
        obj.warehouse_id = $("#Detail #warehouse_id").val();
        obj.client_id = $("#Detail #client_id").val();

        $.ajax({
            url: "/api/reportClientProduct",
            method: 'GET',
            data: obj,
            success: function (data) {

                Highcharts.chart('container_product', {
                    chart: {
                        zoomType: 'xy'
                    },
                    title: {
                        text: 'Ventas por Productos '
                    },
                    subtitle: {
                        text: 'Ranking de ventas en COP (con IVA)'
                    },
                    xAxis: [{
                            categories: data.category,
                            crosshair: true
                        }],
                    yAxis: [{// Primary yAxis
                            labels: {
                                format: '{value}',
                                style: {
                                    color: Highcharts.getOptions().colors[1]
                                }
                            },
                            title: {
                                text: 'Unidades',
                                style: {
                                    color: Highcharts.getOptions().colors[1]
                                }
                            }
                        }, {// Secondary yAxis
                            title: {
                                text: 'Monto',
                                style: {
                                    color: Highcharts.getOptions().colors[0]
                                }
                            },
                            labels: {
                                format: '{value} $',
                                style: {
                                    color: Highcharts.getOptions().colors[0]
                                }
                            },
                            opposite: true
                        }],
                    tooltip: {
                        shared: true
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'left',
                        x: 120,
                        verticalAlign: 'top',
                        y: 100,
                        floating: true,
                        backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
                    },
                    series: [{
                            name: 'Valor en COP',
                            type: 'column',
                            yAxis: 1,
//                            data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
                            data: data.data,
                            tooltip: {
                                valueSuffix: ' $'
                            }

                        },
                        {
                            name: 'Unidades',
                            type: 'column',
                            data: data.quantity,
                            tooltip: {
                                valueSuffix: ' Units'
                            }
                        }

                    ]
                });
            }

        })
    }

    this.tableCities = function () {
        var obj = {};
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();
        obj.warehouse_id = $("#Detail #warehouse_id").val();
        obj.client_id = $("#Detail #client_id").val();

        $.ajax({
            url: "/api/reportClientCities",
            method: 'GET',
            data: obj,
            success: function (data) {
                Highcharts.chart('container_cities', {
                    chart: {
                        zoomType: 'xy'
                    },
                    title: {
                        text: 'Ventas por Ciudad '
                    },
                    subtitle: {
                        text: 'Ranking de Ventas en COP (con IVA)'
                    },
                    xAxis: [{
                            categories: data.category,
                            crosshair: true
                        }],
                    yAxis: [{// Primary yAxis
                            labels: {
                                format: '{value}',
                                style: {
                                    color: Highcharts.getOptions().colors[1]
                                }
                            },
                            title: {
                                text: 'Unidades',
                                style: {
                                    color: Highcharts.getOptions().colors[1]
                                }
                            }
                        }, {// Secondary yAxis
                            title: {
                                text: 'Monto',
                                style: {
                                    color: Highcharts.getOptions().colors[0]
                                }
                            },
                            labels: {
                                format: '{value} $',
                                style: {
                                    color: Highcharts.getOptions().colors[0]
                                }
                            },
                            opposite: true
                        }],
                    tooltip: {
                        shared: true
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'left',
                        x: 120,
                        verticalAlign: 'top',
                        y: 100,
                        floating: true,
                        backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
                    },
                    series: [{
                            name: 'Valor en COP',
                            type: 'column',
                            yAxis: 1,
//                            data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
                            data: data.data,
                            tooltip: {
                                valueSuffix: ' $'
                            }

                        }
                        ,
                        {
                            name: 'Unidades',
                            type: 'column',
                            data: data.quantity,
                            tooltip: {
                                valueSuffix: ' Units'
                            }
                        }

                    ]
                });
            }

        })


    }

    this.tableProductByCategory = function () {
        var obj = {};
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();
        obj.warehouse_id = $("#Detail #warehouse_id").val();
        obj.client_id = $("#Detail #client_id").val();

        return $('#tblProductbyCategory').DataTable({
            "dom":
                    "R<'row'<'col-sm-4'l><'col-sm-2 toolbar text-right'><'col-sm-3'B><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12't>>" +
                    "<'row'<'col-xs-3 col-sm-3 col-md-3 col-lg-3'i><'col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center'p><'col-xs-3 col-sm-3 col-md-3 col-lg-3'>>",
            buttons: [
                {
                    extend: 'excelHtml5',
//                    text: '<i class="fa fa-file-excel-o"></i>',
                    className: 'btn btn-primary glyphicon glyphicon-download',
                    titleAttr: 'Excel'
                },
            ],
            destroy: true,
            ajax: {
                url: "/api/reportProductByCategory",
                data: obj,
            },
            order: [[1, "desc"]],
            scrollX: true,
            "pageLength": 20,
            columns: [
                {data: "category"},
                {data: "quantity"},
                {data: "facturado", render: $.fn.dataTable.render.number('.', ',', 0)},
            ],
            aoColumnDefs: [
                {
                    aTargets: [0, 1],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="objCli.getDetail(' + full.id + ')">' + data + '</a>';
                    }
                }

            ],
        });
    }
}

var objCli = new Operations();
objCli.init();