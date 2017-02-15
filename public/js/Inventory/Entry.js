function Entry() {
    var table;
    this.init = function () {
        table = this.table();
        $("#new").click(this.save);
        $("#newDetail").click(this.saveDetail);
        $(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii'});
        $("#edit").click(this.edit);
        $("#tabManagement").click(function () {
//            $(".input-entry").val("");
            $('#myTabs a[href="#management"]').tab('show');
        });

        $("#insideManagement").click(function () {
//            $(".input-entry").val("");
            $.ajax({
                url: 'entry/1/consecutive',
                method: 'GET',
                dataType: 'JSON',
                success: function (resp) {

                }
            })
        });

        $("#btnmodalDetail").click(function () {
            $("#modalDetail").modal("show");
            $("#frmDetail #id").val("");
            $("#frmDetail #quantity").val("");
            $("#frmDetail #value").val("");
            $("#frmDetail #lot").val("");
        })
    }

    this.save = function () {
        var frm = $("#frm");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frm #id").val();
        var msg = '';
        if (id == '') {
            method = 'POST';
            url = "entry";
            msg = "Created Record";

        } else {
            method = 'PUT';
            url = "entry/" + id;
            msg = "Edited Record";
        }

        $.ajax({
            url: url,
            method: method,
            data: data,
            dataType: 'JSON',
            success: function (data) {
                if (data.success == 'true') {
                    $("#frm #id").val(data.data.id);
                    table.ajax.reload();
                    toastr.success(msg);
                    $("#btnmodalDetail").attr("disabled", false);
                }
            }
        })
    }

    this.saveDetail = function () {
        $("#frmDetail #entry_id").val($("#frm #id").val());
        var frm = $("#frmDetail");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frmDetail #id").val();
        var msg = 'Record Detail';
        if (id == '') {
            method = 'POST';
            url = "entry/storeDetail";
            msg = "Created " + msg;

        } else {
            method = 'PUT';
            url = "entry/detail/" + id;
            msg = "Edited " + msg;
        }

        $.ajax({
            url: url,
            method: method,
            data: data,
            dataType: 'JSON',
            success: function (data) {
                if (data.success == 'true') {
                    toastr.success(msg);
                    $("#btnmodalDetail").attr("disabled", false);
                    obj.printDetail(data.data);
                    $("#modalDetail").modal("hide");
                }
            }
        })
    }

    this.showModal = function (id) {
        var frm = $("#frmEdit");
        var data = frm.serialize();
        var url = "/entry/" + id + "/edit";
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $('#myTabs a[href="#management"]').tab('show');
                $("#frm #id").val(data.header.id);
                $("#frm #created").val(data.header.created);
                $("#frm #responsable_id").val(data.header.responsable_id);
                $("#frm #consecutive").val(data.header.consecutive);
                $("#frm #description").val(data.header.description);
                $("#frm #bill").val(data.header.bill);
                $("#frm #warehouse_id").val(data.header.warehouse_id);
                $("#frm #user_create_id").val(data.header.user_create_id);
                if (data.header.id != '') {
                    $("#btnmodalDetail").attr("disabled", false);
                }

                obj.printDetail(data.detail);
            }
        })
    }

    this.editDetail = function (id) {
        var frm = $("#frm");
        var data = frm.serialize();
        var url = "/entry/" + id + "/detail";
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $("#modalDetail").modal("show");
                $("#frmDetail #id").val(data.id);
                $("#frmDetail #supplier_id").val(data.supplier_id);
                $("#frmDetail #mark_id").val(1);
                $("#frmDetail #quantity").val(data.quantity);
                $("#frmDetail #value").val(data.value);
                $("#frmDetail #lot").val(1);
                $("#frmDetail #category_id").val(data.category_id);
                $("#frmDetail #expiration_date").val(data.expiration_date);
            }
        })
    }

    this.printDetail = function (data) {
        var html = "";
        $("#tblDetail tbody").empty();
        $.each(data, function (i, val) {
            html += "<tr>";
            html += "<td>" + val.id + "</td>";
            html += "<td>" + val.supplier_id + "</td>";
            html += "<td>" + val.product_id + "</td>";
            html += "<td>" + val.product_id + "</td>";
            html += "<td>" + val.quantity + "</td>";
            html += "<td>" + val.value + "</td>";
            html += "<td>" + val.expiration_date + "</td>";
            html += '<td><button type="button" class="btn btn-xs btn-primary" onclick=obj.editDetail(' + val.id + ')>Edit</button>';
            html += '<button type="button" class="btn btn-xs btn-warning" onclick=obj.deleteDetail(' + val.id + ')>Delete</button></td>';
            html += "</tr>";
        });

        $("#tblDetail tbody").html(html);
    }

    this.delete = function (id) {
        toastr.remove();
        if (confirm("Deseas eliminar")) {
            var token = $("input[name=_token]").val();
            var url = "/entry/" + id;
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

    this.deleteDetail = function (id) {
        toastr.remove();
        if (confirm("Do you want delete this record?")) {
            var token = $("input[name=_token]").val();
            var url = "/entry/detail/" + id;
            $.ajax({
                url: url,
                headers: {'X-CSRF-TOKEN': token},
                method: "DELETE",
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == 'true') {
                        toastr.warning("Record deleted");
                        obj.printDetail(data.data);
                    }
                }, error: function (err) {
                    toastr.error("No se puede borrra Este registro");
                }
            })
        }
    }

    this.tableDetail = function () {
        return $('#tbl').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/api/listEntry",
            columns: [
                {data: "id"},
                {data: "consecutive"},
                {data: "date"},
                {data: "bill"},
                {data: "warehouse"},
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
                    targets: [4],
                    searchable: false,
                    "mData": null,
                    "mRender": function (data, type, full) {
                        return '<button class="btn btn-danger" onclick="obj.delete(' + data.id + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                    }
                }
            ],
        });
    }
    this.table = function () {
        return $('#tbl').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/api/listEntry",
            columns: [
                {data: "id"},
                {data: "consecutive"},
                {data: "description"},
                {data: "created"},
                {data: "bill"},
                {data: "warehouse_id"},
            ],
            order: [[1, 'ASC']],
            aoColumnDefs: [
                {
                    aTargets: [0, 1, 2, 3, 4],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.showModal(' + full.id + ')">' + data + '</a>';
                    }
                },
                {
                    targets: [6],
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

var obj = new Entry();
obj.init();