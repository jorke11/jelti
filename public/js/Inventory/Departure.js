function Sale() {
    var table, maxDeparture = 0, listProducts = [], dataProduct, row = {}, rowItem;
    this.init = function () {
        table = this.table();
        $("#btnNew").click(this.new);
        $("#btnSave").click(this.save);
//        $("#newDetail").click(this.confirmItem);
        $("#newDetail").click(this.saveDetail);
        $("#btnSend").click(this.send);
        $(".form_datetime").datetimepicker({format: 'Y-m-d h:i'});
        $("#edit").click(this.edit);
        $("#tabManagement").click(function () {
            $('#myTabs a[href="#management"]').tab('show');
        });
        $("#client_id").change(function () {
            if ($(this).val() != 0) {
                obj.getClient($(this).val());
            } else {
                $("#frm #name_client").val("");
                $("#frm #address_supplier").val("");
                $("#frm #phone_supplier").val("");
            }
        });

        $("#branch_id").change(function () {
            if ($(this).val() != 0) {
                obj.getBranchAddress($(this).val());
            } else {

            }
        });


        $("#quantity").change(function () {
            $("#quantity_units").val(dataProduct.units_sf * $(this).val());
            $("#value_units").val(dataProduct.units_sf * $(this).val() * dataProduct.price_sf).formatNumber();
        });


        if ($("#id_orderext").val() != '') {
            obj.infomationExt($("#id_orderext").val(), true);
        }

        $("#insideManagement").click(function () {
            $(".input-departure").cleanFields({disabled: true});
            $("#btnSend").attr("disabled", true);
            $("#btnSave").attr("disabled", true);
            $("#btnmodalDetail").attr("disabled", true);
            $("#btnDocument").attr("disabled", true);
            $(".input-fillable").attr("disabled", true);
            $("#frm #warehouse_id").getSeeker({default: true, api: '/api/getWarehouse', disabled: true});
            $("#frm #responsible_id").getSeeker({default: true, api: '/api/getResponsable', disabled: true});
            $("#frm #city_id").getSeeker({default: true, api: '/api/getCity', disabled: true});
            $("#frm #status_id").val(1).trigger('change');
            $("#frm #status_id").prop("disabled", true);
            obj.consecutive();
        });
        $("#btnmodalDetail").click(function () {
            $("#modalDetail").modal("show");
            $(".input-detail").cleanFields();
            $("#frmDetail #rowItem").val(-1);

            if ($("#frm #status_id").val() == 1) {
                $("#frmDetail #real_quantity").attr("disabled", true);
                $("#frmDetail #description").attr("disabled", true);
            }

        });

        $("#frmDetail #product_id").change(function () {
            $.ajax({
                url: 'departure/' + $(this).val() + '/getDetailProduct',
                method: 'GET',
                dataType: 'JSON',
                success: function (resp) {
                    dataProduct = resp.response;
                    $("#frmDetail #category_id").val(resp.response.category_id).trigger('change');
                    $("#frmDetail #value").val(resp.response.price_sf).formatNumber()
                    $("#frmDetail #quantityMax").html("(X " + parseInt(resp.response.units_sf) + ") Available: (" + resp.quantity + ")")


                }
            })
        });
        $("#btnDocument").click(function () {
            if ($("#frm #status_id").val() != 1) {

                $.ajax({
                    url: 'departure/generateInvoice/' + $("#frm #id").val(),
                    method: 'PUT',
                    dataType: 'JSON',
                    success: function (resp) {
                        if (resp.success == true) {
                            $("#frm #invoice").val(resp.consecutive);
                            $("#btnDocument").attr("disabled", true);
                        }
                    }
                })

                window.open("departure/" + $("#frm #id").val() + "/getInvoice");
            } else {
                toastr.error("error")
            }
        });

        $("#tabList").click(function () {
            table.ajax.reload();
        })
    }

    this.consecutive = function () {
        $.ajax({
            url: 'departure/1/consecutive',
            method: 'GET',
            dataType: 'JSON',
            success: function (resp) {
                $("#frm #consecutive").val(resp.response);
            }
        })
    }

    this.new = function () {
        toastr.remove();
        $("#btnSave").attr("disabled", false);
        $(".input-departure").cleanFields();
        $(".input-detail").cleanFields();
        $(".input-fillable").prop("readonly", false);
        $("#btnSave").prop("disabled", false);
        $("#tblDetail tbody").empty();
        $("#frm #status_id").val(0).trigger("change").prop("disabled", true);
        $("#frm #supplier_id").prop("disabled", false);
        $("#btnSave").prop("disabled", false);
        $("#frm #warehouse_id").getSeeker({default: true, api: '/api/getWarehouse', disabled: true});
        $("#frm #responsible_id").getSeeker({default: true, api: '/api/getResponsable', disabled: true});
        $("#frm #city_id").getSeeker({default: true, api: '/api/getCity', disabled: true});
        $("#btnmodalDetail").attr("disabled", false);
        listProducts = [];
        obj.consecutive();
    }

    this.getBranchAddress = function (id, path) {
        var url = 'departure/' + id + '/getBranch';
        if (path == undefined) {
            url = '../../departure/' + id + '/getBranch';
        }

        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'JSON',
            success: function (resp) {
                $("#frm #address").val(resp.response.address_invoice);
            }
        })
    }

    this.getClient = function (id, path) {
        var html = "";
        var url = 'departure/' + id + '/getClient';
        if (path == undefined) {
            url = '../../departure/' + id + '/getClient';
        }

        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'JSON',
            success: function (resp) {

                resp.data.client.name = (resp.data.client.name == null) ? '' : resp.data.client.name + " ";
                resp.data.client.last_name = (resp.data.client.last_name == null) ? '' : resp.data.client.last_name + " ";
                $("#frm #name_client").val(resp.data.client.name + resp.data.client.last_name + resp.data.client.business_name);

//                $("#frm #name_client").val(resp.response.name + " " + resp.response.last_name);
                $("#frm #address").val(resp.data.client.address);
                $("#frm #phone").val(resp.data.client.phone);

                $("#frm #destination_id").setFields({data: {destination_id: resp.data.client.city_id}});
                html = "<option value=0>Selection</option>";
                $.each(resp.data.branch, function (i, val) {
                    html += '<option value="' + val.id + '">' + val.address_invoice + "</option>";
                })

                $("#frm #branch_id").html(html);



            }
        })
    }

    this.send = function () {
        toastr.remove();
        var data = {}, btnEdit = true, btnDel = true;
        data.id = $("#frm #id").val()
        $.ajax({
            url: 'departure/setSale',
            method: 'POST',
            data: data,
            dataType: 'JSON',
            beforeSend: function () {
                $("#loading-super").removeClass("hidden");
            },
            success: function (resp) {
                if (resp.success == true) {
                    toastr.success("Sended");
                    $(".input-departure").setFields({data: resp.header, disabled: true});
                    $("#btnDocument").attr("disabled", false);

                    if (resp.header.status_id == 2) {
                        btnEdit = false;
                        btnDel = false;
                    }

                    obj.printDetail(resp.detail, btnEdit, btnDel);
                } else {
                    toastr.warning(resp.msg);
                    $("#btnDocument").attr("disabled", false);
                    $("#btnDocument").attr("disabled", true);
                }
            }, error: function (xhr, ajaxOptions, thrownError) {
                toastr.error(xhr.responseJSON.msg);
            },
            complete: function () {
                $("#loading-super").addClass("hidden");
            }
        })
    }

    this.save = function () {
        toastr.remove();
        $("#frm #warehouse_id").prop("disabled", false);
        $("#frm #responsible_id").prop("disabled", false);
        $("#frm #city_id").prop("disabled", false);
        var frm = $("#frm");
        var data = {};
        var url = "", method = "";
        var id = $("#frm #id").val();
        var msg = '';
        var validate = $(".input-departure").validate();

        if (validate.length == 0) {
            if ($("#id_orderext").val() == '') {
                if (listProducts.length > 0) {
                    data.header = $(".input-departure").getData();
                    data.detail = listProducts;

                    if (id == '') {
                        method = 'POST';
                        url = "departure";
                        msg = "Created Record";
                    } else {
                        method = 'PUT';
                        url = "departure/" + id;
                        msg = "Edited Record";
                    }

                    $.ajax({
                        url: url,
                        method: method,
                        data: data,
                        dataType: 'JSON',
                        beforeSend: function () {
                            $("#loading-super").removeClass("hidden");
                        },
                        success: function (data) {
                            if (data.success == true) {
                                $("#btnSend").attr("disabled", false);
                                $("#frm #id").val(data.data.id);
                                $(".input-departure").setFields({data: data.data, disabled: true});
                                table.ajax.reload();
                                toastr.success(msg);
                                $("#btnmodalDetail").attr("disabled", false);
                                obj.printDetail(data.detail);
                            }
                        },
                        complete: function () {
                            $("#loading-super").addClass("hidden");
                        }
                    })
                } else {
                    toastr.error("Detail empty");
                }
            } else {
                var param = {};
                param.id = $("#id_orderext").val();
                $.ajax({
                    url: "../../departure/storeExt",
                    method: 'POST',
                    data: data,
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.success == true) {
                            $(".input-departure").setFields({data: data.header})

                            toastr.success("ok");
                            $("#btnmodalDetail").attr("disabled", false);
                            location.href = "/departure";
                        }
                    }
                })
            }
        } else {
            toastr.error("input required");
        }
    }



    this.saveDetail = function () {
        toastr.remove();
        $("#frmDetail #departure_id").val($("#frm #id").val());

        var data = {}, value = 0, total = 0;
        var url = "", method = "";
        var id = $("#frmDetail #id").val();
        var form = $("#frmDetail").serialize()
        var msg = 'Record Detail';
        var validate = $(".input-detail").validate();

        if (validate.length == 0) {
            if (id != '') {
                var id = $("#frmDetail #id").val();

                var frm = $("#frmDetail");
                var data = frm.serialize();
                var url = "/departure/detail/" + id;
                $.ajax({
                    url: url,
                    method: "PUT",
                    data: data,
                    dataType: 'JSON',
                    success: function (resp) {
                        if (resp.success == true) {
                            $("#modalDetail").modal("hide");
                            obj.printDetail(resp.data);

                        }else{
                            toastr.error(resp.success.msg);
                        }
                    }, error(xhr, responseJSON, thrown) {
                        toastr.error(xhr.responseJSON.msg);
                    }
                })

            } else {
                if ($("#frmDetail #rowItem").val() == '-1') {

                    listProducts.push({
                        row: listProducts.length,
                        product_id: $("#frmDetail #product_id").val(),
                        product: $.trim($("#frmDetail #product_id").text()),
                        quantity: $("#frmDetail #quantity").val(),
                        valueFormated: $("#frmDetail #value").val(),
                        totalFormated: (dataProduct.price_sf * $("#frmDetail #quantity").val() * dataProduct.units_sf),
                        real_quantity: '',
                        totalFormated_real: '',
                        comment: '',
                        status: 'new'
                    });
//                    $(".input-detail").cleanFields();
                    $("#frmDetail #product_id").text("");
                    $("#frmDetail #value").val("");
//                    $("#frmDetail #value").val("");
                    msg += " add";
                } else {
                    listProducts[$("#frmDetail #rowItem").val()].quantity = $("#frmDetail #quantity").val();
                    listProducts[$("#frmDetail #rowItem").val()].totalFormated = dataProduct.price_sf * $("#frmDetail #quantity").val() * dataProduct.units_sf
                    msg += " edited";
                }


                toastr.success(msg);
                obj.printDetailTmp();
            }

        } else {
            toastr.error("input required");
        }
    }

    this.editItem = function (product_id, rowItem) {
        toastr.remove();
        $("#modalDetail").modal("show");
        obj.getItem(product_id);
        $("#frmDetail #rowItem").val(rowItem);
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

    this.printDetailTmp = function (data, btnEdit = true, btnDel = true) {
        var html = "", htmlEdit = "", htmlDel = "";
        $("#tblDetail tbody").html("");
        $.each(listProducts, function (i, val) {

            htmlEdit = '<button type="button" class="btn btn-xs btn-primary btnEditClass" onclick=obj.editItem(' + val.product_id + ',' + val.row + ')>Edit</button>'
            htmlDel = '<button type="button" class="btn btn-xs btn-primary btnEditClass" onclick=obj.deleteItem(' + val.product_id + ',' + val.row + ')>Edit</button>'

            val.real_quantity = (val.real_quantity != null) ? val.real_quantity : '';
            
            html += '<tr id="row_' + val.row + '">';
            html += "<td>" + val.product + "</td>";
            html += "<td>" + val.comment + "</td>";
            html += "<td>" + val.quantity + "</td>";
            html += "<td>" + val.valueFormated + "</td>";
            html += "<td>" + val.totalFormated + "</td>";
            html += "<td>" + val.real_quantity + "</td>";
            html += "<td>" + val.valueFormated + "</td>";
            html += "<td>" + val.totalFormated_real + "</td>";
            html += '<td>' + val.status + "</td>";
            html += '<td>' + htmlEdit + "</td>";
            html += "</tr>";
        });

        $("#tblDetail tbody").html(html);
    }

    this.deleteItem = function (product_id, rowItem) {
        delete listProducts[rowItem];
    }

    this.printDetail = function (data, btnEdit = true, btnDel = true) {
        var html = "", htmlEdit = "", htmlDel = "";
        $("#tblDetail tbody").empty();
        $.each(data, function (i, val) {
            if (btnEdit == true && val.status_id != 3) {
                htmlEdit = '<button type="button" class="btn btn-xs btn-primary btnEditClass" onclick=obj.editDetail(' + val.id + ')>Edit</button>'
            } else {
                htmlEdit = '';
            }
            if (btnDel == true && val.status_id != 3) {
                htmlDel = ' <button type="button" class="btn btn-xs btn-warning btnDeleteClass" onclick=obj.deleteDetail(' + val.id + ',' + val.status_id + ')>Delete</button>'
            } else {
                htmlDel = '';
            }

            val.real_quantity = (val.real_quantity != null) ? val.real_quantity : '';
            html += "<tr>";
            html += "<td>" + val.product + "</td>";
            html += "<td>" + val.comment + "</td>";
            html += "<td>" + val.quantity + "</td>";
            html += "<td>" + val.valueFormated + "</td>";
            html += "<td>" + val.totalFormated + "</td>";
            html += "<td>" + val.real_quantity + "</td>";
            html += "<td>" + val.valueFormated + "</td>";
            html += "<td>" + val.totalFormated_real + "</td>";
            html += '<td>' + val.status + "</td>";
            html += '<td>' + htmlEdit + htmlDel + "</td>";
            html += "</tr>";
        });
        $("#tblDetail tbody").html(html);
    }

    this.showModal = function (id) {
        var frm = $("#frmEdit"), btnEdit = true, btnDel = true;
        var data = frm.serialize();
        var url = "/departure/" + id + "/edit";
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $('#myTabs a[href="#management"]').tab('show');
                $(".input-departure").setFields({data: data.header, disabled: true});
                if (data.header.id != '') {
                    $("#btnmodalDetail").attr("disabled", false);
                }

                if (data.header.invoice == '') {
                    $("#btnDocument").attr("disabled", false);
                }

                if (data.header.status_id == 1) {
                    $("#btnSave, #btnmodalDetail").attr("disabled", true);
                }

                if (data.header.status_id == 2) {
                    $("#btnSend, #btnmodalDetail").attr("disabled", true);
                    btnEdit = false;
                    btnDel = false;
                } else {
                    $("#btnSend,#btnmodalDetail").attr("disabled", false);
                }

                obj.printDetail(data.detail, btnEdit, btnDel);
            }
        })
    }

    this.infomationExt = function (id) {
        var frm = $("#frmEdit");
        var data = frm.serialize();
        var url = "/departure/" + id + "/editExt";
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {

                $('#myTabs a[href="#management"]').tab('show');
                $(".input-departure").setFields({data: data.header});
                if (data.header.id != '') {
                    $("#btnmodalDetail").attr("disabled", false);
                }

                obj.printDetail(data.detail);
            }
        })
    }

    this.editDetail = function (id) {
        $("#frmDetail #departure_id").val($("#frm #id").val());
        var frm = $("#frm");
        var data = frm.serialize();
        var url = "/departure/" + id + "/detail";
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (resp) {
                $("#modalDetail").modal("show");
                $(".input-detail").setFields({data: resp})
            }, error(xhr, responseJSON, thrown) {
                console.log(responseJSON)
            }
        })
    }

    this.confirmItem = function () {
        var id = $("#frmDetail #id").val();

        var frm = $("#frmDetail");
        var data = frm.serialize();
        var url = "/departure/detail/" + id;
        $.ajax({
            url: url,
            method: "PUT",
            data: data,
            dataType: 'JSON',
            success: function (resp) {
                $("#modalDetail").modal("show");
                $(".input-detail").setFields({data: resp})
            }, error(xhr, responseJSON, thrown) {
                toastr.error(xhr.responseJSON.msg);
            }
        })
    }



    this.delete = function (id) {
        toastr.remove();
        if (confirm("Deseas eliminar")) {
            var token = $("input[name=_token]").val();
            var url = "/departure/" + id;
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

    this.deleteDetail = function (id, status_id) {
        toastr.remove();
        if (status_id == 1) {
            if (confirm("Do you want delete this record?")) {
                var token = $("input[name=_token]").val();
                var url = "/departure/detail/" + id;
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
        } else {
            toastr.error("No se puede borrra Este registro");
        }
    }

    this.table = function () {
        table = $('#tbl').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/api/listDeparture",
            columns: [
                {
                    className: 'details-control',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                    searchable: false,
                },
                {data: "consecutive"},
                {data: "invoice"},
                {data: "created_at"},
                {data: "client"},
                {data: "responsible"},
                {data: "warehouse"},
                {data: "city"},
                {data: "status"},
            ],
            order: [[2, 'DESC']],
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
            ],
            initComplete: function () {
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
                    $('td', row).eq(7).addClass('color-new');
                } else if (data.status_id == 2) {
                    $('td', row).eq(7).addClass('color-pending');
                } else if (data.status_id == 3) {
                    $('td', row).eq(7).addClass('color-checked');
                }
            }
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
        var url = "/departure/" + d.id + "/detailAll";
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

var obj = new Sale();
obj.init();