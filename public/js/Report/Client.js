function Client() {
    this.init = function () {
        this.table();
    }

    this.table = function () {
        var obj = {};
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();

        return $('#tbl').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "/api/reportClient",
                data: obj,
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

var objSale = new Client();
objSale.init();