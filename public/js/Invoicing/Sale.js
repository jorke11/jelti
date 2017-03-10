function Sale() {
    var table, maxDeparture = 0;
    this.init = function () {
        table = this.table();

        $("#btnNew").click(this.new);
        $("#btnSave").click(this.save);
        $("#newDetail").click(this.saveDetail);

        $("#edit").click(this.edit);
        $("#tabManagement").click(function () {
//            $(".input-entry").val("");
            $('#myTabs a[href="#management"]').tab('show');
        });

        $("#insideManagement").click(function () {
            var created = $("#frm #created").val();
            $(".input-sale").cleanFields();
            $("#frm #created").val(created);
            $("#btnSave").attr("disabled",true);
            $("#btnmodalDetail").attr("disabled",true);
            $("#tblDetail tbody").empty();
            $("#tblDetail tfoot").empty();
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

        $("#client_id").change(function () {
            if ($(this).val() != 0) {
                obj.getSupplier($(this).val());
            } else {
                $("#frm #name_client").val("");
                $("#frm #address_client").val("");
                $("#frm #phone_client").val("");
            }
        });

        $("#btnmodalDetail").click(function () {
            $("#modalDetail").modal("show");
            $("#frmDetail #product_id").getSeeker({filter: {supplier_id: $("#frm #client_id").val()}});
            $(".input-detail").cleanFields();
        });


        $("#product_id").change(this.getQuantity);

        $("#quantity").blur(function () {
            if (maxDeparture < $(this).val()) {
                toastr.warning("No hay sufiente disponible");
                $(this).val("");
            }
        });
    }
    this.new = function () {
        var created = $("#frm #created").val();
        $(".input-sale").cleanFields();
        $("#frm #created").val(created);
        $("#frm #warehouse_id").getSeeker({default: true, api: '/api/getWarehouse', disabled: true});
        $("#frm #responsible_id").getSeeker({default: true, api: '/api/getResponsable', disabled: true});
        $("#frm #city_id").getSeeker({default: true, api: '/api/getCity', disabled: true});
    }

    this.getQuantity = function () {
        var id = this.value;
        $.ajax({
            url: 'sale/' + id + '/getDetailProduct',
            method: 'GET',
            dataType: 'JSON',
            success: function (resp) {
                $("#frmDetail #category_id").val(resp.response.category_id).trigger('change');
                $("#frmDetail #value").val(resp.response.price_sf)

                $("#frmDetail #quantityMax").html(resp.quantity)
                maxDeparture = resp.quantity
                if (resp.quantity > 0) {
                    $("#frmDetail #quantity").attr("disabled", false);
                    $("#newDetail").attr("disabled", false);
                } else {
                    $("#newDetail").attr("disabled", true);
                    $("#frmDetail #quantity").attr("disabled", true);
                }
            }

        })

    }

    this.getSupplier = function (id) {
        $.ajax({
            url: 'purchase/' + id + '/getSupplier',
            method: 'GET',
            dataType: 'JSON',
            success: function (resp) {
                $("#frm #name_client").val(resp.response.name + " " + resp.response.last_name);
                $("#frm #address").val(resp.response.address);
                $("#frm #phone").val(resp.response.phone);
            }
        })
    }

    this.save = function () {
        $("#frm #warehouse_id").prop("disabled", false);
        $("#frm #responsible_id").prop("disabled", false);
        $("#frm #city_id").prop("disabled", false);

        var frm = $("#frm");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frm #id").val();
        var msg = '';
        if (id == '') {
            method = 'POST';
            url = "sale";
            msg = "Created Record";

        } else {
            method = 'PUT';
            url = "sale/" + id;
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
        $("#frmDetail #sale_id").val($("#frm #id").val());
        var frm = $("#frmDetail");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frmDetail #id").val();
        var msg = 'Record Detail';
        if (id == '') {
            method = 'POST';
            url = "sale/storeDetail";
            msg = "Created " + msg;

        } else {
            method = 'PUT';
            url = "sale/detail/" + id;
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
                    obj.printDetail(data);
                    $("#modalDetail").modal("hide");
                }
            }
        })
    }

    this.showModal = function (id) {
        var frm = $("#frmEdit");
        var data = frm.serialize();
        var url = "/sale/" + id + "/edit";
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $('#myTabs a[href="#management"]').tab('show');
                $(".input-sale").setFields({data: data.header});

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
        var url = "/sale/" + id + "/detail";
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $("#modalDetail").modal("show");
                $(".input-sales").setFields({data: data});
            }
        })
    }

    this.printDetail = function (data) {
        var html = "", total = 0, debt = 0, credit = 0, total = 0;
        $("#tblDetail tbody").empty();
        $.each(data.detail, function (i, val) {
            val.description = (val.description == null) ? '' : val.description;
            val.product = (val.product == null) ? '' : val.product;
            val.tax = (val.tax == null) ? '' : val.tax;
            val.quantity = (val.quantity == null) ? '' : val.quantity;

            html += "<tr>";
            html += "<td>" + val.id + "</td>";
            html += "<td>" + val.description + "</td>";
            html += "<td>" + val.product + "</td>";
            html += "<td>" + val.tax + "</td>";
            html += "<td>" + val.quantity + "</td>";
            if (val.product != '') {
                html += "<td>" + val.valueFormated + "</td>";
                html += "<td>" + val.totalFormated + "</td>";
            } else {
                html += "<td>" + 0 + "</td>";
                html += "<td>" + val.valueFormated + "</td>";
            }


            if (val.type_nature == 1) {
                val.quantity = (val.quantity == '') ? 1 : val.quantity;
                html += "<td>" + 0 + "</td>";
                html += "<td>" + val.totalFormated + "</td>";
            } else {
                if (val.product == '') {
                    html += "<td>" + val.valueFormated + "</td>";
                    html += "<td>" + 0 + "</td>";
                } else {
                    html += "<td>" + val.totalFormated + "</td>";
                    html += "<td>" + 0 + "</td>";
                }

            }

            if (val.description == 'product') {
                html += '<td><button type="button" class="btn btn-xs btn-primary" onclick=obj.editDetail(' + val.id + ')>Edit</button>';
                html += '<button type="button" class="btn btn-xs btn-warning" onclick=obj.deleteDetail(' + val.id + ')>Delete</button></td>';
            }else{
                html += '<td></td>';
            }
            
            html += "</tr>";
        });

        $("#tblDetail tbody").html(html);
        $("#tblDetail tfoot").html('<tr><td colspan="7">Total</td><td>' + data.debt + '</td><td>' + data.credit + '</td></tr>');
    }

    this.delete = function (id) {
        toastr.remove();
        if (confirm("Deseas eliminar")) {
            var token = $("input[name=_token]").val();
            var url = "/sale/" + id;
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
            var url = "/sale/detail/" + id;
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
            "ajax": "/api/listSale",
            columns: [
                {data: "id"},
                {data: "id"},
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
            "ajax": "/api/listSale",
            columns: [
                {data: "id"},
                {data: "id"},
                {data: "description"},
                {data: "created"},
                {data: "order"},
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

var obj = new Sale();
obj.init();