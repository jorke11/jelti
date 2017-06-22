function Supplier() {
    this.init = function () {
        this.table();
        this.tableClient();
        
         $(".input-find").cleanFields();

        $("#btnSearch").click(function () {
            obj.table();
            obj.tableClient();
        })
    }
    
    this.getDetail = function (client_id) {
        window.open("departure/" + client_id + "/" + $("#Detail #finit").val() + "/" + $("#Detail #fend").val());

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