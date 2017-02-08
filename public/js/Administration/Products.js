function Products() {
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
        var frm = $("#frmEditSupplier");
        var data = frm.serialize();
        var url = "supplier/" + $("#frmEditSupplier #id").val();
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
        var frm = $("#frm");
        var data = frm.serialize();
        var url = "/product/" + id + "/edit";
        $("#modalEdit").modal("show");
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $("#frmEdit #id").val(data.id);
                $("#frmEdit #name").val(data.name);
                $("#frmEdit #last_name").val(data.last_name);
                $("#frmEdit #document").val(data.document);
                $("#frmEdit #address").val(data.address);
                $("#frmEdit #phone").val(data.phone);
                $("#frmEdit #name_contact").val(data.name_contact);
                $("#frmEdit #phone_contact").val(data.phone_contact);
                $("#frmEdit #type_regimen_id").val(data.type_regimen_id);
                $("#frmEdit #type_person_id").val(data.type_person_id);
            }
        })
    }

    this.delete = function (id) {
        toastr.remove();
        if (confirm("Deseas eliminar")) {
            var token = $("input[name=_token]").val();
            var url = "/product/" + id;
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
        return $('#tblProducts').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/api/listProducts",
            columns: [
                {data: "id"},
                {data: "name"},
                {data: "last_name"},
                {data: "document"},
                {data: "address"},
                {data: "type_person_id"},
                {data: "type_regimen_id"},
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
                    mData: null,
                    mRender: function (data, type, full) {
                        return '<button class="btn btn-danger" onclick="obj.delete(' + data.id + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                    }
                }
            ],
        });
    }

}

var obj = new Products();
obj.init();
