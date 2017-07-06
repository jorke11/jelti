function Client() {
    this.init = function () {
        this.table();
        this.tableTarget();
        this.tableProduct();
        this.tableCities();

        $("#Detail #finit").datetimepicker({format: 'Y-m-d'});
        $("#Detail #fend").datetimepicker({format: 'Y-m-d'});


        $("#btnSearch").click(function () {
            objCli.table();
            objCli.tableTarget();
            objCli.tableProduct();
            objCli.tableCities();
        })
    }

    this.getDetail = function (client_id) {
        window.open("departure/" + client_id + "/" + $("#Detail #finit").val() + "/" + $("#Detail #fend").val());

    }

    this.table = function () {
        var obj = {};
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();
        return $('#tbl').DataTable({
            destroy: true,
            order: [[2, "desc"]],
            ajax: {
                url: "/api/reportClient",
                data: obj,
            },
            columns: [
                {data: "business"},
                {data: "totalunidades"},
                {data: "total", render: $.fn.dataTable.render.number('.', ',', 2)},
            ],

            aoColumnDefs: [
                {
                    aTargets: [0, 1, 2],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="objCli.getDetail(' + full.id + ')">' + data + '</a>';
                    }
                }

            ],
            "decimal": ",",
            "thousands": ".",
        });
    }
    this.tableTarget = function () {
        var obj = {};
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();
        return $('#tblTarget').DataTable({
            destroy: true,
            ajax: {
                url: "/api/reportClientTarget",
                data: obj,
            },
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
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();


        $.ajax({
            url: "/api/reportClientProduct",
            method: 'GET',
            data: obj,
            success: function (data) {
                var chart = Highcharts.chart('container_product', {
                    title: {
                        text: 'Productos por Unidades de ' + $("#Detail #finit").val() + " a Hoy"
                    },

                    subtitle: {
                        text: 'SuperFüds'
                    },
                    xAxis: {
                        categories: data.categories
                    },
                    series: [{
                            type: 'column',
                            colorByPoint: true,
                            data: data.units,
                            showInLegend: false
                        }]

                });


            }

        })


    }

    this.tableCities = function () {
        var obj = {};
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();

        $.ajax({
            url: "/api/reportClientCities",
            method: 'GET',
            data: obj,
            success: function (data) {
                Highcharts.chart('container_cities', {
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: 'Unidades por Ciudades de ' + $("#Detail #finit").val() + " a Hoy"
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                style: {
                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                }
                            }
                        }
                    },
                    series: [{
                            name: 'Brands',
                            colorByPoint: true,
                            data: data.data
                        }]
                });


            }

        })

//        return $('#tblCities').DataTable({
//            destroy: true,
//            ajax: {
//                url: "/api/reportClientCities",
//                data: obj,
//            },
//            order: [[1, 'desc']],
//            columns: [
//                {data: "city"},
//                {data: "units"},
//            ],
//            aoColumnDefs: [
//                {
//                    aTargets: [0, 1],
//                    mRender: function (data, type, full) {
//                        return '<a href="#" onclick="objCli.getDetail(' + full.id + ')">' + data + '</a>';
//                    }
//                }
//
//            ],
//        });
    }
}

var objCli = new Client();
objCli.init();