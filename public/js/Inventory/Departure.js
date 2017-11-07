function Departure() {
    var table, maxDeparture = 0, listProducts = [], dataProduct, row = {}, rowItem, statusRecord = false, client_id = null;
    this.init = function () {
        table = this.table();
        $("#btnNew").click(this.new);
        $("#btnSave").click(this.save);
        $("#btnCancel").click(this.cancelInvoice);
        $("#newDetail").click(this.saveDetail);
        $("#newService").click(this.saveService);
        $("#btnSend").click(this.send);
        $(".form_datetime").datetimepicker({format: 'Y-m-d h:i'});
        $(".form_date").datetimepicker({format: 'Y-m-d'});
        $("#edit").click(this.edit);
        $("#tabManagement").click(function () {
            $('#myTabs a[href="#management"]').tab('show');
        });
        $("#btnFilter").click(function () {
            table = obj.table();

        })

        $("#frm #client_id").on('select2:closing', function (evt) {
            if ($(this).val() != 0) {
                client_id = $(this).val();
                $("#btnModalUpload,#btnmodalDetail").attr("disabled", false);
                obj.getClient($(this).val());
            } else {
                $("#frm #name_client").val("");
                $("#frm #address_supplier").val("");
                $("#frm #phone_supplier").val("");
            }
        })


        $("#branch_id").change(function () {

            if ($(this).val() != 0 && $(this).val() != null) {
                obj.getBranchAddress($(this).val());
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
            $("#btnmodalDetail,#btnModalUpload").attr("disabled", true);
//            $("#btnDocument").attr("disabled", true);
            $(".input-fillable").attr("disabled", true);
            $("#frm #warehouse_id").getSeeker({default: true, api: '/api/getWarehouse', disabled: true});
            $("#frm #responsible_id").getSeeker({default: true, api: '/api/getResponsable', disabled: true});
            $("#frm #city_id").getSeeker({default: true, api: '/api/getCity'});
            $("#frm #status_id").val(1).trigger('change');
            $("#frm #status_id").prop("disabled", true);
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
        $("#btnModalServices").click(function () {
            $("#modalService").modal("show");
            $(".input-service").cleanFields();
            $("#frmServices #rowItem").val(-1);
        });

        $("#frmDetail #product_id").change(function () {
            var param = {};
            client_id = (client_id == null) ? $("#frm #client_id :selected").val() : client_id;

            param.client_id = client_id;
            $.ajax({
                url: 'departure/' + $(this).val() + '/getDetailProduct',
                method: 'GET',
                data: param,
                dataType: 'JSON',
                success: function (resp) {
                    dataProduct = resp.response;
                    $("#frmDetail #category_id").val(resp.response.category_id).trigger('change');
                    $("#frmDetail #value").val(resp.response.price_sf).formatNumber()
                    $("#frmDetail #quantityMax").html("(X " + parseInt(resp.response.units_sf) + ") Available: (" + resp.quantity + ")")


                }
            })
        });

        $("#frmServices #product_id").change(function () {
            var param = {};
            client_id = (client_id == null) ? $("#frm #client_id :selected").val() : client_id;
            param.client_id = client_id;

            $.ajax({
                url: 'departure/' + $(this).val() + '/getDetailProduct',
                method: 'GET',
                data: param,
                dataType: 'JSON',
                success: function (resp) {
                    dataProduct = resp.response;
                    $("#frmServices #value").val(resp.response.price_sf).formatNumber()


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
            $("#loading-super").addClass("hidden");
        })


        $("#btnModalUpload").click(function () {
            $("#modalUpload").modal("show");
        })

        $("#uploadRequest").click(this.uploadExcel)
        $("#btnReverse").click(this.reverse)

        $("#col-dispatched").click(function (e) {
            e.preventDefault();
            // Get the column API object
            var column = table.column($(this).attr('data-column'));
            // Toggle the visibility
            column.visible(!column.visible());
        })

        $("#col-business_name").click(function (e) {
            e.preventDefault();
            // Get the column API object
            var column = table.column($(this).attr('data-column'));
            // Toggle the visibility
            column.visible(!column.visible());
        })
    }


    this.reverse = function () {
        toastr.remove()
        $.ajax({
            url: 'departure/' + $("#frm #id").val() + '/reverseInvoice',
            method: 'PUT',
            dataType: 'JSON',
            success: function (data) {
                $(".input-departure").setFields({data: data.header});
                toastr.success("Factura reversada!");
            }, error: function (xhr, ajaxOptions, thrownError) {
                toastr.error(xhr.responseJSON.msg);
            },
        })
    }

    this.cancelInvoice = function () {
        toastr.remove()
        var param = {};
        param.description = $("#frmCancel #description").val();
        if ($("#frmCancel #description").val() != '') {
            $.ajax({
                url: 'departure/' + $("#frmCancel #departure_id").val() + '/cancelInvoice',
                method: 'PUT',
                data: param,
                dataType: 'JSON',
                success: function (resp) {
                    $("#modalCancel").modal("hide");
                    toastr.warning("Factura cancelada!");
                    table.ajax.reload();
                }, error: function (xhr, ajaxOptions, thrownError) {
                    toastr.error(xhr.responseJSON.msg);
                },
            })
        } else {
            toastr.error("Necesitas dar una justificación!");
        }

    }


    this.modalCancel = function (id) {
        $("#modalCancel").modal("show");
        $("#frmCancel #departure_id").val(id);
    }

    this.uploadExcel = function () {
        $("#frmUpload #client_id").val($("#frm #client_id :selected").val());
        var formData = new FormData($("#frmUpload")[0]);
        $.ajax({
            url: 'departure/uploadExcel',
            method: 'POST',
            data: formData,
            dataType: 'JSON',
            processData: false,
            cache: false,
            contentType: false,
            success: function (data) {
                listProducts = data.data;
                obj.printDetailTmp(data);
            },
            complete: function () {
                $("#modalUpload").modal("hide");
            }
        })

    }


    this.new = function () {
        toastr.remove();
        $("#loading-super").addClass("hidden");
        client_id = null;
        $("#btnSave").attr("disabled", false);
        $("#btnmodalDetail, #btnModalUpload").attr("disabled", true);
        $(".input-departure").cleanFields();
        $(".input-detail").cleanFields();
        $(".input-fillable").prop("readonly", false);
        $("#btnSend,#btnPdf").prop("disabled", true);
        $("#tblDetail tbody").empty();
        $("#frm #status_id").val(0).trigger("change").prop("disabled", true);
        $("#frm #supplier_id").prop("disabled", false);
        $("#frm #warehouse_id").getSeeker({default: true, api: '/api/getWarehouse'});
        $("#frm #responsible_id").getSeeker({default: true, api: '/api/getResponsable', disabled: true});
        $("#frm #city_id").getSeeker({default: true, api: '/api/getCity'});

        listProducts = [];
        statusRecord = false;
    }

    this.getBranchAddress = function (id) {

        var url = PATH + '/departure/' + id + '/getBranch';

        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'JSON',
            success: function (resp) {
                $("#frm #destination_id").setFields({data: {destination_id: resp.response.send_city_id}});
                $("#frm #address").val(resp.response.address_invoice);
            }
        })
    }

    this.getClient = function (id, branch_id) {
        var url = PATH + '/departure/' + id + '/getClient';


        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'JSON',
            success: function (resp) {
                $("#frm #name_client").val(resp.data.client.business_name);
//                $("#frm #name_client").val(resp.response.name + " " + resp.response.last_name);
                $("#frm #address").val(resp.data.client.address_send);
                if (resp.data.client.phone != '') {
                    $("#frm #phone").val(resp.data.client.phone);
                }

                $("#frm #destination_id").setFields({data: {destination_id: resp.data.client.send_city_id}});
                $("#frm #responsible_id").setFields({data: {responsible_id: resp.data.client.responsible_id}});


                if ((resp.data.briefcase).length > 0) {
                    $("#frm #novelty").val("Novedades en cartera");
                } else {
                    $("#frm #novelty").val("Ok");
                }

                obj.loadSelectBranch(resp.data.branch, branch_id)
            }
        })
    }

    this.loadSelectBranch = function (data, selected_id) {

        var html = "<option value=0>Selection</option>";
        selected_id = selected_id | null;
        var selected = '';

        $.each(data, function (i, val) {
            val.business = (val.business == null) ? '' : val.business;
            selected = (val.id == selected_id) ? 'selected' : '';
            html += '<option value="' + val.id + '" ' + selected + '>' + val.business + ' ' + val.address_invoice + "</option>";
        })

        $("#frm #branch_id").html(html);

        if (selected_id != null) {
            $.ajax({
                url: 'departure/' + selected_id + '/getBranch',
                method: 'GET',
                dataType: 'JSON',
                success: function (resp) {
                    if (resp.response != null) {
                        $("#frm #address").val(resp.response.address_send);
                        if (resp.response.phone != null) {
                            $("#frm #phone").val(resp.response.phone);
                        }

                        $("#frm #destination_id").setFields({data: {destination_id: resp.response.send_city_id}});
                        $("#frm #responsible_id").setFields({data: {responsible_id: resp.response.responsible_id}});
                    }
                }
            })
        }
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
                    obj.printDetail(resp, btnEdit, btnDel);
                    $("#btnmodalDetail").attr("disabled", true);
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
        $("#btnSave").attr("disabled", true);
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
                                statusRecord = true;
                                $("#btnSend").attr("disabled", false);
                                $("#frm #id").val(data.header.id);
                                $(".input-departure").setFields({data: data.header, disabled: true});
                                table.ajax.reload();
                                toastr.success(msg);
                                $("#loading-super").addClass("hidden");
                                $("#btnmodalDetail").attr("disabled", false);
                                obj.printDetail(data);
                            }

                        }, error: function (xhr, ajaxOptions, thrownError) {
                            toastr.error("Wrong");
                        }
                    })
                } else {
                    $("#btnSave").attr("disabled", false);
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
                            obj.printDetail(data);
                        }
                    }
                })
            }
        } else {
            $("#btnSave").attr("disabled", false);
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
                            obj.printDetail(resp);
                            $("#frmDetail #product_id").text("");
                            $("#frmDetail #value").val("");
                            $("#frmDetail #quantity").val("");
                            $("#frmDetail #quantity_units").val("");
                            $("#frmDetail #value_units").val("");
                        } else {
                            toastr.error(resp.success.msg);
                        }
                    }, error(xhr, responseJSON, thrown) {
                        toastr.error(xhr.responseJSON.msg);
                    }
                })

            } else {
                if (statusRecord == true) {
                    var frm = $("#frmDetail");
                    var data = frm.serialize();
                    var url = "/departure/storeDetail";
                    $.ajax({
                        url: url,
                        method: "POST",
                        data: data,
                        dataType: 'JSON',
                        success: function (resp) {
                            if (resp.success == true) {
                                $("#modalDetail").modal("hide");
                                obj.printDetail(resp);
                                $("#frmDetail #product_id").text("");
                                $("#frmDetail #value").val("");
                                $("#frmDetail #quantity").val("");
                                $("#frmDetail #quantity_units").val("");
                                $("#frmDetail #value_units").val("");
                            } else {
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
                            price_tax: dataProduct.price_sf * dataProduct.units_sf * dataProduct.tax,
                            price_sf: dataProduct.price_sf,
                            units_sf: parseFloat(dataProduct.units_sf),
                            quantity: $("#frmDetail #quantity").val(),
                            valueFormated: $("#frmDetail #value").val(),
                            totalFormated: (dataProduct.price_sf * $("#frmDetail #quantity").val() * dataProduct.units_sf),
                            total: (dataProduct.price_sf * $("#frmDetail #quantity").val() * dataProduct.units_sf) + (dataProduct.price_sf * dataProduct.units_sf * $("#frmDetail #quantity").val() * dataProduct.tax),
                            real_quantity: '',
                            totalFormated_real: '',
                            comment: '',
                            status: 'new'
                        });
                        //                    $(".input-detail").cleanFields();
                        $("#frmDetail #product_id").text("");
                        $("#frmDetail #value").val("");
                        $("#frmDetail #quantity").val("");
                        $("#frmDetail #quantity_units").val("");
                        $("#frmDetail #value_units").val("");
//                    $("#frmDetail #value").val("");
                        msg += " add";
                    } else {
                        listProducts[$("#frmDetail #rowItem").val()].quantity = $("#frmDetail #quantity").val();
                        listProducts[$("#frmDetail #rowItem").val()].totalFormated = dataProduct.price_sf * $("#frmDetail #quantity").val() * dataProduct.units_sf
                        msg += " edited";
                    }
                    obj.printDetailTmp();
                }


                toastr.success(msg);
            }

        } else {
            toastr.error("input required");
        }
    }
    this.saveService = function () {
        toastr.remove();
        $("#frmServices #departure_id").val($("#frm #id").val());
        var data = {}, value = 0, total = 0;
        var url = "", method = "";
        var id = $("#frmServices #id").val();
        var form = $("#frmServices").serialize()
        var msg = 'Record Detail';
        var validate = $(".input-service").validate();
        if (validate.length == 0) {
            if (id != '') {
                var id = $("#frmServices #id").val();
                var frm = $("#frmServices");
                var data = frm.serialize();
                var url = "/departure/detail/" + id;
                $.ajax({
                    url: url,
                    method: "PUT",
                    data: data,
                    dataType: 'JSON',
                    success: function (resp) {
                        if (resp.success == true) {
                            $("#modalService").modal("hide");
                            obj.printDetail(resp);
                            $("#frmServices #product_id").text("");
                            $("#frmServices #value").val("");
                        } else {
                            toastr.error(resp.success.msg);
                        }
                    }, error(xhr, responseJSON, thrown) {
                        toastr.error(xhr.responseJSON.msg);
                    }
                })

            } else {
                if (statusRecord == true) {
                    var frm = $("#frmServices");
                    var data = frm.serialize();
                    var url = "/departure/storeDetail";
                    $.ajax({
                        url: url,
                        method: "POST",
                        data: data,
                        dataType: 'JSON',
                        success: function (resp) {
                            if (resp.success == true) {
                                $("#modalService").modal("hide");
                                obj.printDetail(resp);
                                $("#frmServices #product_id").text("");
                                $("#frmServices #value").val("");
                            } else {
                                toastr.error(resp.success.msg);
                            }
                        }, error(xhr, responseJSON, thrown) {
                            toastr.error(xhr.responseJSON.msg);
                        }
                    })
                } else {
                    if ($("#frmServices #rowItem").val() == '-1') {
                        listProducts.push({
                            row: listProducts.length,
                            product_id: $("#frmServices #product_id").val(),
                            product: $.trim($("#frmServices #product_id").text()),
                            price_tax: dataProduct.price_sf * dataProduct.units_sf * dataProduct.tax,
                            price_sf: dataProduct.price_sf,
                            units_sf: parseFloat(dataProduct.units_sf),
                            quantity: 1,
                            valueFormated: $("#frmServices #value").val(),
                            totalFormated: (dataProduct.price_sf * 1 * dataProduct.units_sf),
                            total: (dataProduct.price_sf * $("#frmDetail #quantity").val() * dataProduct.units_sf) + (dataProduct.price_sf * dataProduct.units_sf * 1 * dataProduct.tax),
                            real_quantity: '',
                            totalFormated_real: '',
                            comment: '',
                            status: 'new'
                        });

                        $("#frmDetail #product_id").text("");
                        $("#frmDetail #value").val("");
                        msg += " add";
                    } else {
                        listProducts[$("#frmServices #rowItem").val()].quantity = 1;
                        listProducts[$("#frmServices #rowItem").val()].totalFormated = dataProduct.price_sf * 1 * dataProduct.units_sf;
                        msg += " edited";
                    }
                    obj.printDetailTmp();
                }


                toastr.success(msg);
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
        var html = "", htmlEdit = "", htmlDel = "", total = 0;
        $("#tblDetail tbody").html("");
        $.each(listProducts, function (i, val) {

            if (val != undefined) {
                total += val.total;
                htmlEdit = '<button type="button" class="btn btn-xs btn-primary" onclick=obj.editItem(' + val.product_id + ',' + val.row + ')>Edit</button>'
                htmlDel = '<button type="button" class="btn btn-xs btn-danger" onclick=obj.deleteItem(' + val.product_id + ',' + val.row + ')>Del</button>'

                val.real_quantity = (val.real_quantity != null) ? val.real_quantity : '';
                html += '<tr id="row_' + val.row + '">';
                html += "<td>" + val.product + "</td>";
                html += "<td>" + val.comment + "</td>";
                html += "<td>" + val.units_sf + "</td>";
                html += "<td>" + val.quantity + "</td>";
                html += "<td>" + val.valueFormated + "</td>";
                html += "<td>" + val.totalFormated + "</td>";
                html += "<td>" + val.real_quantity + "</td>";
                html += "<td>" + val.valueFormated + "</td>";
                html += "<td>" + val.totalFormated_real + "</td>";
                html += '<td>' + val.status + "</td>";
                html += '<td>' + htmlEdit + htmlDel + "</td>";
                html += "</tr>";
            }
        });

        total = (data == undefined) ? total : data.total;

        html += '<tr><td colspan="4">Total</td><td>' + total + '</td></tr>';
        $("#tblDetail tbody").html(html);
    }

    this.deleteItem = function (product_id, rowItem) {
        delete listProducts[rowItem];
        $("#row_" + rowItem).remove();
    }

    this.printDetail = function (data, btnEdit = true, btnDel = true) {
        var html = "", htmlEdit = "", htmlDel = "", quantityTotal = 0, total = 0;
        $("#tblDetail tbody").empty();
        $.each(data.detail, function (i, val) {

            quantityTotal += val.quantity;
            total += val.total;
            if (val.status_id == 3 && $("#role_id").val() == 4) {
                htmlEdit = '';
            } else {
                if (data.header.status_id == 2) {
                    htmlEdit = '';
                } else {
                    htmlEdit = '<button type="button" class="btn btn-xs btn-primary btnEditClass" onclick=obj.editDetail(' + val.id + ')>Edit</button>';
                }
            }

            if ((btnDel == true && val.status_id != 3) || btnDel == true) {
                htmlDel = ' <button type="button" class="btn btn-xs btn-warning btnDeleteClass" onclick=obj.deleteDetail(' + val.id + ',' + val.status_id + ')>Delete</button>'
            } else {
                htmlDel = '';
            }

            val.real_quantity = (val.real_quantity != null) ? val.real_quantity : '';
            html += "<tr>";
            html += "<td>" + val.product + "</td>";
            html += "<td>" + val.comment + "</td>";
            html += "<td>" + val.units_sf + "</td>";
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
        html += '<tr><td colspan="3"><Strong>Total</strong></td><td>' + quantityTotal + '</td><td></td><td>' + data.total + '</td><td></td><td></td><td></td><td></td></tr>';
        $("#tblDetail tbody").html(html);
    }

    this.showModal = function (id) {
        $("#loading-super").addClass("hidden");
        var frm = $("#frmEdit"), btnEdit = true, btnDel = true;
        var data = frm.serialize(), status = false;
        var url = "/departure/" + id + "/edit";
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $('#myTabs a[href="#management"]').tab('show');

                if (data.header.status_id == 2) {
                    status = true;
                }

                $(".input-departure").setFields({data: data.header, status: status});
                if (data.header.id != '') {
                    $("#btnmodalDetail").attr("disabled", false);
                }


                if (data.header.status_id == 1) {
                    statusRecord = true;
                    btnDel = true;
                }
                if (data.header.status_id != 1) {
                    $("#btnmodalDetail").attr("disabled", true);
                }

                if (data.header.status_id == 2) {
                    $("#btnSend, #btnmodalDetail").attr("disabled", true);
                    btnEdit = false;
                    btnDel = false;
                    statusRecord = false;
                } else {
                    $("#btnSend,#btnmodalDetail").attr("disabled", false);
                }


                listProducts = data.detail;

                if ($("#role_id").val() == 1 || $("#role_id").val() == 5) {
                    btnEdit = true;
                    btnDel = true;
                }

//                if ($("#role_id").val() == 1) {
                $("#frm #shipping_cost").attr("disabled", false);
                $("#frm #description").attr("disabled", false);
//                }

                obj.getClient(data.header.client_id, data.header.branch_id);

                obj.printDetail(data, btnEdit, btnDel);
            },
            error(xhr, responseJSON, thrown) {

                if (thrown == 'Unauthorized') {
                    location.href = "/";
                }


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
                toastr.error(responseJSON.msg)

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
                        $("#loading-super").addClass("hidden");
                    }
                }, error: function (xhr, ajaxOptions, thrownError) {
                    toastr.error(xhr.responseJSON.msg);
                },
            })
        }

    }

    this.deleteDetail = function (id, status_id) {
        toastr.remove();

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
                        obj.printDetail(data);
                    }
                }, error: function (err) {
                    toastr.error("No se puede borrar Este registro");
                }
            })
        }
    }


    this.tempInvoice = function (id) {
        if (confirm("¿Deseas crear una remisión?")) {
            $.ajax({
                url: 'departure/generateRemission/' + id,
                method: 'PUT',
                dataType: 'JSON',
                success: function (resp) {
                    if (resp.success == true) {
                        table.ajax.reload();
                        window.open("departure/" + id + "/getRemission");
                    }
                }
            })


        }
    }

    this.viewRemission = function (id) {
        window.open("departure/" + id + "/getRemission");
    }


    this.table = function () {
        var param = {};

        param.supplier_id = $("#frm #supplier_id").val();
        param.client_id = $("#frm #client_id").val();
        param.commercial_id = $("#frm #commercial_id").val();

        param.init = $("#frm #init").val();
        param.end = $("#frm #end").val();

        param.init_filter = $("#finit_filter").val();
        param.end_filter = $("#fend_filter").val();
        param.client_filter = $("#client_filter").val();
        param.responsible_filter = $("#responsible_filter").val();
        param.id_filter = $("#id_filter").val();
        param.invoice_filter = $("#invoice_filter").val();
        
        var html = '';
        table = $('#tbl').DataTable({
            "dom":
                    "R<'row'<'col-sm-4'l><'col-sm-2 toolbar text-right'><'col-sm-3'B><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12't>>" +
                    "<'row'<'col-xs-3 col-sm-3 col-md-3 col-lg-3'i><'col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center'p><'col-xs-3 col-sm-3 col-md-3 col-lg-3'>>",
            "processing": true,
            "serverSide": true,
            destroy: true,
            ajax: {
                url: "/api/listDeparture",
                data: param,
                beforeSend: function (request) {
                    $("#loading-super").removeClass("hidden");
                }
            },
            "lengthMenu": [[30, 100, 300, -1], [30, 100, 300, 'All']],
            columns: [
                {
                    className: 'details-control',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                    searchable: false,
                },
                {data: "id"},
                {data: "invoice"},
                {data: "created_at"},
                {data: "dispatched", "visible": false, },
                {data: "client"},
                {data: "business_name", "visible": false},
                {data: "responsible"},
                {data: "warehouse"},
                {data: "city"},
                {data: "quantity"},
                {data: "credit_note", render: $.fn.dataTable.render.number(',', '.', 0)},
                {data: "subtotalnumeric", render: function (data, type, row) {
                        var total = (row.status_id == 1) ? row.subtotalnew : row.subtotalnumeric;
                        total = parseFloat(total)
                        return obj.formatCurrency(total, '$')
                    }
                },
                {data: "total", render: function (data, type, row) {
                        var total = (row.status_id == 1) ? row.totalnew : row.total;
                        total = parseFloat(total);
                        return obj.formatCurrency(total, '$')
                    }
                },
                {data: "status"},
                {data: "total", render: function (data, type, row) {
                        if (row.status_id == 5) {
                            html = '<i style="cursor:pointer" class="fa fa-file-pdf-o" aria-hidden="true" onclick="obj.viewRemission(' + row.id + ')"></i>';
                        } else {
                            if (row.status_id != 1 && row.status_id != 8) {

                                html = '<img src="' + PATH + '/assets/images/pdf_23.png" style="cursor:pointer" onclick="obj.viewPdf(' + row.id + ')" title="Ver Factura">';
                                if (row.status_id != 4) {
                                    html += '&nbsp;&nbsp;<span style="cursor:pointer" class="fa-stack" onclick="obj.modalCancel(' + row.id + ')" title="Anular Factura"><i class="fa fa-stack-1x fa-file-pdf-o"></i><i class="fa fa-ban fa-stack-2x text-danger"></i></span>';
                                }
                            } else if (row.status_id == 8) {
                                html = '<i style="cursor:pointer" class="fa fa-trash fa-lg" aria-hidden="true" onclick="obj.delete(' + row.id + ')" title="Borrar Orden"></i>';
                            } else {
                                html = '<i style="cursor:pointer" class="fa fa-trash fa-lg" aria-hidden="true" onclick="obj.delete(' + row.id + ')" title="Borrar Orden"></i>&nbsp;&nbsp;<i style="cursor:pointer" class="fa fa-file-text fa-lg" aria-hidden="true" onclick="obj.tempInvoice(' + row.id + ')" title="Generar Remisión"></i>';
                            }
                        }
                        return html;

                    }
                },
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
            order: [[1, 'DESC']],
            aoColumnDefs: [
                {
                    aTargets: [1, 2, 3, 4, 5, 6, 7, 8, 9],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.showModal(' + full.id + ')">' + data + '</a>';
                    }
                },
            ], initComplete: function () {
                $("#loading-super").addClass("hidden");
            },

            createdRow: function (row, data, index) {
                if (data.status_id == 1) {
                    $('td', row).eq(12).addClass('color-new');
                } else if (data.status_id == 2) {
                    $('td', row).eq(12).addClass('color-pending');
                } else if (data.status_id == 3) {
                    $('td', row).eq(12).addClass('color-checked');
                } else if (data.status_id == 7) {
                    $('td', row).eq(12).addClass('color-green');
                } else if (data.status_id == 8) {
                    $('td', row).eq(12).addClass('color-red');
                }
            },
            footerCallback: function (row, data, start, end, display) {
                var api = this.api(), data, subtotal, total, quantity = 0, note = 0;

                var intVal = function (i) {
                    return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                };

                quantity = api
                        .column(10)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                note = api
                        .column(11)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                subtotal = api
                        .column(12)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                total = api
                        .column(13)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                // Update footer
                $(api.column(10).footer()).html(
                        '(' + quantity + ')'
                        );


                $(api.column(11).footer()).html(
                        '(' + obj.formatCurrency(note, '$') + ')'
                        );

                $(api.column(12).footer()).html(
                        '(' + obj.formatCurrency(subtotal, '$') + ')'
                        );


                $(api.column(13).footer()).html(
                        '(' + obj.formatCurrency(total, "$") + ')'

                        );

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

    this.formatCurrency = function (n, currency) {
        return currency + " " + n.toFixed(2).replace(/./g, function (c, i, a) {
            return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
        });
    }


    this.viewPdf = function (id) {
        window.open(PATH + "/departure/" + id + "/getInvoice");
    }

    this.format = function (d) {
        var url = "/departure/" + d.id + "/detailAll";
        var html = '<br><table class="table-detail">';
        html += '<thead><tr><th colspan="3">Information</th><th colspan="3" class="center-rowspan">Orden</th>'
        html += '<th colspan="3" class="center-rowspan">Despachado</th></tr>'
        html += '<tr><th>#</th><th>Producto</th><th>Iva</th><th>Cantidad</th><th>Unit</th><th>Total</th><th>Cantidad</th><th>Unidades</th><th>Total</th></tr></thead>';
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
                    html += "<td>" + val.real_quantity + "</td>";
                    html += "<td>" + val.valueFormated + "</td>";
                    html += "<td>" + val.totalFormated_real + "</td>";
                    html += "</tr>";
                });
                if (data.exento != '$ 0') {
                    html += '<tr><td colspan="5" align="right"><b>Exento</b></td><td>' + data.exento + '</td><td></td><td></td><td>' + data.exento_real + '</td><tr>';
                }
                if (data.tax5 != '$ 0') {
                    html += '<tr><td colspan="5" align="right"><b>Iva 5%</b></td><td>' + data.tax5 + '</td><td></td><td></td><td>' + data.tax5_real + '</td><tr>';
                }
                html += '<tr><td colspan="5" align="right"><b>Iva 19%</b></td><td>' + data.tax19 + '</td><td></td><td></td><td>' + data.tax19_real + '</td><tr>';
                if (data.discount != '$ 0') {
                    html += '<tr><td colspan="5" align="right"><b>Descuento</b></td><td>' + data.discount + '</td><td></td><td></td><td>' + data.discount + '</td><tr>';
                }
                if (data.shipping_cost != '$ 0') {
                    html += '<tr><td colspan="5" align="right"><b>Descuento</b></td><td>' + data.shipping_cost + '</td><td></td><td></td><td>' + data.shipping_cost + '</td><tr>';
                }

                html += '<tr><td colspan="5" align="right"><b>Subtotal</b></td><td>' + data.subtotal + '</td><td></td><td></td><td>' + data.subtotal_real + '</td><tr>';
                html += '<tr><td colspan="5" align="right"><b>Total</b></td><td>' + data.total + '</td><td></td><td></td><td>' + data.total_real + '</td><tr>';
                html += "</tbody></table><br>";
            }
        })
        return html;
    }

}

var obj = new Departure();
obj.init();