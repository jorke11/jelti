function Entry() {
    var table;
    this.init = function () {
        table = this.table();

        $("#btnNew").click(this.new);
        $("#btnSave").click(this.save);
        $("#newDetail").click(this.saveDetail);
        $("#btnSend").click(this.send);
        $(".form_datetime").datetimepicker({format: 'Y-m-d h:i'});
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
            $(".input-entry").cleanFields({disabled: true});
            $("#btnSave").attr("disabled", true);
            $("#btnSend").attr("disabled", true);
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
            $(".input-detail").cleanFields();
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

        $("#frm #purchase_id").change(function () {
            if ($(this).val() != null)
                $.ajax({
                    url: 'entry/' + $(this).val() + '/getDetailPurchase',
                    method: 'GET',
                    dataType: 'JSON',
                    success: function (resp) {
                        obj.printDetail(resp, false, false);
                    }
                })
        })

        $("#btnUpload").click(this.upload);

    }

    this.upload = function () {
        var formData = new FormData($("#frmFile")[0]);

        $.ajax({
            url: 'entry/uploadExcel',
            method: 'POST',
            data: formData,
            dataType: 'JSON',
            processData: false,
            cache: false,
            contentType: false,
            success: function (data) {
                console.log(data);
            }
        })
    }

    this.printDetail = function (data, btnEdit = true, btnDel = true) {

        var html = "", htmlEdit = "", htmlDel = "";
        $("#tblDetail tbody").empty();
        var total = 0, calc = 0;

        $.each(data.detail, function (i, val) {
            if (btnEdit == true && val.status_id != 3) {
                htmlEdit = '<button type="button" class="btn btn-xs btn-primary btnEditClass" onclick=obj.editDetail(' + val.id + ')>Edit</button>'
            } else {
                htmlEdit = '';
            }

            if (btnDel == true && val.status_id != 3) {
                htmlDel = ' <button type="button" class="btn btn-xs btn-warning btnDeleteClass" onclick=obj.deleteDetail(' + val.id + ')>Delete</button>'
            } else {
                htmlDel = '';
            }

            val.expiration_date = (val.expiration_date != undefined) ? val.expiration_date : ''
            val.real_quantity = (val.real_quantity != null) ? val.real_quantity : ''
            val.status = (val.status != undefined) ? val.status : 'new'

            html += "<tr>";
            html += "<td>" + val.id + "</td>";
            html += "<td>" + val.product + "</td>";
            html += "<td>" + val.comment + "</td>";
            html += "<td>" + val.expiration_date + "</td>";
            html += "<td>" + val.quantity + "</td>";
            html += "<td>" + val.valueFormated + "</td>";
            html += "<td>" + val.totalFormated + "</td>";
            html += "<td>" + val.real_quantity + "</td>";
            html += "<td>" + val.valueFormated + "</td>";
            html += "<td>" + val.totalFormated_real + "</td>";
            html += "<td>" + val.status + "</td>";
            html += '<td>' + htmlEdit + htmlDel + "</td>";
            html += '</td>';
            html += "</tr>";
        });

        $("#tblDetail tbody").html(html);
        $("#tblDetail tfoot").html('<tr><td colspan="5">Total</td><td>' + data.total + '</td><td colspan="2"></td><td>' + data.total_real + '</td></tr>');

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

        $(".input-entry").cleanFields();

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
            beforeSend: function () {
                $("#loading-super").removeClass("hidden");
            },
            success: function (resp) {
                if (resp.success == true) {
                    toastr.success("Sended");
                    $(".input-entry").setFields({data: resp.header, disabled: true});
                    $("#btnmodalDetail").attr("disabled", true);
                    $("#btnSend").attr("disabled", true);
                    table.ajax.reload();
                } else {
                    toastr.warning(resp.msg);
                }
            }, error: function (xhr, ajaxOptions, thrownError) {
                toastr.error(xhr.responseJSON.msg);
            },
            complete: function () {
                $("#loading-super").addClass("hidden");
            }

        })

    }

    this.getSupplier = function (id) {
        if (id != null)
            $.ajax({
                url: 'entry/' + id + '/getSupplier',
                method: 'GET',
                dataType: 'JSON',
                success: function (resp) {

                    resp.response.name = (resp.response.name == null) ? '' : resp.response.name + " ";
                    resp.response.last_name = (resp.response.last_name == null) ? '' : resp.response.last_name + " ";
                    $("#frm #name_supplier").val(resp.response.name + resp.response.last_name + resp.response.business_name);

//                    $("#frm #name_supplier").val(resp.response.name + " " + resp.response.last_name);
                    $("#frm #address_supplier").val(resp.response.address);
                    $("#frm #phone_supplier").val(resp.response.phone);

                    obj.loadPurchase(resp.purchases);
                }
            })
    }

    this.loadPurchase = function (data) {
        var html = "";
        $("#frm #purchase_id").empty();
        html = "<option value='0'>Selection</option>";
        $.each(data, function (i, val) {
            html += "<option value='" + val.id + "'>" + val.consecutive + "</option>";
        })
        $("#frm #purchase_id").html(html);
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
                        $(".input-entry").setFields({data: data.header, disabled: true});
                        table.ajax.reload();
                        obj.printDetail(data);
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
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    toastr.error(xhr.responseJSON.msg);
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
                $(".input-entry").setFields({data: data.header, disabled: true});
                $("#btnSend").prop("disabled", false);

                if (data.header.supplier_id != 0) {
                    obj.getSupplier(data.header.supplier_id);
                }

                if (data.header.id != '') {
                    $("#btnmodalDetail").attr("disabled", false);
                }

                obj.printDetail(data, true, true);

                if (data.header.status_id != 1) {
                    $("#btnmodalDetail").prop("disabled", true);
                    $(".btnEditClass").prop("disabled", true);
                    $(".btnDeleteClass").prop("disabled", true);
                    $("#btnSend").prop("disabled", true);
                } else {
                    $(".btnEditClass").prop("disabled", false);
                    $(".btnDeleteClass").prop("disabled", false);
                    $("#btnmodalDetail").prop("disabled", false);
                }
            }
        })
    }

    this.editDetail = function (id) {
        var url = "/entry/" + id + "/detail";
        $.ajax({
            url: url,
            method: "GET",
            dataType: 'JSON',
            success: function (data) {
                $("#modalDetail").modal("show");
                $(".input-detail").setFields({data: data});
                $("#frmDetail #real_quantity").val(data.quantity);
            }
        })
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
        table = $('#tbl').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/api/listEntry",
            columns: [
                {
                    className: 'details-control',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                    searchable: false,
                },
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
                    aTargets: [ 1, 2, 3, 4, 5, 6, 7],
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

        $('#tbl tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {

                row.child(obj.format(row.data())).show();
                tr.addClass('shown');
            }
        });

        return table;
    }

    this.format = function (d) {
        var url = "/entry/" + d.id + "/detailAll";
        var html = '<br><table class="table-detail">';
        html += '<thead><tr><th colspan="2">Information</th><th colspan="3" class="center-rowspan">Order</th>'
        html += '<th colspan="3" class="center-rowspan">Dispatched</th></tr>'
        html += '<tr><th>#</th><th>Product</th><th>Quantity</th><th>Unit</th><th>Total</th><th>Quantity</th><th>Unit</th><th>Total</th></tr></thead>';
        $.ajax({
            url: url,
            method: "GET",
            dataType: 'JSON',
            async: false,
            success: function (data) {
                html += "<tbody>";
                $.each(data, function (i, val) {
                    val.real_quantity = (val.real_quantity != null) ? val.real_quantity : '';
                    html += "<tr>";
                    html += "<td>" + val.id + "</td>";
                    html += "<td>" + val.product + "</td>";
                    html += "<td>" + val.quantity + "</td>";
                    html += "<td>" + val.valueFormated + "</td>";
                    html += "<td>" + val.totalFormated + "</td>";
                    html += "<td>" + val.real_quantity + "</td>";
                    html += "<td>" + val.valueFormated + "</td>";
                    html += "<td>" + val.totalFormated_real + "</td>";
                    html += "</tr>";
                });
                html += "</tbody></table><br>";
            }
        })
        return html;
    }

}

var obj = new Entry();
obj.init();