function Blog() {
    this.init = function () {
        $('#content').trumbowyg();
        $("#frm #products_id").getSeeker({api: '/api/getProduct', disabled: false});
        $("#linkfb").click(this.openPopUp)
    }

    this.openPopUp = function () {
        var url = $(this).attr("href");
        window.open(url, "Facebook", 'width=560,height=340,toolbar=0,menubar=0,location=0')
        return false;
    }
}

var obj = new Blog();
obj.init();