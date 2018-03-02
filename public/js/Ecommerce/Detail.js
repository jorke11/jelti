function Detail() {
    this.init = function () {
        var html = "";
        this.getQuantity();
        this.table()

    }

    this.getQuantity = function () {
        var html = "";
        $.ajax({
            url: PATH + '/getCounter',
            method: 'GET',
            dataType: 'JSON',
            success: function (data) {
                $("#quantityOrders").html(data.quantity);
            }
        })
    }
    this.selectedSubcategory = function (obj) {

        $(obj).attr("src", $(obj).attr("src"));
    }

    this.table = function () {
        return $('#orderClient').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/api/listOrderClient",
            columns: [
                {data: "id"},
                {data: "invoice"},
                {data: "subtotalnumeric", render: $.fn.dataTable.render.number(',', '.', 0)},
                {data: "total", render: $.fn.dataTable.render.number(',', '.', 0)},
                {data: "status"},
            ],
//            order: [[2, 'DESC']],
            aoColumnDefs: [
                {
                    aTargets: [0],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.showModal(' + full.id + ')">' + data + '</a>';
                    }
                },
//                {
//                    targets: [2],
//                    searchable: false,
//                    "mData": null,
//                    "mRender": function (data, type, full) {
//                        return '<button class="btn btn-danger btn-xs" onclick="obj.delete(' + data.id + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
//                    }
//                }
            ],
        });
    }

}

var obj = new Detail();
obj.init();
