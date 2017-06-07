function Commercial() {
    this.init = function () {
        this.table();
    }

    this.table = function () {
        return $('#tbl').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/api/reportCommercial",
            columns: [
                {data: "vendedor"},
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

var obj = new Commercial();
obj.init();