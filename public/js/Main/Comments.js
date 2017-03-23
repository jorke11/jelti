function Comments() {
    this.init = function () {
        var html = "";
        $.ajax({
            url: '/comments/list',
            method: "get",
            dataType: 'json',
            success: function (data) {
                $.each(data, function (i, val) {
                    html += "<tr><td>" + val.product + "</td></tr>";
                });

                $("#tbl tbody").html(html);
                console.log(data)
            }
        })
    }
}

var obj = new Comments();

obj.init();

