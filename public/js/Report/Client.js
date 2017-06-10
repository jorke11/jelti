function Client() {
    this.init = function () {
        this.table();
        $("#btnSearch").click(function () {
            objCli.table();
        })
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
//            dataSrc: function (json) {
//                console.log(json)
////                return json.data;
//            },
            columns: [
                {data: "business"},
                {data: "totalunidades"},
                {data: "totalformat"},
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

var objCli = new Client();
objCli.init();