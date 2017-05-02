function User() {

    this.init = function () {
        $("#btnNew").click(this.new);
        $("#btnSave").click(this.save);
        var email = $("#frm #email").val();
        var id = $("#frm #id").val();
        var role = $("#frm #role_id").val();
        $(".input-user").cleanFields({disabled: false});
        $("#frm #email").val(email);
        $("#frm #id").val(id);
        $("#frm #role_id").val(role);

    }



    this.new = function () {
        $("#btnSave").attr("disabled", false);
        $(".input-user").cleanFields({disabled: false});
    }


    this.save = function () {
        var frm = $("#frm");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frm #id").val();

        var validate = $(".input-user").validate();

        if (validate.length == 0) {
            var msg = '';
            if (id == '') {
                method = 'POST';
                url = "user";
                msg = "Created Record";
            } else {
                method = 'PUT';
                url = "user/" + id;
                msg = "Edited Record";
            }

            $.ajax({
                url: url,
                method: method,
                data: data,
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == true) {
                        toastr.success("Usuario activado");
                        ssetTimeout(function () {
                            location.href = "/logout";
                        }, 900);

                    }
                }
            })
        } else {
            toastr.error("Fields Required!");
        }
    }

}

var obj = new User();
obj.init();
