function Product() {
    this.init = function () {
        this.table();
        this.productbycity();

        $(".input-find").cleanFields();
        $("#Detail #finit").datetimepicker({format: 'Y-m-d'});
        $("#Detail #fend").datetimepicker({format: 'Y-m-d'});
        
        
        $(".date-report").html("De "+$("#Detail #finit").val()+" hasta "+$("#Detail #fend").val());
        $("#btnSearch").click(function () {
            obj.table();
        })
    }

    this.table = function () {

        var param = {};
        param.init = $("#Detail #finit").val();
        param.end = $("#Detail #fend").val();
        param.city_id = $("#Detail #city_id").val();
        param.product_id = $("#Detail #product_id").val();

        return $('#tbl').DataTable({
            ajax: {
                url: "/api/reportProduct",
                data: param,
            },
            destroy: true,
            columns: [
                {data: "product"},
                {data: "totalunidades"},
                {data: "total", render: $.fn.dataTable.render.number('.', ',', 2)},
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

    
    this.productbycity = function () {
        var obj = {};

        var param = {};
        param.init = $("#Detail #finit").val();
        param.end = $("#Detail #fend").val();
        param.city_id = $("#Detail #city_id").val();
        param.product_id = $("#Detail #product_id").val();

        return $('#tblProducts').DataTable({
            ajax: {
                url: "/api/reportProductCity",
                data: param,
            },
            destroy: true,
            columns: [
                {data: "city"},
                {data: "product"},
                {data: "quantity"},
                {data: "price", render: $.fn.dataTable.render.number('.', ',', 2)},
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

var obj = new Product();
obj.init();