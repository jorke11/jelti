function Page() {
    var id = 1;
    this.init = function () {

        $(".box-client").addClass("back-green");
        $("#type_stakeholder").val(id);
        $("#register").click(function () {
            var elem = $(this);
            elem.attr("disabled", true);
            toastr.remove();
            if (!$("#agree").is(":checked")) {
                toastr.error("acuerdo");
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
                        elem.attr("disabled", false);
                    }
                }, error: function (xhr, ajaxOptions, thrownError) {
                    toastr.error("Problemas con el procesamiento");
                    elem.attr("disabled", false);
                }

            })
        });


        $(".test").smoove({
            offset: '15%',
            // moveX is overridden to -200px for ".bar" object
            moveX: '100px',
            moveY: '100px',
        });

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