function Supplier() {
    this.init = function () {
        this.table();
        this.tableClient();

        $(".input-find").cleanFields();
        $("#Detail #finit").datetimepicker({format: 'Y-m-d'});
        $("#Detail #fend").datetimepicker({format: 'Y-m-d'});
        $("#btnSearch").click(function () {
            obj.table();
            obj.tableClient();
        })


    }

    this.getDetail = function (client_id) {
        var product = ($("#Detail #product_id").val() == null) ? 0 : $("#Detail #product_id").val();
        var supplier = ($("#Detail #supplier_id").val() == null) ? 0 : $("#Detail #supplier_id").val();
        window.open("departure/" + client_id + "/" + $("#Detail #finit").val() + "/" + $("#Detail #fend").val() + "/" + product + "/" + supplier);

    }

    this.table = function () {
        var param = {};
        param.init = $("#Detail #finit").val();
        param.end = $("#Detail #fend").val();

        return $('#tbl').DataTable({
            destroy: true,
            ajax: {
                url: "/api/reportSupplier",
                data: param,
            },
            columns: [
                {data: "business"},
                {data: "totalunidades"},
                {data: "total"},
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
            columns: [
                {data: "business"},
                {data: "totalunidades"},
                {data: "totalformated"},
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