function Commercial() {
    this.init = function () {
        this.table();
        this.tableCommercial();
        $("#Detail #finit").datetimepicker({format: 'Y-m-d'});
        $("#Detail #fend").datetimepicker({format: 'Y-m-d'});
        $("#btnSearch").click(function () {
            objCom.table();
            objCom.tableCommercial();
//            objCom.tableTarget();
//            objCom.tableProduct();
//            objCom.tableCities();
        })
    }

    this.table = function () {
        var obj = {};
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();
        return $('#tbl').DataTable({
            "ajax": {
                url: "/api/reportCommercial",
                method: 'GET',
                data: obj
            },
            columns: [
                {data: "vendedor"},
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
    
    
    this.tableCommercial = function () {
        var obj = {};
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();

        $.ajax({
            url: "/api/reportCommercialGraph",
            method: 'GET',
            data: obj,
            success: function (data) {
                Highcharts.chart('container_commercial', {
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: 'Top 5 Vendedores de ' + $("#Detail #finit").val() + " a Hoy"
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
    }
}

var objCom = new Commercial();
objCom.init();