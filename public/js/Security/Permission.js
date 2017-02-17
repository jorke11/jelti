function Permission() {
    var table;
    this.init = function () {
        table = this.table();
        $("#new").click(this.save);
        $("#edit").click(this.edit);
        $("#frm #parent_id").change(function () {
            if($(this).val()==1){
                $("#fieldParent").removeClass("hidden");
            }else{
                $("#fieldParent").addClass("hidden");
            }
        });
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
        var url = "permission/" + $("#frmEdit #id").val();
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
        var url = "/permission/" + id + "/edit";
        $("#modalEdit").modal("show");
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $("#frmEdit #id").val(data.id);
                $("#frmEdit #description").val(data.description);
                $("#frmEdit #controller").val(data.controller);
                $("#frmEdit #title").val(data.title);
                $("#frmEdit #alternative").val(data.alternative);
                if (data.event == true) {
                    $("#frmEdit #event").prop("checked", true);
                } else {
                    $("#frmEdit #event").prop("checked", false);
                }

            }
        })
    }

    this.delete = function (id) {
        toastr.remove();
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
            "ajax": "/api/listPermission",
            columns: [
                {data: "id"},
                {data: "parent_id"},
                {data: "description"},
                {data: "controller"},
                {data: "title"},
                {data: "alternative"},
                {data: "event"},
            ],
            order: [[1, 'ASC']],
            aoColumnDefs: [
                {
                    aTargets: [0, 1, 2, 3, 4, 5],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.showModal(' + full.id + ')">' + data + '</a>';

                    }
                },
                {
                    targets: [7],
                    searchable: false,
                    "mData": null,
                    "mRender": function (data, type, full) {
//                        return '<button class="btn btn-danger btn-xs" onclick="obj.delete(' + data.id + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                        return '<button class="btn btn-danger btn-xs" onclick="obj.delete()"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                    }
                }
            ],
        });
    }

}

var obj = new Permission();
obj.init();