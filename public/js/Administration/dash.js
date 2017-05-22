function Dash() {
    this.init = function () {
        var html = "";
        $.ajax({
            url: '/api/listMenu',
            method: "GET",
            async: true,
            dataType: 'JSON',
            success: function (data) {
                $.each(data, function (i, val) {
                    html += '<li><a><i class="fa ' + val.icon + '"></i> ' + val.title + ' <span class="fa fa-chevron-down"></span></a>'
                    if (val.nodes) {
                        html += '<ul class="nav child_menu">'
                        $.each(val.nodes, function (j, v) {
                            html += '<li><a href="' + v.controller + '">' + v.title + '</a></li>'
                        })
                        html += '</ul>'
                    }
                    html += '</li>';
                });

                

                $("#addMenu").html(html);

            }
        })
    }
}

var objD = new Dash();
objD.init();