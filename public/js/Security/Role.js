function Role() {
    var table;
    this.init = function () {
        table = this.table();
        $("#new").click(this.save);
        $("#edit").click(this.edit);
    }

    this.save = function () {
        var frm = $("#frm");
        var data = frm.serialize();
        var url = frm.attr("action");
        $.ajax({
            url: url,
            method: "POST",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                if (data.success == 'true') {
                    table.ajax.reload();
                    $("#modalNew").modal("toggle");
                    toastr.success("Ok");
                }
            }
        })
    }

    this.edit = function () {
        toastr.remove();
        var frm = $("#frmEdit");
        var data = frm.serialize();
        var url = "role/" + $("#frmEdit #role_id").val();
        $.ajax({
            url: url,
            method: "PUT",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                if (data.success == 'true') {
                    table.ajax.reload();
                    toastr.success("Ok");
                    $("#modalEdit").modal("toggle");
                }
            }
        })
    }

    this.showModal = function (id) {
        var frm = $("#frmEdit");
        var data = frm.serialize();
        var url = "/role/" + id + "/edit";
        $("#modalEdit").modal("show");
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $("#frmEdit #role_id").val(data.role_id);
                $("#frmEdit #description").val(data.description);
            }
        })
    }

    this.delete = function (id) {
        toastr.remove();
        if (confirm("Deseas eliminar")) {
            var token = $("input[name=_token]").val();
            var url = "/role/" + id;
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

    this.table = function () {
        return $('#tbl').DataTable({ 
            "processing": true,
            "serverSide": true,
            "ajax": "/api/listRole",
            columns: [
                {data: "role_id"},
                {data: "description"}
            ],
            order: [[1, 'ASC']],
            aoColumnDefs: [
                {
                    aTargets: [0, 1],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.showModal(' + full.role_id + ')">' + data + '</a>';
                    }
                },
                {
                    targets: [2],
                    searchable: false,
                    "mData": null,
                    "mRender": function (data, type, full) {
                        return '<button class="btn btn-danger btn-xs" onclick="obj.delete(' + data.role_id + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                    }
                }
            ],
        });
    }

}

var obj = new Role();
obj.init();