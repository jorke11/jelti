function dash() {
    this.init = function () {
        obj.sales();
        obj.tableProduct();
        obj.tableProductUnits();
        obj.tableSupplier();
    }

    this.sales = function () {
        $.ajax({
            url: "/api/reportSales",
            method: 'GET',
            dataType: "json",
            success: function (data) {
                Highcharts.chart('graph_sales', {
                    chart: {
                        zoomType: 'xy'
                    },
                    title: {
                        text: 'Ventas Mensuales'
                    },
                    subtitle: {
                        text: 'en COP (con IVA) y en Unidades'
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
                            data: data.subtotal,
                            tooltip: {
                                valueSuffix: ' $'
                            }

                        },
                        {
                            name: 'Unidades',
                            type: 'spline',
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


    this.tableProduct = function () {
        var obj = {};

        $.ajax({
            url: "/api/reportClientProductDash",
            method: 'GET',
            success: function (data) {

                Highcharts.chart('container_product', {
                    chart: {
                        zoomType: 'xy'
                    },
                    title: {
                        text: 'Ventas por Productos del mes ' + data.date
                    },
                    subtitle: {
                        text: 'Ranking de ' +data.date +' en COP (con IVA)'
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
                            color: "#00b065",
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
                            color: "#ccc",
                            tooltip: {
                                valueSuffix: ' Units'
                            }
                        }

                    ]
                });

            }

        })


    }
    this.tableProductUnits = function () {
        var obj = {};

        $.ajax({
            url: "/api/reportClientProductUnits",
            method: 'GET',
            success: function (data) {

                Highcharts.chart('graph_products', {
                    chart: {
                        zoomType: 'xy'
                    },
                    title: {
                        text: '<br>Ventas por Productos del mes ' + data.date
                    },
                    subtitle: {
                        text: 'Ranking de ' + data.date+ ' en Unidades'
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
                            color: "#ccc",
                            tooltip: {
                                valueSuffix: ' $'
                            }

                        },
                        {
                            name: 'Unidades',
                            type: 'column',
                            color: "#00b065",

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

    this.tableSupplier = function () {
        var obj = {};

        $.ajax({
            url: "/api/reportSupplierDash",
            method: 'GET',
            success: function (data) {

                Highcharts.chart('container_supplier', {
                    chart: {
                        zoomType: 'xy'
                    },
                    title: {
                        text: '<br>Ventas por Proveedor '
                    },
                    subtitle: {
                        text: 'Total Ventas (con IVA) en COP y en Unidades'
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
                            color: "#ccc",
                            tooltip: {
                                valueSuffix: ' $'
                            }

                        },
                        {
                            name: 'Unidades',
                            type: 'column',
                            data: data.quantity,
                            color: "#00b065",
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

var obj = new dash();
obj.init();