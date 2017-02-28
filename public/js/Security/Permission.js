function Permission() {
    var table;
    this.init = function () {
        table = this.listPermission();
        $("#btnNew").click(this.new);
        $("#btnSave").click(this.save);
        $("#btnDelete").click(this.delete);

        $("#parent_id").attr("disabled", true);

        $("#typemenu_id").change(function () {
            if ($(this).val() != 0) {
                $("#parent_id").attr("disabled", false);
            } else {
                $("#parent_id").val(0);
                $("#parent_id").attr("disabled", true);
            }
        });
    }

    this.save = function () {
        toastr.remove();
        var frm = $("#frm");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frm #permission_id").val();
        var msg = '';
        if (id == '') {
            method = 'POST';
            url = "permission";
            msg = "Created Record";
        } else {
            method = 'PUT';
            url = "permission/" + id;
            msg = "Edited Record";
        }
        console.log(data)

        $.ajax({
            url: url,
            method: method,
            data: data,
            dataType: 'JSON',
            success: function (data) {
                if (data.success == 'true') {
                    objP.printList(data.data);
                    toastr.success(msg);
                }
            }
        })
    }

    this.new = function () {
        toastr.remove();
        $(".input-user").val("");
        $("#typemenu_id").val(0);
        $("#parent_id").val(0);

    }

    this.delete = function (id) {
        toastr.remove();
        var id = $("#frm #permission_id").val();
        if (id != '') {
            if (confirm("Deseas eliminar")) {
                var token = $("input[name=_token]").val();
                var url = "/permission/" + id;
                $.ajax({
                    url: url,
                    headers: {'X-CSRF-TOKEN': token},
                    method: "DELETE",
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.success == 'true') {
                            toastr.warning("Ok");
                            objP.printList(data.data);
                        }
                    }, error: function (err) {
                        toastr.error("No se puede borrra Este registro");
                    }
                })
            }
        } else {
            toastr.error("You need selected a record!");
        }
    }

    this.printList = function (data) {
        $("#treeview-container").html("");
        var html = "<ul>";
        $.each(data, function (i, val) {
            if (val.nodes) {
                html += '<li data-value="' + val.permission_id + '"><a href="#" onclick=objP.getMenuId(' + val.permission_id + ');javascript:void(0);> ' + val.title + "</a>";
                html += "<ul>";
                $.each(val.nodes, function (j, value) {
                    html += '<li data-value="' + value.permission_id + '" ><a href="#" onclick=objP.getMenuId(' + value.permission_id + ');javascript:void(0);> ' + value.title + "</li>";
                });
                html += "</ul></li>";
            } else {
                html += '<li><a href="#" onclick=objP.getMenuId(' + val.permission_id + ');javascript:void(0);> ' + val.title + '</li>';
            }
        });
        html += "</ul>";

        $("#treeview-container").html(html);

        $('#treeview-container').treeview({
            debug: false,
        });
    }

    this.getMenuId = function (id) {
        var url = "permission/" + id + "/getMenu";
        $.ajax({
            url: url,
            method: "GET",
            dataType: 'JSON',
            success: function (data) {
                $("#frm #id").val(data.id);
                $(".input-permission").setFields({data: data.header});
                if (data.event == true) {
                    $("#frm #event").prop("checked", true);
                } else {
                    $("#frm #event").prop("checked", false);
                }
            }
        })
    }

    this.listPermission = function () {
        $.ajax({
            url: "/api/listPermission",
            method: "GET",
            dataType: 'JSON',
            success: function (data) {
                objP.printList(data)
            }
        })
    }

}

var objP = new Permission();
objP.init();