function Autoload() {
    this.init = function () {
        var html = "";
        $.ajax({
            url: PATH+'/getCounter',
            method: 'GET',
            dataType: 'JSON',
            success: function (data) {
                $("#quantityOrders").html(data);
            }
        })

    }
}

var ini = new Autoload();
ini.init();