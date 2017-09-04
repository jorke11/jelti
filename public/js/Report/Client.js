function Client() {
    this.init = function () {
        this.table();
        this.tableTarget();
        this.tableProduct();
        this.tableCities();
        this.tableProductByCategory();
//        this.tableRepeatOrder();

        $("#Detail #finit").datetimepicker({format: 'Y-m-d'});
        $("#Detail #fend").datetimepicker({format: 'Y-m-d'});

        $(".input-client").cleanFields();

        $("#btnSearch").click(function () {
            objCli.table();
            objCli.tableTarget();
            objCli.tableProduct();
            objCli.tableCities();
            objCli.tableProductByCategory();
        });
    }

    this.getDetail = function (client_id) {
        window.open("departure/" + client_id + "/" + $("#Detail #finit").val() + "/" + $("#Detail #fend").val());
    }

    this.table = function () {
        var obj = {};
        obj.warehouse_id = $("#Detail #warehouse_id").val();
        obj.client_id = $("#Detail #client_id").val();
        obj.city_id = $("#Detail #city_id").val();
        obj.product_id = $("#Detail #product_id").val();
        obj.commercial_id = $("#Detail #commercial_id").val();
        obj.supplier_id = $("#Detail #supplier_id").val();
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();


        return $('#tbl').DataTable({
            destroy: true,
            order: [[2, "desc"]],
            ajax: {
                url: "/api/reportClient",
                data: obj,
            },
            scrollX: true,
            columns: [
                {data: "client"},
                {data: "unidades"},
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

            ]
        });
    }

    this.tableTarget = function () {
        var obj = {};
        obj.warehouse_id = $("#Detail #warehouse_id").val();
        obj.client_id = $("#Detail #client_id").val();
        obj.city_id = $("#Detail #city_id").val();
        obj.product_id = $("#Detail #product_id").val();
        obj.supplier_id = $("#Detail #supplier_id").val();
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();
        obj.commercial_id = $("#Detail #commercial_id").val();

        return $('#tblTarget').DataTable({
            destroy: true,
            ajax: {
                url: "/api/reportClientTarget",
                data: obj,
            },
            scrollX: true,
            columns: [
                {data: "business"},
                {data: "seats"},
                {data: "created"},
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
    this.tableProduct = function () {
        var obj = {};
        obj.warehouse_id = $("#Detail #warehouse_id").val();
        obj.client_id = $("#Detail #client_id").val();
        obj.city_id = $("#Detail #city_id").val();
        obj.product_id = $("#Detail #product_id").val();
        obj.supplier_id = $("#Detail #supplier_id").val();
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();
        obj.commercial_id = $("#Detail #commercial_id").val();

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
        obj.warehouse_id = $("#Detail #warehouse_id").val();
        obj.client_id = $("#Detail #client_id").val();
        obj.city_id = $("#Detail #city_id").val();
        obj.product_id = $("#Detail #product_id").val();
        obj.supplier_id = $("#Detail #supplier_id").val();
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();
        obj.commercial_id = $("#Detail #commercial_id").val();

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
        obj.warehouse_id = $("#Detail #warehouse_id").val();
        obj.client_id = $("#Detail #client_id").val();
        obj.city_id = $("#Detail #city_id").val();
        obj.product_id = $("#Detail #product_id").val();
        obj.supplier_id = $("#Detail #supplier_id").val();
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();
        obj.commercial_id = $("#Detail #commercial_id").val();

        return $('#tblProductbyCategory').DataTable({
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
//                {data: "facturado", render: $.fn.dataTable.render.number('.', ',', 0)},
                {data: "subtotal", render: $.fn.dataTable.render.number('.', ',', 0)},
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

var objCli = new Client();
objCli.init();