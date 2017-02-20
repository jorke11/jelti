function Dash() {
    this.init = function () {
        var html = "";
        $.ajax({
            url: '/api/listMenu',
            method: "GET",
            dataType: 'JSON',
            success: function (data) {
                $.each(data, function (i, val) {
                    html += '<li><a><i class="fa ' + val.icon + '"></i> ' + val.title + ' <span class="fa fa-chevron-down"></span></a>'
                    html += '<ul class="nav child_menu">'
                    html += '<li><a href="/sale">Sales</a></li></ul>'
                    html += '</li>';
                });
                $("#addMenu").html(html);

            }
        })
    }
}

var obj = new Dash();
obj.init();