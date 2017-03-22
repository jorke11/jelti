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
            $("#txtMax").empty();
            $.ajax({
                url: "fulfillment/getMax/" + $("#frmMain #id").val(),
                method: "get",
                dataType: 'JSON',
                success: function (data) {
                    $("#txtMax").html(data.max)
                }
            })
        });
    }

    this.new = function () {
        $("#frmModal").modal("show");
        $("#frmTarjet #value").empty();
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
                    console.log(xhr)
                    console.log(ajaxOptions)
                    console.log(thrownError)
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
                        obj.setTable(data.detail);
                    }
                }, error: function (xhr, ajaxOptions, thrownError) {
                    toastr.error(xhr.responseJSON.msg)
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

    this.setTable = function (detail) {
        var html = "";
        $.each(detail, function (i, val) {
            html += "<tr style='cursor:pointer' onclick=obj.showDetail(" + val.user_id + ")>";
            html += "<td>" + val.name + "</td><td>" + val.last_name + "</td><td>" + val.value + "</td><td>" + val.valueTotalFormated + "</td>";
            html += '<td><div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:' + val.progress + '%;">' + val.progress + '%</div></div></td></tr>';
        })
        $("#tbl tbody").html(html);
    }

    this.showDetail = function (user_id) {
        $("#frmModalDetail").modal("show");
        $.ajax({
            url: "/fulfillment/getSales/" + user_id,
            method: 'get',
            dataType: "json",
            success: function (data) {

            }
        })
    }

    this.loadInfo = function () {

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
                    $("#progress_all").css("width", data.data.valueFormatedPending + "%").html(data.data.valueFormatedPending + " %");

                    obj.setTable(data.detail);
                }
            }, error: function (err) {
                toastr.error("No se puede borrra Este registro");
            }
        })
    }

}

var obj = new Fulfillment();
obj.init();