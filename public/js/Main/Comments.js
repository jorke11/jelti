function Comments() {
    this.init = function () {
        $.ajax({
            url: '/comments/list',
            method: "get",
            dataType: 'json',
            success: function (data) {
                console.log(data)
            }
        })
    }
}

var obj = new Comments();

obj.init();

