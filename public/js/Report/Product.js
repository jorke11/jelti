function Product() {
    this.init = function () {
        this.table();
        this.productbycity();

        $(".input-find").cleanFields();
        $("#Detail #finit").datetimepicker({format: 'Y-m-d'});
        $("#Detail #fend").datetimepicker({format: 'Y-m-d'});

        $("#btnSearch").click(function () {
            obj.table();
        })
    }

    this.table = function () {

        var param = {};
        param.init = $("#Detail #finit").val();
        param.end = $("#Detail #fend").val();
        param.city_id = $("#Detail #city_id").val();
        param.product_id = $("#Detail #product_id").val();

        return $('#tbl').DataTable({
            ajax: {
                url: "/api/reportProduct",
                data: param,
            },
            destroy: true,
            columns: [
                {data: "product"},
                {data: "totalunidades"},
                {data: "total", render: $.fn.dataTable.render.number('.', ',', 2)},
            ],
            order: [[2, 'DESC']],
            aoColumnDefs: [
                {
                    aTargets: [0, 1, 2],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.showModal(' + full.id + ')">' + data + '</a>';
                    }
                }
            ],
        });
    }


    this.productbycity = function () {
        var obj = {};

        $.ajax({
            url: "/api/reportProductCity",
            method: 'GET',
            success: function (data) {

                Highcharts.chart('container_products', {
                    chart: {
                        zoomType: 'xy'
                    },
                    title: {
                        text: '<br>Ventas por Productos '
                    },
                    subtitle: {
                        text: 'Ventas con IVA en $ y en Units'
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
                            name: 'Facturado',
                            type: 'column',
                            yAxis: 1,
//                            data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
                            data: data.data,
                            color: "#ccc",
                            tooltip: {
                                valueSuffix: ' $'
                            }

                        }

                    ]
                });

            }

        })


    }
}

var obj = new Product();
obj.init();