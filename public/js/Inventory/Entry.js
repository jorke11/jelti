function Entry() {
    var table;
    this.init = function () {
        table = this.table();

        $("#btnNew").click(this.new);
        $("#btnSave").click(this.save);
        $("#newDetail").click(this.saveDetail);
        $("#btnSend").click(this.send);
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
            $(".input-entry").cleanFields();

            $("#btnSave").attr("disabled", true);
            $("#btnSend").attr("disabled", true);
            $("#frm #created").val(created);
            $("#frm #consecutive").val(1);
            $("#frm #supplier_id").prop("disabled", true);
            $("#frm #status_id").prop("disabled", true);
            $("#frm #warehouse_id").getSeeker({default: true, api: '/api/getWarehouse', disabled: true});
            $("#frm #responsible_id").getSeeker({default: true, api: '/api/getResponsable', disabled: true});
            $("#frm #city_id").getSeeker({default: true, api: '/api/getCity', disabled: true});
            obj.consecutive();
        });

        $("#btnmodalDetail").click(function () {
            $("#modalDetail").modal("show");
            var expiration_date = $("#frmDetail #expiration_date").val();
            console.log(expiration_date)
            $(".input-detail").cleanFields();
            $("#frmDetail #expiration_date").val(expiration_date);
            $("#frmDetail #product_id").val(0).getSeeker({filter: {supplier_id: $("#frm #supplier_id").val()}});

            $("#frmDetail #id").val("");
            $("#frmDetail #quantity").val("");
            $("#frmDetail #value").val("");
            $("#frmDetail #lot").val("");
        })

        $("#frmDetail #product_id").on("change", function () {
            $.ajax({
                url: 'entry/' + $(this).val() + '/getDetailProduct',
                method: 'GET',
                dataType: 'JSON',
                success: function (resp) {
                    $("#frmDetail #category_id").val(resp.response.id).trigger('change');

                    $("#frmDetail #value").val(resp.response.price_sf);
                    $("#frmDetail #value").inputmask();
                }
            })
        });

    }

    this.consecutive = function () {
        $.ajax({
            url: 'entry/1/consecutive',
            method: 'GET',
            dataType: 'JSON',
            success: function (resp) {
                $("#frm #consecutive").val(resp.response);
            }
        })
    }

    this.new = function () {
        toastr.remove();
        var created = $("#frm #created").val();
        $(".input-entry").cleanFields();

        $("#frm #created").val(created);
        $(".input-fillable").prop("readonly", false);
        $("#tblDetail tbody").empty();
        $("#tblDetail tfoot").empty();
        $("#frm #status_id").val(1).trigger("change").prop("disabled", true);
        $("#frm #supplier_id").prop("disabled", false);
        $("#btnSave").prop("disabled", false);
        $("#frm #warehouse_id").getSeeker({default: true, api: '/api/getWarehouse', disabled: true});
        $("#frm #responsible_id").getSeeker({default: true, api: '/api/getResponsable', disabled: true});
        $("#frm #city_id").getSeeker({default: true, api: '/api/getCity', disabled: true});
        obj.consecutive();
    }

    this.send = function () {
        toastr.remove();

        var obj = {};
        obj.id = $("#frm #id").val()
        $.ajax({
            url: 'entry/setPurchase',
            method: 'POST',
            data: obj,
            dataType: 'JSON',
            success: function (resp) {
                if (resp.success == true) {
                    toastr.success("Sended");
                    $(".input-entry").setFields({data: resp.header, disabled: true});
                    $("#btnmodalDetail").attr("disabled", true);
                } else {
                    toastr.warning(resp.msg);
                }
            }
        })

    }

    this.getSupplier = function (id) {
        $.ajax({
            url: 'entry/' + id + '/getSupplier',
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
        $("#frm #responsible_id").prop("disabled", false);
        $("#frm #city_id").prop("disabled", false);

        var validate = $(".input-entry").validate();

        if (validate.length == 0) {
            var frm = $("#frm");
            var data = frm.serialize();
            var url = "entry", method = "";
            var id = $("#frm #id").val();
            var msg = '';
            if (id == '') {
                method = 'POST';
                msg = "Created Record";

            } else {
                method = 'PUT';
                url += "/" + id;
                msg = "Edited Record";
            }

            $.ajax({
                url: url,
                method: method,
                data: data,
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == true) {
                        $("#frm #id").val(data.data.id);
                        table.ajax.reload();
                        toastr.success(msg);
                        $("#btnmodalDetail").attr("disabled", false);
                        $("#btnSend").prop("disabled", false);
                        $(".btnEditClass").prop("disabled", false);

                    }
                }
            })
        } else {
            toastr.error("Input required");
        }
    }

    this.saveDetail = function () {
        $("#frmDetail #entry_id").val($("#frm #id").val());

        var validate = $(".input-detail").validate();

        if (validate.length == 0) {
            var frm = $("#frmDetail");
            var data = frm.serialize();
            var url = "entry/", method = "";
            var id = $("#frmDetail #id").val();
            var msg = 'Record Detail';
            if (id == '') {
                method = 'POST';
                url += "storeDetail";
                msg = "Created " + msg;

            } else {
                method = 'PUT';
                url += "detail/" + id;
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
                    } else {
                        toastr.warning("Wrong");
                    }
                }
            })
        } else {
            toastr.warning("Input required");
        }
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
                $(".input-entry").setFields({data: data.header});
                $("#btnSend").prop("disabled", false);
                if (data.header.supplier_id != 0) {
                    obj.getSupplier(data.header.supplier_id);
                }

                if (data.header.id != '') {
                    $("#btnmodalDetail").attr("disabled", false);
                }

                obj.printDetail(data);

                if (data.header.status_id != 1) {
                    $("#btnmodalDetail").prop("disabled", true);
                    $(".btnEditClass").prop("disabled", true);
                    $(".btnDeleteClass").prop("disabled", true);
                } else {
                    $(".btnEditClass").prop("disabled", false);
                    $(".btnDeleteClass").prop("disabled", false);
                    $("#btnmodalDetail").prop("disabled", false);
                }
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
                $(".input-detail").setFields({data: data});
            }
        })
    }

    this.printDetail = function (data) {
        var html = "";
        $("#tblDetail tbody").empty();
        var total = 0, calc = 0;
        $.each(data.detail, function (i, val) {
            html += "<tr>";
            html += "<td>" + val.id + "</td>";
            html += "<td>" + val.product + "</td>";
            html += "<td>" + val.expiration_date + "</td>";
            html += "<td>" + val.quantity + "</td>";
            html += "<td>" + val.valueFormated + "</td>";
            html += "<td>" + val.totalFormated + "</td>";
            html += '<td><button type="button" class="btn btn-xs btn-primary btnEditClass" onclick=obj.editDetail(' + val.id + ')>Edit</button>';
            html += '<button type="button" class="btn btn-xs btn-warning btnDeleteClass" onclick=obj.deleteDetail(' + val.id + ')>Delete</button></td>';
            html += "</tr>";
        });

        $("#tblDetail tbody").html(html);
        $("#tblDetail tfoot").html('<tr><td colspan="5">Total</td><td>' + data.total + '</td></tr>');

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
                    if (data.success == true) {
                        table.ajax.reload();
                        toastr.warning("Ok");
                        obj.printDetail(data);
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
                    if (data.success == true) {
                        toastr.warning("Record deleted");
                        obj.printDetail(data);
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
            ajax: "/api/listEntry",
            columns: [
                {data: "id"},
                {data: "consecutive"},
                {data: "description"},
                {data: "created_at"},
                {data: "invoice"},
                {data: "warehouse"},
                {data: "city"},
                {data: "status"},
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
                    mData: null,
                    mRender: function (data, type, full) {
                        return '<button class="btn btn-danger btn-xs" onclick="obj.delete(' + data.id + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                    }
                }
            ],
        });
    }

}

var obj = new Entry();
obj.init();