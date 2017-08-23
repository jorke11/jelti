function Profile() {
    this.init = function () {

        $("#Detail #finit").datetimepicker({format: 'Y-m-d'});
        $("#Detail #fend").datetimepicker({format: 'Y-m-d'});
        $("#Detail #client_id").cleanFields();

        $("#btnSearch").click(function () {
            obj.getClient($("#Detail #client_id :selected").val());
            obj.tableProduct();
            obj.tableRepurchase($("#Detail #client_id :selected").val());
        });
    }
    this.tableRepurchase = function (id) {
        $("#tblRepurchase thead").html("");
        $("#tblRepurchase tbody").html("");
        var param = {};
        param.init = $("#Detail #finit").val();
        param.end = $("#Detail #fend").val();
        $.ajax({
            url: "profile/" + id + "/getRepurchase",
            method: 'GET',
            data: param,
            dataType: 'json',
            success: function (data) {
                var html = '<tr><td>Productos</td>';
                $.each(data.products[0].quantity_dep, function (i, val) {
                    html += '<td>' + i + ' (' + val.date + ')</td>';
                })
                html += '<td>Sumatoria</td>';
                html += '<td>Promedio</td>';
                html += '<tr>';
                $("#tblRepurchase thead").html(html);

                html = '';
                var cont = 0, del = [], quant = 0;
                $.each(data.products, function (i, val) {
                    cont = 0;
                    quant = 0;
                    html += "<tr id='row_" + i + "'><td>" + val.title + "</td>";
                    $.each(val.quantity_dep, function (j, value) {
                        html += "<td>" + value.quantity + "</td>";
                        cont += parseInt(value.quantity);
                        quant++;
                    })

                    html += "<td>" + cont + "</td>";
                    html += "<td>" + cont / quant + "</td>";
                    quant = 0;
                    if (cont == 0) {
                        del.push(i);
                    }

                    html += "</tr>";

                })


                $("#tblRepurchase tbody").html(html);
                $.each(del, function (i, val) {
                    $("#row_" + val).remove();
                })

//                console.log(data.products[0].quantity_dep);
            }
        });
    }

    this.getClient = function (id) {
        var param = {};
        param.init = $("#Detail #finit").val();
        param.end = $("#Detail #fend").val();

        $.ajax({
            url: "/profile/" + id + "/getClient",
            method: 'GET',
            data: param,
            dataType: 'json',
            success: function (data) {
                $("#client_until").html(data.client.created_at);
                $("#responsible").html(data.client.responsible);
                $("#name_client").html(data.client.business);
                $("#city_address").html(data.client.address_invoice + " / " + data.client.city_invoice);
                $("#lead_time").html(0);
                $("#last_sale").html(0);
                $("#frecuency").html(data.frecuency + " días");
                $("#sector").html(data.client.sector);
                $("#total_sales").html(data.totales.subtotalFormated);
                $("#ticket").html(data.ticket);
                $("#total_request").html(data.total_request);
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

var obj = new Profile();
obj.init();