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
            "dom":
                    "R<'row'<'col-sm-4'l><'col-sm-2 toolbar text-right'><'col-sm-3'B><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12't>>" +
                    "<'row'<'col-xs-3 col-sm-3 col-md-3 col-lg-3'i><'col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center'p><'col-xs-3 col-sm-3 col-md-3 col-lg-3'>>",
//            processing: true,
//            serverSide: true,
            destroy: true,
            lengthMenu: [[30, 100, 300, -1], [30, 100, 300, 'All']],
            ajax: {
                url: "/api/listStock",
                data: param
            },
            buttons: [
                {
                    extend: 'excelHtml5',
                    className: 'btn btn-primary glyphicon glyphicon-download',
                    titleAttr: 'Excel'
                },
            ],
            columns: [
                {data: "id"},
                {data: "reference"},
                {data: "stakeholder"},
                {data: "category"},
                {data: "product"},
                {data: "quantity"},
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