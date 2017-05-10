function Prospect() {
    var table;
    this.init = function () {
        table = this.table();
        $("#btnNew").click(this.new);
        $("#btnSave").click(this.save);
        $("#tabManagement").click(function () {
            $(".input-prospect").cleanFields({disabled: true});
            $("#btnSave").attr("disabled", true);
        });

        $("#btnConvert").click(this.convert);
    }

    this.convert = function () {
        var obj = {};
        obj.id = $("#frm #id").val();
        if (confirm("Are you sure to convert this prospectus?")) {
            $.ajax({
                url: "/prospect/convert",
                method: 'POST',
                data: obj,
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == true) {
                        toastr.success("Client converted");
                    }

                }
            })
        }
    }

    this.new = function () {
        $(".input-prospect").cleanFields({disabled: false});
        $("#btnSave").attr("disabled", false);
    }

    this.save = function () {
        toastr.remove();
        var frm = $("#frm");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frm #id").val();
        var msg = '';

        var validate = $(".input-prospect").validate();

        if (validate.length == 0) {
            if (id == '') {
                method = 'POST';
                url = "prospect";
                msg = "Created Record";
            } else {
                method = 'PUT';
                url = "prospect/" + id;
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
                        $(".input-prospect").setFields({data: data.header, disabled: true});
                        toastr.success(msg);
                        $("#btnConvert").attr("disabled", false);
                    }
                }, error: function (xhr, ajaxOptions, thrownError) {

                }
            })
        } else {
            toastr.error("Fields Required!");
        }
    }

    this.showModal = function (id) {
        var frm = $("#frmEdit");
        var data = frm.serialize();
        var url = "/prospect/" + id + "/edit";

        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $('#myTabs a[href="#management"]').tab('show');
                $(".input-prospect").setFields({data: data})
                $("#btnConvert").attr("disabled", false);
                $("#btnSave").attr("disabled", false);
            }
        })
    }

    this.delete = function (id) {
        toastr.remove();
        if (confirm("Deseas eliminar")) {
            var token = $("input[name=_token]").val();
            var url = "/prospect/" + id;
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
            "ajax": "/api/listProspect",
            columns: [
                {data: "id"},
                {data: "name"},
                {data: "last_name"},
                {data: "business"},
                {data: "business_name"},
                {data: "email"},
                {data: "position"},
                {data: "commercial_id"},
                {data: "sector_id"},
                {data: "city_id"},
                {data: "phone"}
            ],
            order: [[1, 'ASC']],
            aoColumnDefs: [
                {
                    aTargets: [0, 1, 2, 3, 4, 5, 6],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.showModal(' + full.id + ')">' + data + '</a>';
                    }
                },
                {
                    targets: [11],
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

var obj = new Prospect();
obj.init();