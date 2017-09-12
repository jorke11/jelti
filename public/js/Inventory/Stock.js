function Stock() {
    var table;
    this.init = function () {
        table = this.table();

        $("#btnFind").click(function () {
            obj.table();
        })
    }

    this.table = function () {
        var param = {};
        param.warehouse_id = $("#warehouse_id").val();
        param.bar_code = $("#bar_code").val();
        return $('#tbl').DataTable({
//            processing: true,
//            serverSide: true,
            destroy: true,
            lengthMenu: [[30, 100, 300, -1], [30, 100, 300, 'All']],
            ajax: {
                url: "/api/listStock",
                data: param
            },
            columns: [
                {data: "id"},
                {data: "reference"},
                {data: "product"},
                {data: "entries"},
                {data: "sales"},
                {data: "available"},
            ],
            order: [[5, 'ASC']],
            aoColumnDefs: [
                {
                    aTargets: [2],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.showModal(' + full.id + ')">' + data + '</a>';
                    }
                }
            ],
        });
    }

}

var obj = new Stock();
obj.init();