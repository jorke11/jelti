function Email() {
    var table;
    this.init = function () {
        table = this.table();
        $("#btnNew").click(this.new);
        $("#btnSave").click(this.save);
        $("#tabManagement").click(function () {
            $(".input-email").cleanFields({disabled: true});
        });

        $("#btnModal").click(function () {
            $(".input-detail").cleanFields();
            $("#modalDetail").modal("show");
        })

        $("#newDetail").click(this.saveDetail)


    }

    this.new = function () {
        $(".input-email").cleanFields();
        $("#tblDetail tbody").empty();
    }

    this.saveDetail = function () {
        toastr.remove();
        $("#frmDetail #email_id").val($("#frm #id").val())

        var frm = $("#frmDetail");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frmDetail #id").val();
        var msg = '';

        var validate = $(".input-email").validate();

        if (validate.length == 0) {
            if (id == '') {
                method = 'POST';
                url = "email/detail";
                msg = "Created Record";
            } else {
                method = 'PUT';
                url = "email/detail/" + id;
                msg = "Edited Record";
            }

            $.ajax({
                url: url,
                method: method,
                data: data,
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == true) {
                        obj.loadDetail(data.detail);
                        toastr.success(msg);
                    }
                }, error: function (xhr, ajaxOptions, thrownError) {

                }
            })
        } else {
            toastr.error("Fields Required!");
        }
    }
    this.save = function () {
        toastr.remove();


        var frm = $("#frm");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frm #id").val();
        var msg = '';

        var validate = $(".input-email").validate();

        if (validate.length == 0) {
            if (id == '') {
                method = 'POST';
                url = "email";
                msg = "Created Record";
            } else {
                method = 'PUT';
                url = "email/" + id;
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
                        $(".input-email").setFields({data: data.header, disabled: true});
                        toastr.success(msg);
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
        var url = "/email/" + id + "/edit";

        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $('#myTabs a[href="#management"]').tab('show');
                $(".input-email").setFields({data: data.header})
                obj.loadDetail(data.detail);
            }
        })
    }

    this.loadDetail = function (data) {
        var html = "";

        $.each(data, function (i, val) {
            html += "<tr><td width=80%>" + val.description + '</td>'
            html += '<td ><button class="btn btn-info btn-xs" onclick=obj.editDetail(' + val.id + ')><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>';
            html += '<button class="btn btn-danger btn-xs" onclick=obj.deleteDetail(' + val.id + ')><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></td>';
            html += '</tr>';
        });
        $("#tblDetail tbody").html(html);
    }

    this.editDetail = function (id) {
        $("#modalDetail").modal("show");

        var frm = $("#frmEdit");
        var data = frm.serialize();
        var url = "/email/detail/" + id + "/edit";

        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $(".input-detail").setFields({data: data})

            }
        })
    }

    this.delete = function (id) {
        toastr.remove();
        if (confirm("Deseas eliminar")) {
            var token = $("input[name=_token]").val();
            var url = "/email/" + id;
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
            "ajax": "/api/listEmail",
            columns: [
                {data: "id"},
                {data: "description"},
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
                    targets: [2],
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

var obj = new Email();
obj.init();