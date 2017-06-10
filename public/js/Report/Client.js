function Client() {
    this.init = function () {
        this.table();
        $("#btnSearch").click(function () {
            objCli.table();
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
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/api/reportClient",
                data: obj,
            },
            columns: [
                {data: "business"},
                {data: "totalunidades"},
                {data: "totalformat"},
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
}

var objCli = new Client();
objCli.init();