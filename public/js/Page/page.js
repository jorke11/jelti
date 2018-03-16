function Page() {
    var id = 1;
    this.init = function () {
        $(window).scroll(function () {

            if ($(this).scrollTop() > 0) {
                $('.go-top').slideDown(300);
            } else {
                $('.go-top').slideUp(300);
            }
        });

        $('.go-top').click(function () {
            $('body, html').animate({
                scrollTop: '0px'
            }, 300);
        });



        $('.input-number').on('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        $(".box-client").addClass("back-green");
        $("#type_stakeholder").val(id);
        $("#register").click(function () {
            var elem = $(this);
            elem.attr("disabled", true);
            toastr.remove();
            if (!$("#agree").is(":checked")) {
                toastr.error("Necesita estar de acuerdo con los terminos Legales");
                elem.attr("disabled", false);
                return false;
            }

            if (isNaN($("#phone").val()) != false) {
                toastr.error("Numero de telefono");
                elem.attr("disabled", false);
                return false;
            }

            var form = $("#frm");


            $.ajax({
                url: 'newVisitan',
                method: 'POST',
                data: form.serialize(),
                success: function (data) {
                    if (data.status == true) {
                        toastr.success("Pronto te estaremos contactando");
                        $(".in-page").cleanFields();
                        $("#myModal").modal("hide");
                    }
                }, error: function (xhr, ajaxOptions, thrownError) {
                    toastr.error(xhr.responseJSON.msg);
                    elem.attr("disabled", false);
                }

            })

            elem.attr("disabled", false);
        });


        $(".test").smoove({
            offset: '15%',
            // moveX is overridden to -200px for ".bar" object
            moveX: '100px',
            moveY: '100px',
        });

    }

    this.redirectProduct = function (url) {
        window.location = PATH + "/productDetail/" + url;
    }

    this.openModal = function (modal) {
        $("#" + modal).modal("show");
    }

    this.search = function () {
//        location.href = PATH + "/search/" + $("#formSearch #search").val();
        $("#formSearch").submit();
    }

    this.stakeholder = function (elem_id, elem) {
        elem_id = elem_id | 1;

        if (elem_id == 1) {
            $(".box-supplier").removeClass("back-green")
            $(elem).addClass("back-green");
        } else {
            $(".box-client").removeClass("back-green")
            $(elem).addClass("back-green");
        }

        id = elem_id;
        $("#type_stakeholder").val(id);
    }

}

objPage = new Page();
objPage.init();