function Commercial() {
    this.init = function () {
        this.table();
        this.tableCommercial();
        this.tableProductsByCommecial();
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

    this.see = function (id) {
        window.open("departure/_" + id + "/" + $("#Detail #finit").val() + "/" + $("#Detail #fend").val());
    }

    this.table = function () {
        var obj = {};
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();
        return $('#tbl').DataTable({
            destroy: true,
            "ajax": {
                url: "/api/reportCommercial",
                method: 'GET',
                data: obj
            },
            columns: [
                {data: "vendedor"},
                {data: "quantity"},
                {data: "subtotal", render: $.fn.dataTable.render.number('.', ',', 2)},
                {data: "total", render: $.fn.dataTable.render.number('.', ',', 2)},
            ],
            order: [[2, 'DESC']],
            aoColumnDefs: [
                {
                    aTargets: [0, 1, 2],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="objCom.see(' + full.responsible_id + ')">' + data + '</a>';
                    }
                }
            ],
        });
    }

    this.tableProductsByCommecial = function () {
        var obj = {};
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();

        $.ajax({
            url: "/api/reportProductByCommercial",
            dataType: "json",
            "success": function (json) {
                var tableHeaders = '<tr>', body = '';

                $.each(json.columns, function (i, val) {
                    tableHeaders += '<th rowspan=' + rowspan + '>' + val + "</th>";
                });
                

//                $("#content-product").empty();
//                $("#content-product").append('<table id="displayTable" class="display" cellspacing="0" width="100%"><thead><tr>' + tableHeaders + '</tr></thead></table>');

//        console.log(tableHeaders)
                $("#displayTable thead").html(tableHeaders);
                var rowspan = '';
                $.each(json.data, function (i, val) {

                    body += "<tr>";
                    $.each(val, function (j, value) {

                        body += '<td >' + value + "</td>";
                    });

                    body += "</tr>";

                });

                $('#displayTable tbody').html(body);
                $('#displayTable').dataTable({
                    scrollX: true
                });

//                $('#displayTable').DataTable({
//                    data: json.data,
////                    columns: json.columns,
//                    scrollX: true
//                });
            },

        });


//        return $('#tblProducts').DataTable({
//            destroy: true,
//            "ajax": {
//                url: "/api/reportProductByCommercial",
//                method: 'GET',
//                data: obj
//            },
//            columns: [
//                {data: "vendedor"},
//                {data: "quantity"},
//                {data: "subtotal", render: $.fn.dataTable.render.number('.', ',', 2)},
//                {data: "total", render: $.fn.dataTable.render.number('.', ',', 2)},
//            ],
//            order: [[2, 'DESC']],
//            aoColumnDefs: [
//                {
//                    aTargets: [0, 1, 2],
//                    mRender: function (data, type, full) {
//                        return '<a href="#" onclick="objCom.see(' + full.id + ')">' + data + '</a>';
//                    }
//                }
//            ],
//        });
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