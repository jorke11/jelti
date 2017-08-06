function FulfillmentCli() {
    this.init = function () {

        console.log("asd");

        $("#tabFulfillmentCli").click(function () {
            console.log("asd");
            objFulfilmentCli.getInfo($("#frmFulfillmentCli #finit").val(), $("#frmFulfillmentCli #fend").val());
        })
        $("#frmFulfillment #btnSearch").click(function () {
            objFulfilmentCli.getInfo($("#frmFulfillmentCli #finit").val(), $("#frmFulfillmentCli #fend").val());
        })

    }

    this.getInfo = function (init, end) {
        $.ajax({
            url: '/report/fulfillmentCli/' + init + "/" + end,
            method: 'get',
            dataType: 'json',
            success: function (data) {
                var html = '', time = '';
                $("#frmFulfillmentCli #tblFulfillment tbody").empty();
                $.each(data.detail, function (i, val) {
                    time = '';
                    if (val.days != '0') {
                        time += val.days + " Days";
                    }
                    if (val.hours != '0') {
                        time += val.hours + ' hours';
                    }

                    html += '<tr><td>' + val.departure + '</td><td>' + val.created + '</td><td>' + val.updated_at + '</td>';
                    html += '<td>' + time + '</td></tr>';
                })
                $("#frmFulfillmentCli #tblFulfillment tbody").html(html);
            }
        })
    }
}

var objFulfilmentCli = new FulfillmentCli();
objFulfilmentCli.init();