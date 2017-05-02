function Purchase() {
    var table, listProduct = [], row = {}, rowItem;
    this.init = function () {
        table = this.table();
        $("#btnNew").click(this.new);
        $("#btnSave").click(this.save);
        $("#btnSend").click(this.send);
        $("#newDetail").click(this.saveDetail);
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
            var created = $("#frm #created").val();
            $(".input-purchase").cleanFields({disabled: true});
            $("#frm #created").val(created);
            $("#frm #btnSave").attr("disabled", true);
            $("#frm #warehouse_id").getSeeker({default: true, api: '/api/getWarehouse', disabled: true});
            $("#frm #responsible_id").getSeeker({default: true, api: '/api/getResponsable', disabled: true});
            $("#frm #city_id").getSeeker({default: true, api: '/api/getCity', disabled: true});
            $("#frm #branch_id").getSeeker({default: true, api: '/api/getSupplier', disabled: true});

            obj.consecutive();
        });

        $("#frmDetail #product_id").change(function () {
            $.ajax({
                url: 'purchase/' + $(this).val() + '/getDetailProduct',
                method: 'GET',
                dataType: 'JSON',
                success: function (resp) {
                    $("#frmDetail #category_id").val(resp.response.category_id).trigger('change');
                    $("#frmDetail #value").val(resp.response.cost_sf)
                    $("#frmDetail #packaging").html("Packaging X" + resp.response.units_supplier)
                }
            })
        });

        $("#btnmodalDetail").click(function () {
            $(".input-detail").cleanFields();
            $("#frmDetail #product_id").getSeeker({filter: {supplier_id: $("#frm #supplier_id").val()}});
            $("#modalDetail").modal("show");
            $("#frmDetail #id").val("");
            $("#frmDetail #purchase_id").val($("#frm #id").val());
            $("#frmDetail #quantity").val("");
            $("#frmDetail #value").val("");
            $("#frmDetail #packaging").html("");
        })


        $("#frmDetail #quantity").blur(function () {
            $("#frmDetail #total").val(($(this).val() * row.units_supplier) * $("#frmDetail #value").val());
            $("#frmDetail #quantity_total").val($(this).val() * row.units_supplier);
        })

    }



    this.consecutive = function () {
        $.ajax({
            url: 'purchase/1/consecutive',
            method: 'GET',
            dataType: 'JSON',
            success: function (resp) {
                $("#frm #consecutive").html(resp.response);
            }
        })
    }

    this.send = function () {
        toastr.remove();
        if (confirm("do you want send purchase the supplier?")) {
            var obj = {};
            obj.id = $("#frm #id").val();
            $.ajax({
                url: 'purchase/sendPurchase',
                method: 'POST',
                data: obj,
                dataType: 'JSON',
                success: function (resp) {
                    $(".input-purchase").setFields({data: resp.header, disabled: true});
                    toastr.success("Purchase sended");
                    $("#btnSend").attr("disabled", true);
                    table.ajax.reload();
                }, error: function (xhr, ajaxOptions, thrownError) {
                    toastr.error(xhr.responseJSON.msg);
                }
            })
        }

    }

    this.new = function () {
        obj.consecutive();

        $(".input-purchase").cleanFields();
        $("#btnSave").attr("disabled", false);
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
            async: false,
            success: function (resp) {
                resp.response.name = (resp.response.name == null) ? '' : resp.response.name + " ";
                resp.response.last_name = (resp.response.last_name == null) ? '' : resp.response.last_name + " ";

                $("#frm #name_supplier").val(resp.response.name + resp.response.last_name + resp.response.business_name);
                $("#frm #address_supplier").val(resp.response.address);
                $("#frm #phone_supplier").val(resp.response.phone);
                $("#frm #delivery").val(resp.response.delivery);
                listProducts = resp.products;
                obj.loadProducts();

            }
        })
    }

    this.loadProducts = function () {
        var html = "";

        $("#tblDetail tbody").empty();

        $.each(listProducts, function (i, val) {

            if (val.quantity == undefined) {
                listProducts[i].quantity = 0;
            }
            if (val.total == undefined) {
                listProducts[i].total = 0;
            }

            if (val.debt == undefined) {
                listProducts[i].debt = 0;
            }

            if (val.credit == undefined) {
                listProducts[i].credit = 0;
            }

            html += '<tr id="row_' + val.product_id + '">';
            html += "<td>" + i + "</td><td>" + val.description + "</td><td>" + val.title + "</td>";
            html += "<td>" + val.tax + "</td><td>" + val.quantity + "</td>";
            html += "<td>" + val.cost_sf + "</td><td>" + val.total + "</td>";
            html += "<td>" + val.debt + "</td><td>" + val.credit + "</td>";
            html += '<td ><button class="btn btn-info btn-xs" onclick=obj.edit(' + val.product_id + ')><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>';
            html += '<button class="btn btn-danger btn-xs" onclick=obj.deleteNew(' + val.product_id + ')><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></td>';
            html += "</tr>";
        })

        $("#tblDetail tbody").html(html);

    }

    this.edit = function (product_id) {
        toastr.remove();
        $("#modalDetail").modal("show");
        obj.getItem(product_id)
        $(".input-detail").setFields({data: row});
    }

    this.getItem = function (product_id) {

        $.each(listProducts, function (i, val) {
            if (val.product_id == product_id) {
                rowItem = i;
                row = val;
            }
        })
    }

    this.deleteNew = function (product_id) {

        $("#row_" + product_id).remove();
        $.each(listProducts, function (i, val) {
            if (val.product_id == product_id) {
                delete listProducts[i];
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
        toastr.remove();
        obj.fieldDisabled();
        $("#frm #warehouse_id").prop("disabled", false);
        $("#frm #responsible_id").prop("disabled", false);
        $("#frm #city_id").prop("disabled", false);


        var url = "", method = "";
        $("#frm #btnSave").attr("disabled", true);
        var id = $("#frm #id").val();
        var msg = '';
        var validate = $(".input-purchase").validate();

        var data = {};


        if (validate.length == 0) {
            data.header = $(".input-purchase").getData();
            data.detail = listProducts;

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
                    if (data.success == true) {
                        $(".input-purchase").setFields({data: data.header, disabled: true});
                        table.ajax.reload();
                        toastr.success(msg);
                        $("#btnmodalDetail").attr("disabled", false);
                        $("#btnSend").attr("disabled", false);
                    }
                }
            })
        } else {
            toastr.error("input required");
        }
    }

    this.saveDetail = function () {
        toastr.remove();
        var validate = $(".input-detail").validate();

        if (validate.length == 0) {
            $.each(listProducts, function (i, val) {
                if (val.product_id == row.product_id) {
                    listProducts[i].quantity = $("#frmDetail #quantity").val()
                    $("#modalDetail").modal("hide");
                    obj.loadProducts();
                    toastr.success("Register Edited");
                }
            });

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
                $(".input-purchase").setFields({data: data.header, disabled: true});

                if (data.header.supplier_id != 0) {
                    obj.getSupplier(data.header.supplier_id);
                }

                if (data.header.status_id == 1) {
                    $("#btnSend").attr("disabled", false);
                    $("#btnSave").attr("disabled", false);
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
                    if (data.success == true) {
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
                {data: "consecutive"},
                {data: "description"},
                {data: "created_at"},
                {data: "stakeholder"},
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