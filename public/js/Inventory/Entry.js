function Entry() {
    var table, showDetail = true, detail = [], price_sf = 0, row = {};

    this.init = function () {
        table = this.table();

        $("#btnNew").click(this.new);
        $("#btnSave").click(this.save);
        $("#newDetail").click(this.saveDetail);
        $("#btnSend").click(this.send);
        $(".form_datetime").datetimepicker({format: 'Y-m-d'});
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
            $("#frm #supplier_id").prop("disabled", true);
            $("#frm #status_id").prop("disabled", true);
            $("#frm #warehouse_id").getSeeker({default: true, api: '/api/getWarehouse', disabled: true});
            $("#frm #responsible_id").getSeeker({default: true, api: '/api/getResponsable', disabled: true});
            $("#frm #city_id").getSeeker({default: true, api: '/api/getCity', disabled: true});
            $("#tblDetail tbody").empty();
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
                    price_sf = resp.response.price_sf;
                    $("#btnmodalDetail").attr("disabled", false)
                }
            })
        });

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

    }

    this.send = function () {
        toastr.remove();

        var param = {};

        param.header = $(".input-entry").getData();
        param.detail = detail;

        if (confirm("¿Deseas ingresar el pedido?")) {
            $.ajax({
                url: 'entry/setPurchase',
                method: 'POST',
                data: param,
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
                }
            })
    }


    this.save = function () {
        $("#frm #warehouse_id").prop("disabled", false);
        $("#frm #responsible_id").prop("disabled", false);
        $("#frm #city_id").prop("disabled", false);
        var data = {};
        var validate = $(".input-entry").validate();

        if (validate.length == 0) {
            var url = "entry", method = "";
            var id = $("#frm #id").val();
            var msg = '';


            data.header = $(".input-entry").getData();
            data.detail = detail;



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
                        detail = data.detail;
                        obj.printDetail();
                        toastr.success(msg);
                        $("#btnmodalDetail").attr("disabled", false);
                        $("#btnSend").prop("disabled", false);
                        $(".btnEditClass").prop("disabled", false);

                    }
                }, error: function (xhr, ajaxOptions, thrownError) {
                    toastr.error(xhr.responseJSON.msg);
                },
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
                obj.createDetail();
            } else {
                obj.setDetail(id);
            }
        } else {
            toastr.warning("Input required");
        }
    }


    this.setDetail = function (id) {
        $.each(detail, function (i, val) {
            if (id == val.id) {
                detail[i].lot = $("#frmDetail #lot").val();
                detail[i].real_quantity = $("#frmDetail #real_quantity").val();
                detail[i].description = $("#frmDetail #description").val();
                detail[i].total_real = detail[i].units_supplier * detail[i].value * $("#frmDetail #real_quantity").val();
                detail[i].expiration_date = $("#frmDetail #expiration_date").val();
            }
        })

        this.printDetail();
    }



    this.createDetail = function () {

        detail.push({
            id: detail.length + 1,
            product_id: $("#frmDetail #product_id").val(),
            product: $.trim($("#frmDetail #product_id").text()),
            quantity: $("#frmDetail #quantity").val(),
            real_quantity: $("#frmDetail #real_quantity").val(),
            expiration_date: $("#frmDetail #expiration_date").val(),
            lot: $("#frmDetail #lot").val(),
            description: $("#frmDetail #description").val(),
            value: price_sf,
            total: price_sf * $("#frmDetail #quantity").val(),
            total_real: price_sf * $("#frmDetail #real_quantity").val()
        });



        $("#frmDetail #product_id").text("");
        toastr.success("Producto Agregado");

        obj.printDetail();
        $(".input-detail").cleanFields();

    }

    this.editDetail = function (id) {


        if ($("#frm #status_id").val() != 2) {
            var url = "/purchase/" + id + "/detail";
            var param = {};

            if (showDetail) {
                console.log("asd");
                $.ajax({
                    url: url,
                    method: "GET",
                    dataType: 'JSON',
                    success: function (data) {
                        obj.reloadTableDetail(id, data);
                    }
                })
                showDetail = false;
            } else {
                $(".add_" + id).remove();
                showDetail = true;
            }
        } else {
            $("#modalDetail").modal("show");

            this.getDetail(id)

//            var row = {
//                id: id,
//                product_id: $("#frmDetail #product_id").val(),
//                product: $.trim($("#frmDetail #product_id").text()),
//                quantity: $("#frmDetail #quantity").val(),
//                real_quantity: $("#frmDetail #real_quantity").val(),
//                expiration_date: $("#frmDetail #expiration_date").val(),
//                lot: $("#frmDetail #lot").val(),
//                description: $("#frmDetail #description").val(),
//                value: price_sf,
//                total: price_sf * $("#frmDetail #quantity").val()
//            };

            $(".input-detail").setFields({data: row})
        }
    }

    this.getDetail = function (id) {
        $.each(detail, function (i, val) {
            if (id == val.id) {
                row = val
            }
        })
    }

    this.printDetail = function () {
        var html = '';

        var htmlEdit = ''
        var htmlDel = ''

        $("#tblDetail tbody").empty();

        var real_quantity = 0;
        $.each(detail, function (i, val) {
            if (val != undefined) {
//                if (data.header.status_id == 1) {
                htmlEdit = '<button type="button" class="btn btn-xs btn-primary btnEditClass" onclick=obj.editDetail(' + val.id + ')>Edit</button>'
                htmlDel = ' <button type="button" class="btn btn-xs btn-warning btnDeleteClass" onclick=obj.deleteDetail(' + val.id + ')>Delete</button>'
//                }

                real_quantity = (val.real_quantity != undefined) ? val.real_quantity : 0;

                html += '<tr id="row_' + val.id + '">';
                html += "<td>" + val.id + "</td>"
                html += "<td>" + val.product + "</td>"
                html += "<td>" + val.quantity + "</td>"
                html += "<td>" + val.value + "</td>"
                html += "<td>" + val.total + "</td>"
                html += "<td>" + real_quantity + "</td>"
                html += "<td>" + val.value + "</td>"
                html += "<td>" + val.total_real + "</td>"
                html += '<td>' + htmlEdit + htmlDel + "</td>";
                html += "</tr>"
            }
        });

        $("#tblDetail tbody").html(html);
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
                $(".input-entry").setFields({data: data.header, disabled: true});

                if (data.header.supplier_id != 0) {
                    obj.getSupplier(data.header.supplier_id);
                }

                if (data.header.status_id == 1) {
                    $("#btnSend").prop("disabled", false);
                }

                if (data.header.id != '') {
                    $("#btnmodalDetail").attr("disabled", false);
                }

                detail = data.detail
                obj.printDetail();

                if (data.header.status_id != 2) {

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

    this.reloadTableDetail = function (id, data) {


        var html = "<tr class='add_" + id + "'><table>";
        $(".add_" + id).remove();

        html += "<tr class='add_" + id + "' style='background-color:#ddd'><td colspan='7'><br></td></tr>";
        html += "<tr class='add_" + id + "'><td style='background-color:#ddd' colspan='3'></td>";
        html += "<td align='center'><button type='button' class='btn btn-info input-sm' onclick='obj.repeatData(" + id + ")'>Replicar</button></td>";
        html += "<td align='center'><button type='button' class='btn btn-success input-sm' onclick='obj.saveData(" + id + ")'>Actualizar</button></td><td></td><td></td></tr>";
        html += "<tr class='add_" + id + "' align='center'><td colspan='3' style='background-color:#ddd'></td><td>Lote</td><td>Fecha Vencimiento</td><td>Cantidad x" + data[0].units_supplier + "</td><td>Cantidad X Embalaje</td></tr>";
        var cont = 0;
        $.each(data, function (i, val) {
            val.real_quantity = (val.real_quantity == null) ? 0 : val.real_quantity;
            val.expiration_date = (val.expiration_date == null) ? '' : val.expiration_date;
            val.lot = (val.lot == null) ? '' : val.lot;
            html += "<tr style='background-color:#ddd' class='add_" + id + "'><td colspan='3'></td>";
            html += "<td><input class='form-control input-sm detail_lot_" + id + "' value='" + val.lot + "' placeholder='Lote' name='lot_" + val.id + "' id='lot_" + val.id + "'></td>";
            html += "<td><input class='form-control input-sm detail_date_" + id + " form_datetime' name='exp_" + val.id + "' id='exp_" + val.id + "' value='" + val.expiration_date + "' placeholder='Fecha Vencimiento'></td>";
            html += "<td><input class='form-control input-sm detail_quantity_" + id + "' value='" + val.real_quantity + "'  name='qua_" + val.id + "' id='quantity_" + val.id + "' placeholder='Cantidad' onblur=obj.reCalculate(this," + val.id + "," + val.units_supplier + ")></td>";
            html += "<td><input class='form-control input-sm' value='" + (val.real_quantity * val.units_supplier) + "' id='real_" + val.id + "' readonly></td>";
            html += "</tr>";
            cont += parseInt(val.real_quantity);
        });

        html += "<tr class='add_" + id + "'><td colspan='3' style='background-color:#ddd'></td><td></td><td><b>Total</b> x" + data[0].units_supplier + "</td><td>" + (cont) + "</td><td>" + (data[0].units_supplier * cont) + "</td></tr>";
        html += "<tr class='add_" + id + "' style='background-color:#ddd'><td colspan='6'><br></td></tr>";
        html += "</table></tr>";
        $("#row_" + id).after(html);

        $(".form_datetime").datetimepicker({format: 'Y-m-d'});


    }

    this.reCalculate = function (elem, id, units_supplier) {
        var _elem = $(elem);
        $("#real_" + id).val(_elem.val() * units_supplier);
    }

    this.saveData = function (id) {
        $("#entry_id").val($("#frm #id").val());
        var data = $("#frmSetDetail").serialize();


        $.ajax({
            url: 'entry/' + id + '/setDetail',
            method: "PUT",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                if (data.success == true) {
                    toastr.success(data.msg);
                    obj.showModal(data.header.id);
                } else {
                    toastr.warning("Wrong");
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                toastr.error(xhr.responseJSON.msg);
            }
        })


    }

    this.repeatData = function (id) {
        var lot = '';
        var exp = '';
        var quantity = '';
        var cont = 0;
        if ($(".detail_lot_" + id)[0].value != '') {

            $(".detail_lot_" + id).each(function () {

                if (cont > 0) {
                    $(this).val(lot)
                } else {
                    lot = $(this).val();
                }
                cont++;
            })
        }
        cont = 0;

        if ($(".detail_date_" + id)[0].value != '') {

            $(".detail_date_" + id).each(function () {

                if (cont > 0) {
                    $(this).val(lot)
                } else {
                    lot = $(this).val();
                }
                cont++;
            })
        }

        cont = 0;

        if ($(".detail_quantity_" + id)[0].value != '') {

            $(".detail_quantity_" + id).each(function () {
                if (cont > 0) {
                    $(this).val(lot)
                } else {
                    lot = $(this).val();
                }
                cont++;
            })
        }
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
                }, error: function (xhr, ajaxOptions, thrownError) {
                    toastr.error("No se puede borrra Este registro");
                }
            })
        }
    }

    this.deleteDetail = function (id) {
        toastr.remove();
        if (confirm("Do you want delete this record?")) {

            $("#row_" + id).remove();
            delete detail[id - 1];

//            var token = $("input[name=_token]").val();
//            var url = "/entry/detail/" + id;
//            var param = {};
//            param.entry_id = $("#frm #id").val();
//            $.ajax({
//                url: url,
//                headers: {'X-CSRF-TOKEN': token},
//                method: "DELETE",
//                data: param,
//                dataType: 'JSON',
//                success: function (data) {
//                    if (data.success == true) {
//                        toastr.warning("Record deleted");
//                        obj.printDetail(data);
//                    }
//                }, error: function (xhr, ajaxOptions, thrownError) {
//                    toastr.error(xhr.responseJSON.msg);
//                }
//            })
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
                {data: "id"},
                {data: "stakeholder"},
                {data: "description"},
                {data: "created_at"},
                {data: "warehouse"},
                {data: "city"},
                {data: "status"},
            ],
            order: [[1, 'DESC']],
            aoColumnDefs: [
                {
                    aTargets: [1, 2, 3, 4, 5],
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
            ], initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;
                    var type = $(column.header()).attr('rowspan');
                    if (type != undefined) {
                        var select = $('<select class="form-control"><option value="">' + $(column.header()).text() + '</option></select>')
                                .appendTo($(column.footer()).empty())
                                .on('change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                            $(this).val()
                                            );
                                    column
                                            //                                            .search(val ? val : '', true, false)
                                            .search(val ? '^' + val + '$' : '', true, false)
                                            .draw();
                                });
                        column.data().unique().sort().each(function (d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>')
                        });
                    }
                });
            },
            createdRow: function (row, data, index) {

                if (data.status_id == 1) {
                    $('td', row).eq(8).addClass('color-new');
                } else if (data.status_id == 2) {
                    $('td', row).eq(8).addClass('color-pending');
                } else if (data.status_id == 3) {
                    $('td', row).eq(8).addClass('color-checked');
                }
            },
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