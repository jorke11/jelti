function Sales() {
    this.init = function () {

        $("#frmSale #finit").datetimepicker({format: 'Y-m-d'});
        $("#frmSale #fend").datetimepicker({format: 'Y-m-d'});

        objSale.getInfo($("#frmSale #finit").val(), $("#frmSale #fend").val());

        $("#frmSale #btnSearch").click(function () {
            objSale.getInfo($("#frmSale #finit").val(), $("#frmSale #fend").val());
        })
    }

    this.see = function () {
        window.open("departure/" + 0 + "/" + $("#frmSale #finit").val() + "/" + $("#frmSale #fend").val());
    }

    this.getInfo = function (init, end) {
        var link = "";
        $.ajax({
            url: '/report/sale/' + init + "/" + end,
            method: 'get',
            dataType: 'json',
            success: function (data) {
                link = '<span style="cursor:pointer" class="glyphicon glyphicon-search" aria-hidden="true" onclick=objSale.see()></span>';
                $("#frmSale #quantityTotal").html("Venta Total:<strong>" + data.totalsales + "</strong>&nbsp;" + link
                        + "<br>Total flete:<strong>" + data.shipping_cost + "</strong><br>"
                        + "Nota incluido credito: <strong>" + 0 + "</strong><br>" +
                        "<br><p>Quantiy: <strong>" +
                        data.quantity.quantity + "</strong> Units <br>Product: <strong>" + data.quantity.title + "</strong></p>");


                Highcharts.chart('graph_sales', {
                    chart: {
                        zoomType: 'xy'
                    },
                    title: {
                        text: 'Total ventas 3 ultimo meses'
                    },
                    subtitle: {
                        text: 'Ventas totales con IVA'
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
                            data: data.total,
                              color: "#00b065",
                            tooltip: {
                                valueSuffix: ' $'
                            }

                        },
                        {
                            name: 'Unidades',
                            type: 'spline',
                            data: data.quantities,
                              color: "#000000",
                            tooltip: {
                                valueSuffix: ' Units'
                            }
                        }

                    ]
                });
            }
        })

    }
}

var objSale = new Sales();
objSale.init();