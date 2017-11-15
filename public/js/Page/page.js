function Page() {
    var id = 1;
    this.init = function () {
        $(".box-client").addClass("back-green");
        $("#frm").submit(function () {
            if ($("#agree").is(":checked")) {
                toastr.error("acuerdo");
                return false;
            }

            if (NaN($("#phone"))) {
                toastr.error("Numero de telefono");
                return false;
            }

            return false;
        });
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

    }

}

objPage = new Page();
objPage.init();