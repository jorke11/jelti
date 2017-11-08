function Detail() {
    this.init = function () {
        var html = "";
        this.getQuantity();
    }

    this.getQuantity = function () {
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
    this.selectedSubcategory = function (obj) {
        
        $(obj).attr("src",$(obj).attr("src"));
    }

}

var obj = new Detail();
obj.init();
