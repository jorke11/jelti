function FulfillmentSup() {
    this.init = function () {

        $("#tabFulfillmentSup").click(function () {
            objFulfilmentSup.getInfo($("#frmFulfillmentSup #finit").val(), $("#frmFulfillmentSup #fend").val());
        })
        $("#frmFulfillment #btnSearch").click(function () {
            objFulfilmentSup.getInfo($("#frmFulfillmentSup #finit").val(), $("#frmFulfillmentSup #fend").val());
        })

    }

    this.getInfo = function (init, end) {
        $.ajax({
            url: '/report/fulfillmentSup/' + init + "/" + end,
            method: 'get',
            dataType: 'json',
            success: function (data) {
                var html = '';
                $("#frmFulfillmentSup #tblFulfillment tbody").empty();
                $.each(data.detail, function (i, val) {
                    html += '<tr><td>' + val.purchase + '</td><td>' + val.date_entry + '</td><td>' + val.date_purchase + '</td>';
                    html += '<td>' + val.lead_time + '</td><td>' + val.fulfillment + '</td></tr>';
                })
                $("#frmFulfillmentSup #tblFulfillment tbody").html(html);
            }
        })
    }
}

var objFulfilmentSup = new FulfillmentSup();
objFulfilmentSup.init();