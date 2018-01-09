function Blog() {
    this.init = function () {
        $('#content').trumbowyg();
        $("#frm #products_id").getSeeker({api: '/api/getProduct', disabled: false});


    }
}

var obj = new Blog();
obj.init();