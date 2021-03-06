function Category() {
    var table;
    this.init = function () {
        table = this.table();
        $("#btnNew").click(this.new);
        $("#btnSave").click(this.save);
        $("#btnNew").click(function () {
            $(".input-category").cleanFields();
            $("#modalNew").modal("show");
        });
    }

    this.new = function () {
        $(".input-characteristic").cleanFields();
    }

    this.save = function () {
        toastr.remove();
        var frm = $("#frm");
        var data = frm.serialize();
        var formData = new FormData($("#frm")[0]);
        var url = "", method = "";
        var id = $("#frm #id").val();
        var msg = '';

        var validate = $(".input-characteristic").validate();

        if (validate.length == 0) {
            if (id == '') {
                method = 'POST';
                url = "characteristic";
                msg = "Created Record";
            } else {
                method = 'PATCH';
                url = "characteristic/" + id;
                msg = "Edited Record";
            }

            $.ajax({
                url: "characteristic",
                method: "POST",
                data: formData,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.success == true) {
                        $("#modalNew").modal("hide");
                        table.ajax.reload();
                        toastr.success(msg);
                    }
                }
            })
        } else {
            toastr.error("Fields Required!");
        }
    }

    this.showModal = function (id) {
        var frm = $("#frmEdit");
        var data = frm.serialize();
        var url = "/characteristic/" + id + "/edit";
        $("#modalNew").modal("show");
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $(".input-characteristic").setFields({data: data});
                
                if (data.img != null) {
                    $("#img_category").attr("src", data.img)
                } else {
                    $("#img_category").attr("src", "")
                }
                if (data.alternative != null) {
                    $("#img_alternative").attr("src", data.alternative)
                } else {
                    $("#img_alternative").attr("src", "")
                }
            }
        })
    }

    this.delete = function (id) {
        toastr.remove();
        if (confirm("Deseas eliminar")) {
            var token = $("input[name=_token]").val();
            var url = "/characteristic/" + id;
            $.ajax({
                url: url,
                headers: {'X-CSRF-TOKEN': token},
                method: "DELETE",
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == true) {
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
            "ajax": "/api/listCharacterist",
            columns: [
                {data: "id"},
                {data: "description"},
                {data: "status_id", render: function (data, type, row) {
                        return (row.status_id == 1) ? 'Enable' : 'Disabled';
                    }
                },
                {data: "image", render: function (data, type, row) {
                        return (row.img == '') ? '' : "<img src='" + row.img + "' width=70%>";
                    }
                },
                {data: "alternative", render: function (data, type, row) {
                        return (row.alternative == '') ? '' : "<img src='" + row.alternative + "' width=70%>";
                    }
                },
            ],
            order: [[1, 'ASC']],
            aoColumnDefs: [
                {
                    aTargets: [0, 1],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.showModal(' + full.id + ')">' + data + '</a>';
                    }
                },
                {
                    targets: [5],
                    searchable: false,
                    "mData": null,
                    "mRender": function (data, type, full) {
                        return '<button class="btn btn-danger btn-xs" onclick="obj.delete(' + data.id + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                    }
                }
            ],
        });
    }

}

var obj = new Category();
obj.init();