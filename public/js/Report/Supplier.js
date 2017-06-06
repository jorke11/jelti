function Supplier() {
    this.init = function () {
        this.table();

        $("#btnSearch").click(function () {
            obj.table();
        })
    }

    this.table = function () {
        var param = {};
        param.init = $("#Detail #finit").val();
        param.end = $("#Detail #fend").val();

        return $('#tbl').DataTable({
            processing: true,
            serverSide: true,
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

var obj = new Supplier();
obj.init();