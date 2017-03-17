function Fulfillment() {
    var table;
    this.init = function () {
        table = this.loadInfo();
        $("#btnNew").click(this.new);
        $("#btnSave").click(this.save);
        $("#tabManagement").click(function () {
            var expirate = $("#frm #expiration_date").val();
            $(".input-activity").cleanFields();
        });
    }

    this.save = function () {
        toastr.remove();


        var frm = $("#frm");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frm #id").val();
        var msg = '';

        var validate = $(".input-activity").validate();

        if (validate.length == 0) {
            if (id == '') {
                method = 'POST';
                url = "activity";
                msg = "Created Record";
            } else {
                method = 'PUT';
                url = "activity/" + id;
                msg = "Edited Record";
            }

            $.ajax({
                url: url,
                method: method,
                data: data,
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == true) {
                        table.ajax.reload();
                        $(".input-product").setFields({data: data.header});
                        toastr.success(msg);
                    }
                }, error: function (xhr, ajaxOptions, thrownError) {

                }
            })
        } else {
            toastr.error("Fields Required!");
        }
    }

    this.showModal = function (id) {
        var frm = $("#frmEdit");
        var data = frm.serialize();
        var url = "/activity/" + id + "/edit";

        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $('#myTabs a[href="#management"]').tab('show');
                $(".input-activity").setFields({data: data})
            }
        })
    }

    this.delete = function (id) {
        toastr.remove();
        if (confirm("Deseas eliminar")) {
            var token = $("input[name=_token]").val();
            var url = "/activity/" + id;
            $.ajax({
                url: url,
                headers: {'X-CSRF-TOKEN': token},
                method: "DELETE",
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == 'true') {
                        table.ajax.reload();
                        toastr.warning("Ok");
                    }
                }, error: function (err) {
                    toastr.error("No se puede borrra Este registro");
                }
            })
        }
    }

    this.loadInfo = function () {
        $.ajax({
            url: '/fulfillment/getInfo/' + $("#year").val() + "/" + $("#month").val(),
            method: "GET",
            dataType: 'JSON',
            success: function (data) {
                if (data.response == false) {
                    $("#btnNew").attr("disabled", false);
                    $("#txtTarget").html("$ 0");
                    $("#txtFulfillment").html("$ 0");
                    $("#txtDeficit").html("0 %");
                } else {
                    $("#btnNew").attr("disabled", true);
                }
            }, error: function (err) {
                toastr.error("No se puede borrra Este registro");
            }
        })
    }

}

var obj = new Fulfillment();
obj.init();