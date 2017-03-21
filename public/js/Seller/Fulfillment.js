function Fulfillment() {
    var table;
    this.init = function () {
        table = this.loadInfo();
        $("#btnNew").click(this.new);
        $("#btnSave").click(this.save);
        $("#btnSaveTarjet").click(this.saveTarjet);
        $("#tabManagement").click(function () {
            var expirate = $("#frm #expiration_date").val();
            $(".input-activity").cleanFields();
        });

        $("#frmMain #month").change(this.loadInfo);

        $("#btnShowModal").click(function () {
            $("#frmModalAdd").modal("show");
            $(".input-commercial").cleanFields();
        });
    }

    this.new = function () {
        $("#frmModal").modal("show");
    }

    this.saveTarjet = function () {
        toastr.remove();
        $("#frmTarjet #year").val($("#frmMain #year").val());
        $("#frmTarjet #month").val($("#frmMain #month").val());

        var frm = $("#frmTarjet");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frmTarjet #id").val();
        var msg = '';

        var validate = $(".input-activity").validate();

        if (validate.length == 0) {
            if (id == '') {
                method = 'POST';
                url = "fulfillment/addTarjet";
                msg = "Created Record";
            } else {
                method = 'PUT';
                url = "fulfillment/" + id;
                msg = "Edited Record";
            }

            $.ajax({
                url: url,
                method: method,
                data: data,
                dataType: 'JSON',
                success: function (data) {
                    if (data.response == true) {
                        toastr.success("Point ok");
                        $("#frmModal").modal("hide");
                        $("#frmMain #id").val(data.data.id);
                        $("#btnNew").attr("disabled", true);
                        $("#btnShowModal").attr("disabled", false);
                        $("#txtTarget").html(data.data.valueFormated);

                    }
                }, error: function (xhr, ajaxOptions, thrownError) {

                }
            })
        } else {
            toastr.error("Fields Required!");
        }
    }

    this.save = function () {
        toastr.remove();
        $("#frm #fulfillment_id").val($("#frmMain #id").val())
        var frm = $("#frm");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frm #id").val();
        var msg = '';

        var validate = $(".input-commercial").validate();

        if (validate.length == 0) {
            if (id == '') {
                method = 'POST';
                url = "fulfillment";
                msg = "Created Record";
            } else {
                method = 'PUT';
                url = "fulfillment/" + id;
                msg = "Edited Record";
            }

            $.ajax({
                url: url,
                method: method,
                data: data,
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == true) {
                        toastr.success(msg);
                    }
                }, error: function (xhr, ajaxOptions, thrownError) {

                }
            })
        } else {
            toastr.error("Fields Required!");
        }
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
        var html = "";
        $.ajax({
            url: '/fulfillment/getInfo/' + $("#year").val() + "/" + $("#month").val(),
            method: "GET",
            dataType: 'JSON',
            success: function (data) {
                if (data.response == false) {
                    $("#btnNew").attr("disabled", false);
                    $("#btnShowModal").attr("disabled", true);
                    $("#txtTarget").html("$ 0");
                    $("#progress_all").css("width", 0).html("0 %");
                    $("#tbl tbody").empty();
                } else {
                    $("#frmMain #id").val(data.data.id);
                    $("#btnNew").attr("disabled", true);
                    $("#btnShowModal").attr("disabled", false);
                    $("#txtTarget").html(data.data.valueFormated);

                    $("#progress_all").css("width", "10%").html("10 %");

                    $.each(data.detail, function (i, val) {
                        html += "<tr><td>" + val.name + "</td><td>" + val.last_name + "</td>";
                        html += '<td><div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:' + val.progress + '%;">' + val.progress + '%</div></div></td></tr>';
                    })
                    $("#tbl tbody").html(html);
                }
            }, error: function (err) {
                toastr.error("No se puede borrra Este registro");
            }
        })
    }

}

var obj = new Fulfillment();
obj.init();