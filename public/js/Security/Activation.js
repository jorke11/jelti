function User() {

    this.init = function () {
        var data = {};
        $("#btnNew").click(this.new);
        $("#btnSave").click(this.save);
        data.id = $("#frm #id").val();
        data.email = $("#frm #email").val();
        data.role_id = $("#frm #role_id").val();
        data.name = $("#frm #name").val();
        data.last_name = $("#frm #last_name").val();
        data.document = $("#frm #document").val();
        data.phone = $("#frm #phone").val();
        $(".input-user").cleanFields({disabled: false});
        $(".input-user").setFields({data: data});
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
                            console.log("asdasdib")
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
