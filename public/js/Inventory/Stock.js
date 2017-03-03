function Stock() {
    var table;
    this.init = function () {
        table = this.table();
        
    }

    this.table = function () {
        return $('#tbl').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/api/listStock",
            columns: [
                {data: "date"},
                {data: "product"},
                {data: "entries"},
                {data: "departures"},
                {data: "available"},
            ],
            order: [[1, 'ASC']],
            aoColumnDefs: [
                {
                    aTargets: [0, 1],
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