function Category() {
    var table;
    this.init = function () {
        console.log("asdasd")
        table = this.table();
        $("#new").click(this.save);
        $("#edit").click(this.edit);
        $("#btnNew").click(function () {
            $(".input-category").cleanFields();
            $("#modalNew").modal("show");
        });
    }

    this.save = function () {
        toastr.remove();
        var frm = $("#frm");
//        var data = frm.serialize();
        var formData = new FormData($("#frm")[0]);
        var url = "", method = "";
        var id = $("#frm #id").val();
        var msg = '';
        var validate = $(".input-category").validate();
        if (validate.length == 0) {
            if (id == '') {
                msg = "Created Record";
            } else {
                msg = "Edited Record";
            }

            $.ajax({
                url: PATH + "/admin/blog/category",
                method: "POST",
                data: formData,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.success == true) {
                        $("#modalNew").modal("hide");
                        $(".input-category").setFields({data: data});
                        if (data.image != null) {
                            $("#img_category").attr("src", data.image)
                        } else {
                            $("#img_category").attr("src", "")
                        }
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
        var url = id + "/edit";
        $("#modalNew").modal("show");
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $(".input-category").setFields({data: data});
                if (data.image != null) {
                    $("#img_category").attr("src", data.image)
                } else {
                    $("#img_category").val("")
                }
                if (data.image != null) {
                    $("#img_banner").attr("src", data.banner)
                } else {
                    $("#img_banner").val("")
                }
            }
        })
    }

    this.delete = function (id) {
        toastr.remove();
        if (confirm("Deseas eliminar")) {
            var token = $("input[name=_token]").val();
            var url = "/admin/blog/category/" + id;
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
            processing: true,
            serverSide: true,
            ajax: "/api/listCategoryBlog",
            columns: [
                {data: "id"},
                {data: "description"},
                {data: "short_description"},
                {data: "status"},
                {data: "node"},
                {data: "order"},
                {data: "image", render: function (data, type, row) {
                        return (row.image == '') ? '' : "<img src='" + row.image + "' width=80%>";
                    }
                },
                {data: "banner", render: function (data, type, row) {
                        return (row.image == '') ? '' : "<img src='" + row.banner + "' width=80%>";
                    }
                },
                {data: "order"}
            ],
            order: [[1, 'ASC']],
            aoColumnDefs: [
                {
                    aTargets: [0, 1, 2, 3],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.showModal(' + full.id + ')">' + data + '</a>';
                    }
                },
                {
                    targets: [9],
                    searchable: false,
                    mData: null,
                    mRender: function (data, type, full) {
                        return '<button class="btn btn-danger btn-xs" onclick="obj.delete(' + data.id + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                    }
                }
            ],
        });
    }
}

var obj = new Category();
obj.init();