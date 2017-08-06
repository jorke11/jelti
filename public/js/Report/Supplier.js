function Supplier() {
    this.init = function () {
        this.table();
        this.tableClient();
        this.tableSales();

        $(".input-find").cleanFields();
        $("#Detail #finit").datetimepicker({format: 'Y-m-d'});
        $("#Detail #fend").datetimepicker({format: 'Y-m-d'});

        $("#btnSearch").click(function () {
            obj.table();
            obj.tableClient();
            obj.tableSales();
        })
    }

    this.getDetail = function (id) {
        var product = ($("#Detail #product_id").val() == null) ? 0 : $("#Detail #product_id").val();
        var supplier = ($("#Detail #supplier_id").val() == null) ? 0 : $("#Detail #supplier_id").val();
        window.open("departure/" + id + "/" + $("#Detail #finit").val() + "/" + $("#Detail #fend").val() + "/" + product + "/" + supplier);

    }
    this.getDetailSup = function (id) {
        var product = ($("#Detail #product_id").val() == null) ? 0 : $("#Detail #product_id").val();
        var supplier = ($("#Detail #supplier_id").val() == null) ? 0 : $("#Detail #supplier_id").val();
        window.open("departure/" + id + "/" + $("#Detail #finit").val() + "/" + $("#Detail #fend").val() + "/" + product + "/" + supplier);

    }

    this.table = function () {
        var param = {};
        param.init = $("#Detail #finit").val();
        param.end = $("#Detail #fend").val();

        $.ajax({
            url: "/api/reportSupplier",
            method: 'GET',
            data: param,
            success: function (data) {

                Highcharts.chart('container_supplier', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Compras por proveedores'
                    },
                    subtitle: {
                        text: 'Source: WorldClimate.com'
                    },
                    xAxis: {
                        categories: ["Mes Anterior", "Actual"],
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Monto ($)'
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
//                    series: [{
//                            name: 'Tokyo',
//                            data: [5000]
//
//                        }, {
//                            name: 'New York',
//                            data: [10000, 20000]
//
//                        }, {
//                            name: 'Other',
//                            data: [10000, 20000]
//
//                        }],
                    series: data.series
                });

            }

        })
    }

    this.tableSales = function () {
        var param = {};
        param.init = $("#Detail #finit").val();
        param.end = $("#Detail #fend").val();

        return $('#tblSales').DataTable({
            destroy: true,
            ajax: {
                url: "/api/reportSupplierSales",
                data: param,
            },
            order: [[2, "desc"]],
            columns: [
                {data: "business"},
                {data: "totalunidades"},
                {data: "total", render: $.fn.dataTable.render.number('.', ',', 2)},
            ],
            aoColumnDefs: [
                {
                    aTargets: [0, 1, 2],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.getDetailSup(' + full.id + ')">' + data + '</a>';
                    }
                }
            ],
        });
    }

    this.tableClient = function () {
        var param = {};
        param.init = $("#Detail #finit").val();
        param.end = $("#Detail #fend").val();
        param.product_id = $("#Detail #product_id").val();
        param.supplier_id = $("#Detail #supplier_id").val();

        return $('#tblClient').DataTable({
            destroy: true,
            ajax: {
                url: "/api/reportSupplierClient",
                data: param,
            },
            order: [[2, "desc"]],
            columns: [
                {data: "business"},
                {data: "totalunidades"},
                {data: "total", render: $.fn.dataTable.render.number('.', ',', 2)},
            ],
            aoColumnDefs: [
                {
                    aTargets: [0, 1, 2],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.getDetail(' + full.id + ')">' + data + '</a>';
                    }
                }
            ],
        });
    }
}

var obj = new Supplier();
obj.init();