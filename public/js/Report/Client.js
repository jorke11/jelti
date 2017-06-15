function Client() {
    this.init = function () {
        this.table();
        this.tableTarget();
        this.tableProduct();
        $("#btnSearch").click(function () {
            objCli.table();
            objCli.tableTarget();
            objCli.tableProduct();
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
            destroy: true,
            "aaSorting": false,
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
    this.tableTarget = function () {
        var obj = {};
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();
        return $('#tblTarget').DataTable({
            destroy: true,
            "aaSorting": false,
            ajax: {
                url: "/api/reportClientTarget",
                data: obj,
            },
            columns: [
                {data: "business"},
                {data: "seats"},
                {data: "created"},
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
    this.tableProduct = function () {
        var obj = {};
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();
        return $('#tblProduct').DataTable({
            destroy: true,
            "aaSorting": false,
            ajax: {
                url: "/api/reportClientProduct",
                data: obj,
            },
            columns: [
                {data: "product"},
                {data: "units"},
            ],
            aoColumnDefs: [
                {
                    aTargets: [0, 1],
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