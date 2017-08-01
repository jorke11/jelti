function CEO() {
    this.init = function () {

        $("#Detail #finit").datetimepicker({format: 'Y-m-d'});
        $("#Detail #fend").datetimepicker({format: 'Y-m-d'});

        $("#btnSearch").click(function () {
           obj.getOverView();
//            obj.tableProduct(); 
        });
        obj.getOverView();
    }

    this.getOverView = function () {
        var param = {};
        param.init = $("#Detail #finit").val();
        param.end = $("#Detail #fend").val();

        $.ajax({
            url: "overview/getOverview",
            method: 'GET',
            data: param,
            dataType: 'json',
            success: function (data) {
                $("#total_client").html(data.client);
                $("#total_invoice").html(data.invoices);
                $("#average").html(data.average);
                $("#category").html(data.category);
                $("#supplier").html(data.supplier);
            }
        });
    }

    this.getClient = function (id) {
        $.ajax({
            url: "/profile/" + id + "/getClient",
            method: 'GET',
            success: function (data) {
                $("#client_until").html(data.client.created_at);
                $("#responsible").html(data.client.responsible);
                $("#name_client").html(data.client.business);
                $("#city_address").html(data.client.address_invoice + " / " + data.client.city_invoice);
                $("#lead_time").html(0);
                $("#last_sale").html(0);
                $("#frecuency").html(data.frecuency + " días");
                $("#sector").html(data.client.sector);
            }
        });
    }

    this.tableProduct = function () {
        var obj = {};
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();
        obj.client_id = $("#Detail #client_id").val();
        return $('#tblProduct').DataTable({
            destroy: true,
            order: [[2, "desc"]],
            ajax: {
                url: "api/reportProductByClient",
                data: obj,
            },
            columns: [
                {data: "product"},
                {data: "quantityproducts"},
                {data: "total", render: $.fn.dataTable.render.number('.', ',', 2)},
            ],

            aoColumnDefs: [
                {
                    aTargets: [0, 1],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="objCli.getDetail(' + full.id + ')">' + data + '</a>';
                    }
                }

            ]
        });
    }
}

var obj = new CEO();
obj.init();