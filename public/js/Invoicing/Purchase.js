function Purchase() {
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
            var created = $("#frm #created").val();
            $(".input-purchase").cleanFields();
            $("#frm #created").val(created);
            $("#frm #btnSave").attr("disabled", true);
            $("#frm #warehouse_id").getSeeker({default: true, api: '/api/getWarehouse', disabled: true});
            $("#frm #responsible_id").getSeeker({default: true, api: '/api/getResponsable', disabled: true});
            $("#frm #city_id").getSeeker({default: true, api: '/api/getCity', disabled: true});
            $("#frm #branch_id").getSeeker({default: true, api: '/api/getSupplier', disabled: true});
            $.ajax({
                url: 'purchase/1/consecutive',
                method: 'GET',
                dataType: 'JSON',
                success: function (resp) {

                }
            })
        });

        $("#frmDetail #product_id").change(function () {
            $.ajax({
                url: 'departure/' + $(this).val() + '/getDetailProduct',
                method: 'GET',
                dataType: 'JSON',
                success: function (resp) {
                    $("#frmDetail #category_id").val(resp.response.category_id).trigger('change');
                    $("#frmDetail #value").val(resp.response.price_sf)

                    if (resp.quantity > 0) {
                        $("#frmDetail #quantity").attr("disabled", false);
                        $("#newDetail").attr("disabled", false);
                    } else {
                        $("#newDetail").attr("disabled", true);
                        $("#frmDetail #quantity").attr("disabled", true);
                    }

                }
            })
            $("#frm #invoice").select();
        });

        $("#btnmodalDetail").click(function () {
            var expiration_date = $("#frmDetail #expiration_date").val();
            $(".input-detail").cleanFields();
            $("#frmDetail #expiration_date").val(expiration_date);
            $("#modalDetail").modal("show");
            $("#frmDetail #id").val("");
            $("#frmDetail #quantity").val("");
            $("#frmDetail #value").val("");
            $("#frmDetail #lot").val("");

        })

    }

    this.new = function () {

        $(".input-purchase").cleanFields();
        $("#btnSave").attr("disabled", false);
        $("#frm #warehouse_id").getSeeker({default: true, api: '/api/getWarehouse', disabled: true});
        $("#frm #responsible_id").getSeeker({default: true, api: '/api/getResponsable', disabled: true});
        $("#frm #city_id").getSeeker({default: true, api: '/api/getCity', disabled: true});
        $("#frm #created").currentDate();
        $("#tblDetail tbody").empty();
        $("#tblDetail tfoot").empty();
    }

    this.getSupplier = function (id) {
        $.ajax({
            url: 'purchase/' + id + '/getSupplier',
            method: 'GET',
            dataType: 'JSON',
            success: function (resp) {
                $("#frm #name_supplier").val(resp.response.name + " " + resp.response.last_name);
                $("#frm #address_supplier").val(resp.response.address);
                $("#frm #phone_supplier").val(resp.response.phone);
            }
        })
    }

    this.fieldDisabled = function (status) {
        status = status || true;
        $("#frm #warehouse_id").prop("disabled", status);
        $("#frm #responsible_id").prop("disabled", status);
        $("#frm #city_id").prop("disabled", status);
    }

    this.save = function () {
        obj.fieldDisabled();
        $("#frm #warehouse_id").prop("disabled", false);
        $("#frm #responsible_id").prop("disabled", false);
        $("#frm #city_id").prop("disabled", false);
        var frm = $("#frm");
        var data = frm.serialize();
        var url = "", method = "";
        $("#frm #btnSave").attr("disabled", true);
        var id = $("#frm #id").val();
        var msg = '';
        var validate = $(".input-purchase").validate();

        if (validate.length == 0) {
            if (id == '') {
                method = 'POST';
                url = "purchase";
                msg = "Created Record";

            } else {
                method = 'PUT';
                url = "purchase/" + id;
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
        } else {
            toastr.error("input required");
        }
    }

    this.saveDetail = function () {
        $("#frmDetail #purchase_id").val($("#frm #id").val());

        var frm = $("#frmDetail");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frmDetail #id").val();
        var msg = 'Record Detail';

        var validate = $(".input-detail").validate();

        if (validate.length == 0) {

            if (id == '') {
                method = 'POST';
                url = "purchase/storeDetail";
                msg = "Created " + msg;

            } else {
                method = 'PUT';
                url = "purchase/detail/" + id;
                msg = "Edited " + msg;
            }

            $.ajax({
                url: url,
                method: method,
                data: data,
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == true) {
                        toastr.success(msg);
                        $("#btnmodalDetail").attr("disabled", false);
                        obj.printDetail(data);
                        $("#modalDetail").modal("hide");
                    }
                }
            })
        } else {
            toastr.error("input required");
        }
    }

    this.showModal = function (id) {
        var frm = $("#frmEdit");
        var data = frm.serialize();
        var url = "/purchase/" + id + "/edit";
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $('#myTabs a[href="#management"]').tab('show');
                $(".input-purchase").setFields({data: data.header});


                if (data.header.supplier_id != 0) {
                    obj.getSupplier(data.header.supplier_id);
                }
                if (data.header.id != '') {
                    $("#btnmodalDetail").attr("disabled", false);
                }

                obj.printDetail(data);
            }
        })
    }

    this.editDetail = function (id) {
        var frm = $("#frm");
        var data = frm.serialize();
        var url = "/purchase/" + id + "/detail";
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $("#modalDetail").modal("show");
                $(".input-detail").setFields({data: data});
            }
        })
    }

    this.printDetail = function (data) {
        var html = "", total = 0;
        $("#tblDetail tbody").empty();
        $.each(data.detail, function (i, val) {
            total = val.quantity * val.value;

            val.product = (val.product == null) ? '' : val.product
            val.expiration_date = (val.expiration_date == null) ? '' : val.expiration_date
            val.tax = (val.tax == null) ? '' : val.tax
            val.quantity = (val.quantity == null) ? '' : val.quantity

            html += "<tr>";
            html += "<td>" + val.id + "</td>";
            html += "<td>" + val.description + "</td>";
            html += "<td>" + val.product + "</td>";
            html += "<td>" + val.expiration_date + "</td>";
            html += "<td>" + val.tax + "</td>";
            html += "<td>" + val.quantity + "</td>";
            if (val.product_id == null) {
                html += "<td>" + val.totalFormated + "</td>";
            } else {
                html += "<td>0</td>";
            }
            html += "<td>" + val.totalFormated + "</td>";


            if (val.type_nature == 2) {
                html += "<td>" + 0 + "</td>";
                html += "<td>" + val.valueFormated + "</td>";

            } else {
                if (val.product == "") {
                    html += "<td>" + val.valueFormated + "</td>";
                    html += "<td> " + 0 + "</td>";

                } else {
                    html += "<td>" + val.totalFormated + "</td>";
                    html += "<td>$ " + 0 + "</td>";
                }

            }

            if (val.description == 'product') {
                html += '<td><button type="button" class="btn btn-xs btn-primary" onclick=obj.editDetail(' + val.id + ')>Edit</button>';
                html += '<button type="button" class="btn btn-xs btn-warning" onclick=obj.deleteDetail(' + val.id + ')>Delete</button></td>';
            } else {
                html += '<td></td>';
            }

            html += "</tr>";
        });

        $("#tblDetail tbody").html(html);
        $("#tblDetail tfoot").html('<tr><td colspan="8">Total</td><td>' + data.totalDebt + '</td><td>' + data.totalDebt + '</td></tr>');


    }

    this.delete = function (id) {
        toastr.remove();
        if (confirm("Deseas eliminar")) {
            var token = $("input[name=_token]").val();
            var url = "/purchase/" + id;
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
            var url = "/purchase/detail/" + id;
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
            "ajax": "/api/listPurchase",
            columns: [
                {data: "id"},
                {data: "id"},
                {data: "description"},
                {data: "created"},
                {data: "invoice"},
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

var obj = new Purchase();
obj.init();