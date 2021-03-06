function Purchase() {
    var table, listProduct = [], row = {}, rowItem;
    this.init = function () {
        table = this.table();
        $("#btnNew").click(this.new);
        $("#btnSave").click(this.save);
        $("#btnSend").click(this.send);
        $("#btnReverse").click(this.reverse);
        $("#newDetail").click(this.saveDetail);
        $(".form_datetime").datetimepicker({format: 'Y-m-d h:i'});
        $("#edit").click(this.edit);

        $("#tabManagement").click(function () {
            $('#myTabs a[href="#management"]').tab('show');
        });

        $("#supplier_id").on('select2:closing', function (evt) {

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
        });

        $("#frmDetail #product_id").change(function () {
            $.ajax({
                url: PATH + "/purchase/" + $(this).val() + '/getDetailProduct',
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


    this.send = function () {
        toastr.remove();
        if (confirm("do you want send purchase the supplier?")) {
            var obj = {};
            obj.id = $("#frm #id").val();
            $.ajax({
                url: PATH + '/purchase/sendPurchase',
                method: 'POST',
                data: obj,
                dataType: 'JSON',
                beforeSend: function () {
                    $("#loading-super").removeClass("hidden");
                },
                success: function (resp) {
                    $(".input-purchase").setFields({data: resp.header, disabled: true});
                    toastr.success("Purchase sended");
                    $("#btnSend").attr("disabled", true);
                    table.ajax.reload();
                }, error: function (xhr, ajaxOptions, thrownError) {
                    toastr.error(xhr.responseJSON.msg);
                }
                , complete: function () {
                    $("#loading-super").addClass("hidden");
                }
            })
        }

    }

    this.new = function () {
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
            url: PATH + "/purchase/" + id + '/getSupplier',
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
        var html = "", color = "", quantity_total = 0, price_total = 0, total = 0;

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

            color = (listProducts[i].quantity == 0) ? '' : 'info';
            quantity_total = val.units_supplier * val.quantity;


            price_total = val.cost_sf * quantity_total;
            total += price_total;
            html += '<tr id="row_' + val.product_id + '" class="' + color + '">';
            html += "<td>" + (i + 1) + "</td><td>" + val.title + "</td>";
            html += "<td>" + val.units_supplier + "</td><td>" + val.tax + "</td><td>" + val.quantity + "</td>";
            html += "<td>" + val.cost_sf + "</td><td>" + quantity_total + "</td><td>" + price_total + "</td>";
            html += '<td ><button class="btn btn-info btn-xs" onclick=obj.edit(' + val.product_id + ')><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>';
            html += '<button class="btn btn-danger btn-xs" onclick=obj.deleteNew(' + val.product_id + ')><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></td>';
            html += "</tr>";
        })
        html += "<tr><td colspan='7'><b>Total</b></td><td>" + total + "</td></tr>"

        $("#tblDetail tbody").html(html);

    }

    this.edit = function (product_id) {
        toastr.remove();
        $("#modalDetail").modal("show");
        obj.getItem(product_id)
        $(".input-detail").cleanFields();
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

        var id = $("#frm #id").val();
        var msg = '';
        var validate = $(".input-purchase").validate();

        var data = {};


        if (validate.length == 0) {
            data.header = $(".input-purchase").getData();
            data.detail = listProducts;

            if (id == '') {
                method = 'POST';
                msg = "Created Record";
                url = "/purchase";
            } else {
                method = 'PUT';
                url = "/purchase/" + id;
                msg = "Edited Record";
            }


            $.ajax({
                url: PATH + url,
                method: method,
                data: data,
                dataType: 'JSON',
                beforeSend: function () {
                    $("#loading-super").removeClass("hidden");
                },
                success: function (data) {
                    if (data.success == true) {
                        $("#frm #btnSave").attr("disabled", true);
                        $(".input-purchase").setFields({data: data.header, disabled: true});
                        table.ajax.reload();
                        toastr.success(msg);
                        $("#btnmodalDetail").attr("disabled", false);
                        $("#btnSend").attr("disabled", false);
                        obj.printDetail(data)
                    }
                },
                error: function (xhr, ajaxOption, thrownError) {
                    toastr.error(xhr.responseJSON.msg);
                },
                complete: function () {
                    $("#loading-super").addClass("hidden");
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
            if ($("#frm #id").val() == '') {
                $.each(listProducts, function (i, val) {
                    if (val.product_id == row.product_id) {
                        listProducts[i].quantity = $("#frmDetail #quantity").val()
                        $("#modalDetail").modal("hide");
                        obj.loadProducts();
                        toastr.success("Register Edited");
                    }
                });
            } else {
                var param = {};
                param.quantity = $("#frmDetail #quantity").val();
                param.purchase_id = $("#frm #id").val();

                $.ajax({
                    url: 'purchase/detail/' + $("#frmDetail #id").val(),
                    method: "PUT",
                    data: param,
                    dataType: 'JSON',
                    success: function (resp) {
                        if (resp.success == true) {
                            obj.printDetail(resp);
                        }
                    }, error: function () {

                    }
                })
            }
        } else {
            toastr.error("input required");
        }
    }

    this.reverse = function () {
        toastr.remove()
        $.ajax({
            url: 'purchase/' + $("#frm #id").val() + '/reverseInvoice',
            method: 'PUT',
            dataType: 'JSON',
            success: function (data) {
                $(".input-purchase").setFields({data: data.header});
                table.ajax.reload();
                toastr.success("Factura reversada!");
            }, error: function (xhr, ajaxOptions, thrownError) {
                toastr.error(xhr.responseJSON.msg);
            },
        })
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

                if (data.header.status_id == 2) {
                    $("#btnReverse").attr("disabled", false);
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
            html += "<tr>";
            html += "<td>" + i + "</td>";
            html += "<td>" + val.product + "</td>";
            html += "<td>" + val.units_supplier + "</td>";

            html += "<td>" + val.tax + "</td>";
            html += "<td>" + val.quantity + "</td>";
            html += "<td>" + val.valueFormated + "</td>";
            html += "<td>" + val.quantity_total + "</td>";
            html += "<td>" + val.totalFormated + "</td>";

            html += '<td><button type="button" class="btn btn-xs btn-primary" onclick=obj.editDetail(' + val.product_id + ',' + val.purchase_id + ')>Edit</button>';
            html += '<button type="button" class="btn btn-xs btn-warning" onclick=obj.deleteDetail(' + val.product_id + ',' + val.purchase_id + ')>Delete</button></td>';
            html += "</tr>";
        });

        if (data.tax5) {
            html += "<tr>";
            html += '<td><td colspan="6" align="right"><b>Iva 5%</b></td><td>' + data.tax5 + '</td>';
            html += "</tr>";
        }
        if (data.tax19) {
            html += "<tr>";
            html += '<td><td colspan="6" align="right"><b>Iva 19%</b></td><td>' + data.tax19 + '</td>';
            html += "</tr>";
        }

        $("#tblDetail tbody").html(html);
        $("#tblDetail tfoot").html('<tr><td colspan="7" align="right"><strong>Subtotal</strong></td><td>' + data.subtotal + '</td></tr><tr><td colspan="7" align="right"><strong>Total</strong></td><td>' + data.total + '</td></tr>');


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
        table = $('#tbl').DataTable({
            "dom":
                    "R<'row'<'col-sm-4'l><'col-sm-2 toolbar text-right'><'col-sm-3'B><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12't>>" +
                    "<'row'<'col-xs-3 col-sm-3 col-md-3 col-lg-3'i><'col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center'p><'col-xs-3 col-sm-3 col-md-3 col-lg-3'>>",
            destroy: true,
            "processing": true,
            "serverSide": true,
            "ajax": "/api/listPurchase",
            columns: [
                {
                    className: 'details-control',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                    searchable: false,
                },
                {data: "id"},
                {data: "description"},
                {data: "created_at"},
                {data: "stakeholder"},
                {data: "warehouse"},
                {data: "city"},
                {data: "status"},
            ],

            buttons: [
                {

                    className: 'btn btn-primary glyphicon glyphicon-filter',
                    action: function (e, dt, node, config) {
                        $("#modalFilter").modal("show");
                        $(".modal-filter").cleanFields();
                    }
                },
                {

                    className: 'btn btn-primary glyphicon glyphicon-eye-open',
                    action: function (e, dt, node, config) {
                        $("#modalColumns").modal("show");
                    }
                },
                {
                    extend: 'excelHtml5',
//                    text: '<i class="fa fa-file-excel-o"></i>',
                    className: 'btn btn-primary glyphicon glyphicon-download',
                    titleAttr: 'Excel'
                },
            ],

            lengthMenu: [[30, 100, 300, -1], [30, 100, 300, 'All']],
            order: [[3, 'DESC']],
            aoColumnDefs: [
                {
                    aTargets: [1, 2, 3, 4, 5, 6],
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
        var url = "/purchase/" + d.id + "/detailAll";
        var html = `<br>
                <table class="table-detail">
                    <thead>
                        <tr>
                            <th colspan="3">Information</th>
                            <th colspan="3" class="center-rowspan">Orden</th>
                        </tr>
                    </thead>`;
        $.ajax({
            url: url,
            method: "GET",
            dataType: 'JSON',
            async: false,
            success: function (data) {
                html += "<tbody>";
                $.each(data.detail, function (i, val) {
                    val.real_quantity = (val.real_quantity != null) ? val.real_quantity : '';
                    html += "<tr>";
                    html += "<td>" + val.id + "</td>";
                    html += "<td>" + val.product + "</td>";
                    html += "<td>" + (val.tax * 100) + "%</td>";
                    html += "<td>" + val.quantity + "</td>";
                    html += "<td>" + val.valueFormated + "</td>";
                    html += "<td>" + val.totalFormated + "</td>";
                    html += "</tr>";
                });

                if (data.tax5 != '$ 0') {
                    html += '<tr><td colspan="5" align="right"><b>Iva 5%</b></td><td>' + data.tax5 + '</td><tr>';
                }
                html += '<tr><td colspan="5" align="right"><b>Iva 19%</b></td><td>' + data.tax19 + '</td><tr>';
                if (data.discount != '$ 0') {
                    html += '<tr><td colspan="5" align="right"><b>Descuento</b></td><td>' + data.discount + '</td><tr>';
                }
                if (data.shipping_cost != '$ 0') {
                    html += '<tr><td colspan="5" align="right"><b>Descuento</b></td><td>' + data.shipping_cost + '</td><tr>';
                }

                html += '<tr><td colspan="5" align="right"><b>Subtotal</b></td><td>' + data.subtotal + '</td><tr>';
                html += '<tr><td colspan="5" align="right"><b>Total</b></td><td>' + data.total + '</td><tr>';
                html += "</tbody></table><br>";
            }
        })
        return html;
    }

}

var obj = new Purchase();
obj.init();