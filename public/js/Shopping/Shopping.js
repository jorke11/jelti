function Shop() {
    this.init = function () {
        var html = "";
        $.ajax({
            url: 'getCategories/',
            method: 'GET',
            dataType: 'JSON',
            success: function (data) {
                html = '<div class="row">';
                $.each(data, function (i, val) {
                    html += '<div class="col-sm-3 col-lg-3 col-md-3">'
                    html += '<div class="thumbnail">'
//                    html += '<img src="https://placeholdit.imgix.net/~text?txtsize=39&txt=420Products%C3%97250&w=420&h=250">'
                    html += '<img src="/' + val.image + '">'
                    html += '<div class="caption">'
                    html += '<h4><a href="/shopping/' + val.id + '">' + val.description + '</a></h4>'
                    html += '<p>' + val.short_description + '</p>'
                    html += '</div></div></div>';
                })
                html += '</div>';

                $("#content-category").html(html);
            }

        })
    }
}

var obj = new Shop();
obj.init();
