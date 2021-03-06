function Sale() {
    var table, maxDeparture = 0, listProducts = [], dataProduct, row = {}, rowItem, statusRecord = false, client_id = null;
    var quantity_total = 0;


    this.init = function () {
        table = this.table();
        $("#btnNew").click(this.new);
        $("#btnSave").click(this.save);
        $("#btnCancel").click(this.cancelInvoice);
        $("#newDetail").click(this.saveDetail);
        $("#newService").click(this.saveService);
        $("#btnSend").click(this.send);
        $(".form_datetime").datetimepicker({format: 'Y-m-d h:i'});
        $("#edit").click(this.edit);
        $("#tabManagement").click(function () {
            $('#myTabs a[href="#management"]').tab('show');
        });

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

//        $("#frm #client_id").change(function () {
//            if ($(this).val() != 0) {
//                client_id = $(this).val();
//                $("#btnModalUpload,#btnmodalDetail").attr("disabled", false);
//                obj.getClient($(this).val());
//            } else {
//                $("#frm #name_client").val("");
//                $("#frm #address_supplier").val("");
//                $("#frm #phone_supplier").val("");
//            }
//        });

        $("#branch_id").change(function () {
            if ($(this).val() != 0) {
                obj.getBranchAddress($(this).val());
            } else {

            }
        });


        $("#quantity").change(function () {
            $("#quantity_units").val(dataProduct.cost_sf * $(this).val());
            $("#value_units").val($.formatNumber(dataProduct.cost_sf))
        });
        if ($("#id_orderext").val() != '') {
            obj.infomationExt($("#id_orderext").val(), true);
        }

        $("#insideManagement").click(function () {
            $(".input-sample").cleanFields({disabled: true});
            $("#btnSend").attr("disabled", true);
            $("#btnSave").attr("disabled", true);
            $("#btnmodalDetail,#btnModalUpload").attr("disabled", true);
//            $("#btnDocument").attr("disabled", true);
            $(".input-fillable").attr("disabled", true);
            $("#frm #warehouse_id").getSeeker({default: true, api: '/api/getWarehouse', disabled: true});
            $("#frm #responsible_id").getSeeker({default: true, api: '/api/getResponsable', disabled: true});
            $("#frm #city_id").getSeeker({default: true, api: '/api/getCity', disabled: true});
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
                    $("#frmDetail #value").val($.formatNumber((resp.response.cost_sf / resp.response.packaging)))
                    $("#frmDetail #quantityMax").html("(X " + parseInt(resp.response.cost_sf) + ") Available: (" + resp.quantity + ")")
                }
            })
        });

        $("#frmServices #product_id").change(function () {
            var param = {};
            client_id = (client_id == null) ? $("#frm #client_id :selected").val() : client_id;
            param.client_id = client_id;

            $.ajax({
                url: 'sample/' + $(this).val() + '/getDetailProduct',
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

//                $.ajax({
//                    url: 'sample/generateInvoice/' + $("#frm #id").val(),
//                    method: 'PUT',
//                    dataType: 'JSON',
//                    success: function (resp) {
//                        if (resp.success == true) {
//                            $("#frm #invoice").val(resp.consecutive);
//                            $("#btnDocument").attr("disabled", true);
//                        }
//                    }
//                })

                window.open("sample/" + $("#frm #id").val() + "/getInvoice");
            } else {
                toastr.error("error")
            }
        });

        $("#tabList").click(function () {
            table.ajax.reload();
        })


        $("#btnModalUpload").click(function () {
            $("#modalUpload").modal("show");
        })

        $("#uploadRequest").click(this.uploadExcel)
        $("#btnReverse").click(this.reverse)

    }


    this.reverse = function () {
        toastr.remove()
        $.ajax({
            url: 'sample/' + $("#frm #id").val() + '/reverseInvoice',
            method: 'PUT',
            dataType: 'JSON',
            success: function (data) {
                $(".input-sample").setFields({data: data.header});
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
                url: 'sample/' + $("#frmCancel #sample_id").val() + '/cancelInvoice',
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
        $("#frmCancel #sample_id").val(id);
    }

    this.uploadExcel = function () {
        $("#frmUpload #client_id").val($("#frm #client_id :selected").val());
        var formData = new FormData($("#frmUpload")[0]);
        $.ajax({
            url: 'sample/uploadExcel',
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
        $(".input-sample").cleanFields();
        $(".input-detail").cleanFields();
        $(".input-fillable").prop("readonly", false);
        $("#btnSend,#btnPdf").prop("disabled", true);
        $("#tblDetail tbody").empty();
        $("#frm #status_id").val(0).trigger("change").prop("disabled", true);
        $("#frm #supplier_id").prop("disabled", false);
        $("#frm #warehouse_id").getSeeker({default: true, api: '/api/getWarehouse'});
        $("#frm #responsible_id").getSeeker({default: true, api: '/api/getResponsable', disabled: true});
        $("#frm #city_id").getSeeker({default: true, api: '/api/getCity', disabled: true});

        listProducts = [];
        statusRecord = false;
    }

    this.getBranchAddress = function (id, path) {
        var url = 'sample/' + id + '/getBranch';
        if (path == undefined) {
            url = '../../sample/' + id + '/getBranch';
        }

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

    this.getClient = function (id, path) {
        var html = "";
        var url = 'sample/' + id + '/getClient';
        if (path == undefined) {
            url = '../../sample/' + id + '/getClient';
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
                $("#frm #address").val(resp.data.client.address_send);
                $("#frm #phone").val(resp.data.client.phone);
                $("#frm #destination_id").setFields({data: {destination_id: resp.data.client.send_city_id}});
                $("#frm #responsible_id").setFields({data: {responsible_id: resp.data.client.responsible_id}});
                html = "<option value=0>Selection</option>";
                $.each(resp.data.branch, function (i, val) {
                    val.business = (val.business == null) ? '' : val.business;
                    html += '<option value="' + val.id + '">' + val.business + ' ' + val.address_invoice + "</option>";
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
            url: 'sample/setSale',
            method: 'POST',
            data: data,
            dataType: 'JSON',
            beforeSend: function () {
                $("#loading-super").removeClass("hidden");
            },
            success: function (resp) {
                if (resp.success == true) {
                    toastr.success("Sended");
                    $(".input-sample").setFields({data: resp.header, disabled: true});
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
        var validate = $(".input-sample").validate();
        if (validate.length == 0) {
            if ($("#id_orderext").val() == '') {
                if (listProducts.length > 0) {
                    data.header = $(".input-sample").getData();
                    data.detail = listProducts;
                    if (id == '') {
                        method = 'POST';
                        url = "sample";
                        msg = "Created Record";
                    } else {
                        method = 'PUT';
                        url = "sample/" + id;
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
                                $(".input-sample").setFields({data: data.header, disabled: true});
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
                    url: "../../sample/storeExt",
                    method: 'POST',
                    data: data,
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.success == true) {
                            $(".input-sample").setFields({data: data.header})

                            toastr.success("ok");
                            $("#btnmodalDetail").attr("disabled", false);
                            location.href = "/sample";
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
        var lots = [];
        $("#frmDetail #sample_id").val($("#frm #id").val());
        var data = {}, value = 0, total = 0;
        var url = "", method = "";
        var id = $("#frmDetail #id").val();
        var form = $("#frmDetail").serialize()
        var msg = 'Record Detail';
        var validate = $(".input-detail").validate();

        $(".input-lots").each(function () {
            if ($(this).val() > 0) {
                lots.push({lot: $(this).attr("lot"), quantity: $(this).val(), expiration_date: $(this).attr("expire")
                    , cost_sf: $(this).attr("cost_sf"), product_id: $(this).attr("product_id")});
                total += parseInt($(this).val());
            }
        })

        if (validate.length == 0) {
            if (id != '') {
                data.header = {};
                data.detail = [];

                data.header.id = $("#frmDetail #id").val();
                data.header.product_id = $("#frmDetail #product_id :selected").val();
                data.header.total = total;
                data.detail = lots;

                var url = "/sample/detail/" + id;
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
                    var url = "/sample/storeDetail";
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
                            price_tax: dataProduct.cost_sf * dataProduct.packaging * dataProduct.tax,
                            price_sf: (dataProduct.cost_sf / dataProduct.packaging),
                            units_sf: parseFloat(dataProduct.packaging),
                            quantity: $("#frmDetail #quantity").val(),
                            valueFormated: $("#frmDetail #value").val(),
                            totalFormated: ($("#frmDetail #quantity").val() * (dataProduct.cost_sf / dataProduct.packaging)),
                            total: ($("#frmDetail #quantity").val() * (dataProduct.cost_sf / dataProduct.packaging)),
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
        $("#frmServices #sample_id").val($("#frm #id").val());
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
                var url = "/sample/detail/" + id;
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
                    var url = "/sample/storeDetail";
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
        console.log(listProducts)
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
        var frm = $("#frmEdit"), btnEdit = true, btnDel = true;
        var data = frm.serialize();
        var url = "/sample/" + id + "/edit";
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $('#myTabs a[href="#management"]').tab('show');
                $(".input-sample").setFields({data: data.header, disabled: true});
                if (data.header.id != '') {
                    $("#btnmodalDetail").attr("disabled", false);
                }


                if (data.header.status_id == 1) {
                    statusRecord = true;
                    btnDel = true;
                }
                if (data.header.status_id != 1) {
                    $("#btnSave, #btnmodalDetail").attr("disabled", true);
                }

                if (data.header.status_id == 2) {
                    $("#btnSend, #btnmodalDetail").attr("disabled", true);
                    btnEdit = false;
                    btnDel = false;
                    statusRecord = false;
                } else {
                    $("#btnSend,#btnmodalDetail").attr("disabled", false);
                }


                if ($("#role_id").val() == 1 || $("#role_id").val() == 5) {
                    btnEdit = true;
                    btnDel = true;
                }

                if ($("#role_id").val() == 1) {
                    $("#frm #shipping_cost").attr("disabled", false);
                }

                obj.printDetail(data, btnEdit, btnDel);
            }
        })
    }

    this.infomationExt = function (id) {
        var frm = $("#frmEdit");
        var data = frm.serialize();
        var url = "/sample/" + id + "/editExt";
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {

                $('#myTabs a[href="#management"]').tab('show');
                $(".input-sample").setFields({data: data.header});
                if (data.header.id != '') {
                    $("#btnmodalDetail").attr("disabled", false);
                }

                obj.printDetail(data.detail);
            }
        })
    }

    this.editDetail = function (id) {
        $("#frmDetail #sample_id").val($("#frm #id").val());
        var frm = $("#frm");
        var data = frm.serialize(), html = '';
        var url = "/sample/" + id + "/detail";
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (resp) {


                quantity_total = resp.row.quantity;

                $("#modalDetail").modal("show");
                $(".input-detail").setFields({data: resp.row})

                $("#tableLot tbody").empty();

                $.each(resp.inventory, function (i, val) {
                    html += '<tr><td>' + val.lot + '</td>';
                    html += '<td>' + val.quantity + '</td>';
                    html += '<td>' + val.expiration_date + '</td>';
                    html += '<td><input value="0" class="form-control input-lots" lot="' + val.lot + '" expire="' + val.expiration_date + '" cost_sf="' + val.cost_sf + '" product_id="' + val.product_id + '"></td></tr>';
                });

                $("#tableLot tbody").html(html);

            }, error(xhr, responseJSON, thrown) {
                console.log(responseJSON)
            }
        })
    }

    this.confirmItem = function () {
        var id = $("#frmDetail #id").val();
        var frm = $("#frmDetail");
        var data = frm.serialize();
        var url = "/sample/detail/" + id;
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
            var url = "/sample/" + id;
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

        if (confirm("Do you want delete this record?")) {
            var token = $("input[name=_token]").val();
            var url = "/sample/detail/" + id;
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
                url: 'sample/generateRemission/' + id,
                method: 'PUT',
                dataType: 'JSON',
                success: function (resp) {
                    if (resp.success == true) {
                        table.ajax.reload();
                        window.open("sample/" + id + "/getRemission");
                    }
                }
            })


        }
    }

    this.viewRemission = function (id) {
        window.open("sample/" + id + "/getRemission");
    }


    this.table = function () {
        var param = {};

        param.supplier_id = $("#frm #supplier_id").val();
        param.client_id = $("#frm #client_id").val();
        param.commercial_id = $("#frm #commercial_id").val();

        param.init = $("#frm #init").val();
        param.end = $("#frm #end").val();

        var html = '';
        table = $('#tbl').DataTable({
            "dom":
                    "R<'row'<'col-sm-4'l><'col-sm-2 toolbar text-right'><'col-sm-3'B><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12't>>" +
                    "<'row'<'col-xs-3 col-sm-3 col-md-3 col-lg-3'i><'col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center'p><'col-xs-3 col-sm-3 col-md-3 col-lg-3'>>",
            "processing": true,
            "serverSide": true,
            ajax: {
                url: "/api/listSample",
                data: param
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
                {data: "client"},
                {data: "responsible"},
                {data: "warehouse"},
                {data: "city"},
                {data: "quantity"},
                {data: "subtotal", render: $.fn.dataTable.render.number('.', ',', 2)},
                {data: "total", render: $.fn.dataTable.render.number('.', ',', 2)},
                {data: "status"},
            ],

            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            order: [[1, 'DESC']],
            aoColumnDefs: [
                {
                    aTargets: [1, 2, 3, 4, 5, 6, 7, 8, 9],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.showModal(' + full.id + ')">' + data + '</a>';
                    }
                },
                {
                    targets: [12],
                    searchable: false,
                    mData: null,
                    mRender: function (data, type, full) {
                        if (data.status_id == 5) {
                            html = '<i style="cursor:pointer" class="fa fa-file-pdf-o" aria-hidden="true" onclick="obj.viewRemission(' + data.id + ')"></i>';
                        } else {
                            if (data.status_id != 1) {

                                html = '<img src="' + PATH + '/assets/images/pdf_23.png" style="cursor:pointer" onclick="obj.viewPdf(' + data.id + ')" title="Ver Factura">';
                                if (data.status_id != 4) {
                                    html += '&nbsp;&nbsp;<span style="cursor:pointer" class="fa-stack" onclick="obj.modalCancel(' + data.id + ')" title="Anular Factura"><i class="fa fa-stack-1x fa-file-pdf-o"></i><i class="fa fa-ban fa-stack-2x text-danger"></i></span>';
                                }
                            } else {
                                html = '<i style="cursor:pointer" class="fa fa-trash fa-lg" aria-hidden="true" onclick="obj.delete(' + data.id + ')" title="Borrar Orden"></i>&nbsp;&nbsp;<i style="cursor:pointer" class="fa fa-file-text fa-lg" aria-hidden="true" onclick="obj.tempInvoice(' + data.id + ')" title="Generar Remisión"></i>';
                            }
                        }
                        return html;
                    }
                }
            ],

            createdRow: function (row, data, index) {
                if (data.status_id == 1) {
                    $('td', row).eq(11).addClass('color-new');
                } else if (data.status_id == 2) {
                    $('td', row).eq(11).addClass('color-pending');
                } else if (data.status_id == 3) {
                    $('td', row).eq(11).addClass('color-checked');
                }
            },
            footerCallback: function (row, data, start, end, display) {
                var api = this.api(), data, subtotal, total, quantity = 0;

                var intVal = function (i) {
                    return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                };

                quantity = api
                        .column(8)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                subtotal = api
                        .column(9)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                total = api
                        .column(10)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                // Update footer
                $(api.column(8).footer()).html(
                        '(' + quantity + ')'
                        );


                $(api.column(9).footer()).html(
                        '(' + obj.formatCurrency(subtotal, '$') + ')'
                        );


                $(api.column(10).footer()).html(
                        '(' + obj.formatCurrency(total, "$") + ')'

                        );

//                console.log(api)
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
        window.open(PATH + "/sample/" + id + "/getInvoice");
    }

    this.format = function (d) {
        var url = "/sample/" + d.id + "/detailAll";
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
                $.each(data.detail, function (i, val) {
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
                html += '<tr><td colspan="4">Total</td><td>' + data.total + '</td></td>';
                html += "</tbody></table><br>";
            }
        })
        return html;
    }

}

var obj = new Sale();
obj.init();