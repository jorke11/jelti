function Contact() {
    var table;
    this.init = function () {
        table = this.table();
        $("#btnNew").click(this.new);
        $("#btnSave").click(this.save);
        $("#tabManagement").click(function () {
            $(".input-contact").cleanFields({disabled: true});
        });
    }

    this.new = function () {
        $("#btnSave").attr("disabled", false);
        $(".input-contact").cleanFields({disabled: false});
    }

    this.save = function () {
        toastr.remove();


        var frm = $("#frm");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frm #id").val();
        var msg = '';

        var validate = $(".input-contact").validate();

        if (validate.length == 0) {
            if (id == '') {
                method = 'POST';
                url = "contact";
                msg = "Created Record";
            } else {
                method = 'PUT';
                url = "contact/" + id;
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
                        $(".input-contact").setFields({data: data.header, disabled: true});
                        toastr.success(msg);
                    }
                }, error: function (xhr, ajaxOptions, thrownError) {
                    toastr.error("Wrong");
                }
            })
        } else {
            toastr.error("Fields Required!");
        }
    }

    this.showModal = function (id) {
        var frm = $("#frmEdit");
        var data = frm.serialize();
        var url = "/contact/" + id + "/edit";

        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $('#myTabs a[href="#management"]').tab('show');
                $(".input-contact").setFields({data: data});
                $("#btnSave").attr("disabled",false);
            }
        })
    }

    this.delete = function (id) {
        toastr.remove();
        if (confirm("Deseas eliminar")) {
            var token = $("input[name=_token]").val();
            var url = "/contact/" + id;
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
            "ajax": "/api/listContact",
            columns: [
                {data: "id"},
                {data: "name"},
                {data: "last_name"},
                {data: "stakeholder_id"},
                {data: "commercial_id"},
                {data: "mobile"},
                {data: "birth_date"},
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
                    targets: [7],
                    searchable: false,
                    "mData": null,
                    "mRender": function (data, type, full) {
                        return '<button class="btn btn-danger btn-xs" onclick="obj.delete(' + full.id + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                    }
                }
            ],
        });
    }

}

var obj = new Contact();
obj.init();