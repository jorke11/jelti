function Blog() {
    this.init = function () {
        $('#content').trumbowyg();
    }
}

var obj = new Blog();
obj.init();