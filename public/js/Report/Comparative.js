function Client() {
    var header = "";
    this.init = function () {
        this.table();


        $("#Detail #finit").datetimepicker({format: 'Y-m-d'});
        $("#Detail #fend").datetimepicker({format: 'Y-m-d'});

        $(".input-client").cleanFields();

        $("#btnSearch").click(function () {
            objCli.table();
        });
    }

    this.table = function () {
        var obj = {};
        obj.warehouse_id = $("#Detail #warehouse_id").val();
        obj.client_id = $("#Detail #client_id").val();
        obj.city_id = $("#Detail #city_id").val();
        obj.product_id = $("#Detail #product_id").val();
        obj.commercial_id = $("#Detail #commercial_id").val();
        obj.supplier_id = $("#Detail #supplier_id").val();
        obj.init = $("#Detail #finit").val();
        obj.end = $("#Detail #fend").val();

        $.ajax({
            url: "comparatives/salesClient",
            method: 'GET',
            data: obj,
            success: function (data) {

                var html = "<tr><td>Cliente</td>";

                header = data.header;

                $.each(data.header, function (i, val) {
                    html += "<td>" + val.dates + "</td>";
                });
                html += "</tr>";

                $("#tblClient thead").html(html);

                html = '';
                var cont = 0;

                $.each(data.data, function (i, val) {
                    html += "<tr><td>" + val.client + "</td>";
                    for (var j = 0; j < val.detail.length; j++) {
                        if (data.header[cont].dates == val.detail[j].dates) {
                            html += "<td>" + val.detail[j].total + "</td>";
                        } else {
                            html += "<td>0</td>";
                            j--;
                        }
                        cont++;
                    }
                    cont = 0;

                    html += "</tr>";
                });
                $("#tblClient tbody").html(html);
            }
        });

    }



}

var objCli = new Client();
objCli.init();