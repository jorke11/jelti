function Purchage() {
    var table;
    this.init = function () {
        table = this.table();
        $("#btnNew").click(this.new);
        $("#btnSave").click(this.save);
        $("#newDetail").click(this.saveDetail);
        $(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii'});
        $("#edit").click(this.edit);

        $("#tabManagement").click(function () {
            $('#myTabs a[href="#management"]').tab('show');
        });

        $("#supplier_id").change(function () {
            if ($(this).val() != 0) {
                obj.getSupplier($(this).val());
            } else {
                $("#frm #name_supplier").val("");
                $("#frm #address_supplier").val("");
                $("#frm #phone_supplier").val("");
            }
        });

        $("#insideManagement").click(function () {
            $(".input-purchage").cleanFields();
            $("#frm #warehouse_id").getSeeker({default: true, api: '/api/getWarehouse', disabled: true});
            $("#frm #responsable_id").getSeeker({default: true, api: '/api/getResponsable', disabled: true});
            $("#frm #city_id").getSeeker({default: true, api: '/api/getCity', disabled: true});
            $("#frm #branch_id").getSeeker({default: true, api: '/api/getSupplier', disabled: true});
            $.ajax({
                url: 'purchage/1/consecutive',
                method: 'GET',
                dataType: 'JSON',
                success: function (resp) {

                }
            })
        });

        $("#btnmodalDetail").click(function () {
            $.ajax({
                url: 'purchage/' + $("#frm #supplier_id").val() + '/getProducts',
                method: 'GET',
                dataType: 'JSON',
                success: function (resp) {

                }
            })
            $("#modalDetail").modal("show");
            $("#frmDetail #id").val("");
            $("#frmDetail #quantity").val("");
            $("#frmDetail #value").val("");
            $("#frmDetail #lot").val("");
        })

    }

    this.getSupplier = function (id) {
        $.ajax({
            url: 'purchage/' + id + '/getSupplier',
            method: 'GET',
            dataType: 'JSON',
            success: function (resp) {
                $("#frm #name_supplier").val(resp.response.name + " " + resp.response.last_name);
                $("#frm #address_supplier").val(resp.response.address);
                $("#frm #phone_supplier").val(resp.response.phone);
            }
        })
    }

    this.save = function () {
        $("#frm #warehouse_id").prop("disabled", false);
        $("#frm #responsable_id").prop("disabled", false);
        $("#frm #city_id").prop("disabled", false);
        var frm = $("#frm");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frm #id").val();
        var msg = '';
        if (id == '') {
            method = 'POST';
            url = "purchage";
            msg = "Created Record";

        } else {
            method = 'PUT';
            url = "purchage/" + id;
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
        $("#frmDetail #purchage_id").val($("#frm #id").val());

        var frm = $("#frmDetail");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frmDetail #id").val();
        var msg = 'Record Detail';
        if (id == '') {
            method = 'POST';
            url = "purchage/storeDetail";
            msg = "Created " + msg;

        } else {
            method = 'PUT';
            url = "purchage/detail/" + id;
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
        var url = "/purchage/" + id + "/edit";
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $('#myTabs a[href="#management"]').tab('show');
                $(".input-purchage").setFields({data: data.header});


                if (data.header.supplier_id != 0) {
                    obj.getSupplier(data.header.supplier_id);
                }
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
        var url = "/purchage/" + id + "/detail";
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
        var html = "", total = 0, debt = 0, credit = 0;
        $("#tblDetail tbody").empty();
        $.each(data, function (i, val) {
            total = val.quantity * val.value;

            val.product_id = (val.product_id == null) ? '' : val.product_id
            val.expiration_date = (val.expiration_date == null) ? '' : val.expiration_date
            val.tax = (val.tax == null) ? '' : val.tax
            val.quantity = (val.quantity == null) ? '' : val.tax

            html += "<tr>";
            html += "<td>" + val.id + "</td>";
            html += "<td>" + val.description + "</td>";
            html += "<td>" + val.account_id + "</td>";
            html += "<td>" + val.product_id + "</td>";
            html += "<td>" + val.expiration_date + "</td>";
            html += "<td>" + val.tax + "</td>";
            html += "<td>" + val.quantity + "</td>";
            html += "<td>" + total + "</td>";

            if (val.account_id == 2) {
                html += "<td>" + 0 + "</td>";
                html += "<td>" + val.value + "</td>";
                credit += parseFloat(val.value);
            } else {
                if (val.product_id == '') {
                    html += "<td>" + val.value + "</td>";
                    html += "<td>" + 0 + "</td>";
                    debt += parseFloat(val.value);

                } else {
                    debt += parseFloat(total);
                    html += "<td>" + total + "</td>";
                    html += "<td>" + 0 + "</td>";
                }

            }

            html += '<td><button type="button" class="btn btn-xs btn-primary" onclick=obj.editDetail(' + val.id + ')>Edit</button>';
            html += '<button type="button" class="btn btn-xs btn-warning" onclick=obj.deleteDetail(' + val.id + ')>Delete</button></td>';
            html += "</tr>";
        });

        $("#tblDetail tbody").html(html);
        $("#tblDetail tfoot").html('<tr><td colspan="8">Total</td><td>' + Math.round(debt) + '</td><td>' + Math.round(credit) + '</td></tr>');


    }

    this.delete = function (id) {
        toastr.remove();
        if (confirm("Deseas eliminar")) {
            var token = $("input[name=_token]").val();
            var url = "/purchage/" + id;
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
            var url = "/purchage/detail/" + id;
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


    this.table = function () {
        return $('#tbl').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/api/listPurchage",
            columns: [
                {data: "id"},
                {data: "id"},
                {data: "description"},
                {data: "created"},
                {data: "avoice"},
                {data: "warehouse_id"},
                {data: "city_id"},
                {data: "status_id"},
            ],
            order: [[1, 'ASC']],
            aoColumnDefs: [
                {
                    aTargets: [0, 1, 2, 3, 4, 5, 6, 7],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.showModal(' + full.id + ')">' + data + '</a>';
                    }
                },
                {
                    targets: [8],
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

var obj = new Purchage();
obj.init();