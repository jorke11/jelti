function Product() {
    this.init = function () {
        this.table();
        this.productbycity();
        this.productbyclient();

        $(".input-client").cleanFields();
        $("#Detail #finit").datetimepicker({format: 'Y-m-d'});
        $("#Detail #fend").datetimepicker({format: 'Y-m-d'});

        $(".input-product").cleanFields();
        $(".date-report").html("De " + $("#Detail #finit").val() + " hasta " + $("#Detail #fend").val());
        $("#btnSearch").click(function () {
            obj.table();
            obj.productbycity();
            obj.productbyclient();
        })


        $("#Detail #client_id").on('select2:closing', function (evt) {
            obj.productbyclient();
        })
    }


    this.table = function () {

        var param = {};
        param.warehouse_id = $("#Detail #warehouse_id").val();
        param.client_id = $("#Detail #client_id").val();
        param.city_id = $("#Detail #city_id").val();
        param.product_id = $("#Detail #product_id").val();
        param.supplier_id = $("#Detail #supplier_id").val();
        param.commercial_id = $("#Detail #commercial_id").val();
        param.init = $("#Detail #finit").val();
        param.end = $("#Detail #fend").val();

        param.product_id = $("#Detail #product_id").val();


        return $('#tbl').DataTable({
            "dom":
                    "R<'row'<'col-sm-4'l><'col-sm-2 toolbar text-right'><'col-sm-1'B><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12't>>" +
                    "<'row'<'col-xs-3 col-sm-4 col-md-4 col-lg-5'i><'col-xs-6 col-sm-6 col-md-6 col-lg-7 text-center'p>>",
            ajax: {
                url: "/api/reportProduct",
                data: param,
            },
            buttons: [
                {
                    extend: 'excelHtml5',
//                    text: '<i class="fa fa-file-excel-o"></i>',
                    className: 'btn btn-primary glyphicon glyphicon-download',
                    titleAttr: 'Excel'
                },
            ],

            buttons: [
                {
                    extend: 'excelHtml5',
//                    text: '<i class="fa fa-file-excel-o"></i>',
                    className: 'btn btn-primary glyphicon glyphicon-download',
                    titleAttr: 'Excel'
                },
            ],

            destroy: true,
            columns: [
                {data: "product"},
                {data: "business_name"},
                {data: "quantity"},
                {data: "subtotal", render: $.fn.dataTable.render.number('.', ',', 2)},
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
    this.productbyclient = function () {

        var param = {};
        param.warehouse_id = $("#Detail #warehouse_id").val();
        param.client_id = $("#Detail #client_id").val();
        param.city_id = $("#Detail #city_id").val();
        param.product_id = $("#Detail #product_id").val();
        param.supplier_id = $("#Detail #supplier_id").val();
        param.commercial_id = $("#Detail #commercial_id").val();
        param.init = $("#Detail #finit").val();
        param.end = $("#Detail #fend").val();

        return $('#tblProductsClient').DataTable({
            "dom":
                    "R<'row'<'col-sm-4'l><'col-sm-2 toolbar text-right'><'col-sm-1'B><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12't>>" +
                    "<'row'<'col-xs-3 col-sm-4 col-md-4 col-lg-5'i><'col-xs-6 col-sm-6 col-md-6 col-lg-7 text-center'p>>",
            ajax: {
                url: "/api/reportProductByClient",
                data: param,
            },

            buttons: [
                {
                    extend: 'excelHtml5',
//                    text: '<i class="fa fa-file-excel-o"></i>',
                    className: 'btn btn-primary glyphicon glyphicon-download',
                    titleAttr: 'Excel'
                },
            ],

            destroy: true,
            columns: [
//                {data: "dispatched"},
                {data: "client"},
                {data: "product"},
                {data: "quantityproducts"},
                {data: "total", render: $.fn.dataTable.render.number('.', ',', 0)},
            ],
            order: [[0, 'ASC']],
            "lengthMenu": [[30, 100, 300, -1], [30, 100, 300, 'All']],
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

        var param = {};

        param.warehouse_id = $("#Detail #warehouse_id").val();
        param.client_id = $("#Detail #client_id").val();
        param.city_id = $("#Detail #city_id").val();
        param.product_id = $("#Detail #product_id").val();
        param.supplier_id = $("#Detail #supplier_id").val();
        param.commercial_id = $("#Detail #commercial_id").val();
        param.init = $("#Detail #finit").val();
        param.end = $("#Detail #fend").val();

        return $('#tblProducts').DataTable({
            "dom":
                    "R<'row'<'col-sm-4'l><'col-sm-2 toolbar text-right'><'col-sm-1'B><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12't>>" +
                    "<'row'<'col-xs-3 col-sm-4 col-md-4 col-lg-5'i><'col-xs-6 col-sm-6 col-md-6 col-lg-7 text-center'p>>",
            ajax: {
                url: "/api/reportProductCity",
                data: param,
            },
            buttons: [
                {
                    extend: 'excelHtml5',
//                    text: '<i class="fa fa-file-excel-o"></i>',
                    className: 'btn btn-primary glyphicon glyphicon-download',
                    titleAttr: 'Excel'
                },
            ],
            destroy: true,
            columns: [
                {data: "city"},
                {data: "product"},
                {data: "quantity"},
                {data: "price", render: $.fn.dataTable.render.number('.', ',', 2)},
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
}

var obj = new Product();
obj.init();