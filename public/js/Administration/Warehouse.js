function Warehouse() {
    var table;
    this.init = function () {
        table = this.table();
        $("#new").click(this.save);
        $("#edit").click(this.edit);
        $("#btnOpenModal").click(function () {
            $("#modalEdit").modal("hide");
            $("#modalNew").modal("show");
            $("#frm #id").val("");
            $("#frm #description").val("");
            $("#frm #address").val("");
        });

    }

    this.save = function () {
        var frm = $("#frm");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frm #id").val();
        var msg = '';
        if (id == '') {
            method = 'POST';
            url = "warehouse";
            msg = "Created Record";

        } else {
            method = 'PUT';
            url = "warehouse/" + id;
            msg = "Edited Record";
        }

        $.ajax({
            url: url,
            method: method,
            data: data,
            dataType: 'JSON',
            success: function (data) {
                if (data.success == 'true') {
                    table.ajax.reload();
                    toastr.success(msg);
                    $("#modalNew").modal("hide");

                }
            }
        })
    }

    this.showModal = function (id) {
        var frm = $("#frmEdit");
        var data = frm.serialize();
        var url = "/warehouse/" + id + "/edit";
        $("#modalNew").modal("show");
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $("#frm #id").val(data.id);
                $("#frm #description").val(data.description);
                $("#frm #address").val(data.address);
            }
        })
    }

    this.delete = function (id) {
        toastr.remove();
        if (confirm("Deseas eliminar")) {
            var token = $("input[name=_token]").val();
            var url = "/warehouse/" + id;
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
            "ajax": "/api/listWarehouse",
            columns: [
                {data: "id"},
                {data: "description"},
                {data: "address"}
            ],
            order: [[1, 'ASC']],
            aoColumnDefs: [
                {
                    aTargets: [0, 1, 2],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.showModal(' + full.id + ')">' + data + '</a>';
                    }
                },
                {
                    targets: [3],
                    searchable: false,
                    "mData": null,
                    "mRender": function (data, type, full) {
                        return '<button class="btn btn-danger" onclick="obj.delete(' + data.id + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                    }
                }
            ],
        });
    }

}

var obj = new Warehouse();
obj.init();