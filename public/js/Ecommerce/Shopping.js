function Shop() {
    this.init = function () {
        $("#addComment").click(this.addComment);
        var html = "";
        
        this.getQuantity();
        $.ajax({
            url: 'getCategories/',
            method: 'GET',
            dataType: 'JSON',
            success: function (data) {
                html = '<div class="row">';
                $.each(data, function (i, val) {
                    html += '<div class="col-sm-3 col-lg-3 col-md-3">'
                    html += '<div class="thumbnail" style="height:290px">'
                    html += '<img src="/' + val.image + '">'
                    html += '<div class="caption">'
                    html += '<h4><a href="/ecommerce/' + val.id + '">' + val.description + '</a></h4>'
                    html += '<p>' + val.short_description + '</p>'
                    html += '</div></div></div>';
                })
                html += '</div>';

                $("#content-category").html(html);
            }
        })
    }
    
     this.getQuantity = function () {
         console.log("desde shopping");
        var html = "";
        $.ajax({
            url: PATH + '/getCounter',
            method: 'GET',
            dataType: 'JSON',
            success: function (data) {
                $("#quantityOrders").html(data.quantity);
            }
        })
    }

    this.addComment = function () {
        var html = "";
        var obj = {};
        obj.comment = $("#txtComment").val();
        console.log("asdsad")
        $.ajax({
            url: 'addComment/',
            method: 'POST',
            dataType: 'JSON',
            success: function (data) {
                html = '<div class="row">';
                $.each(data, function (i, val) {
                    html += '<div class="col-sm-3 col-lg-3 col-md-3">'
                    html += '<div class="thumbnail">'
                    html += '<img src="/' + val.image + '">'
                    html += '<div class="caption">'
                    html += '<h4><a href="/ecommerce/' + val.id + '">' + val.description + '</a></h4>'
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
