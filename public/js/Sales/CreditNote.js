function CreditNote() {
    var table, maxDeparture = 0, listProducts = [], listProductsStatic = [], dataProduct, row = {}, rowItem, tableNote;
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

        $("#quantity").change(function () {
            $("#quantity_units").val(dataProduct.units_sf * $(this).val());
            $("#value_units").val(dataProduct.units_sf * $(this).val() * dataProduct.price_sf).formatNumber();
        });


        $("#insideManagement").click(function () {
            $(".input-departure").cleanFields({disabled: true});
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

        $("#frmDetail #product_id").change(function () {
            $.ajax({
                url: 'creditnote/' + $(this).val() + '/getDetailProduct',
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


        $("#btnModalUpload").click(function () {
            $("#modalUpload").modal("show");
        })
        $("#tabNota").click(this.tableNote)


    }

    this.new = function () {
        toastr.remove();
        $(".input-departure").cleanFields();
        $(".input-detail").cleanFields();
        $(".input-fillable").prop("readonly", false);
        $("#btnSend,#btnPdf").prop("disabled", true);
        $("#tblDetail tbody").empty();
        $("#frm #status_id").val(0).trigger("change").prop("disabled", true);
        $("#frm #supplier_id").prop("disabled", false);
        $("#btnSave").prop("disabled", false);
        $("#frm #warehouse_id").getSeeker({default: true, api: '/api/getWarehouse'});
        $("#frm #responsible_id").getSeeker({default: true, api: '/api/getResponsable', disabled: true});
        $("#frm #city_id").getSeeker({default: true, api: '/api/getCity', disabled: true});
        $("#btnmodalDetail,#btnModalUpload").attr("disabled", false);
        listProducts = [];
        obj.consecutive();
    }

    this.deleteItem = function (product_id, rowItem) {
        delete listProducts[rowItem];
        $("#row_" + rowItem).remove();
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
                $("#frm #address").val(resp.data.client.address_send);
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
                    data.id = $("#frm #id").val();
                    data.description = $("#frm #description").val();
                    data.detail = listProducts;

                    msg = "Created Record";

                    $.ajax({
                        url: PATH + '/creditnote',
                        method: 'post',
                        data: data,
                        dataType: 'JSON',
                        beforeSend: function () {
                            $("#loading-super").removeClass("hidden");
                        },
                        success: function (data) {
                            if (data.success == true) {
                                $("#btnSend").attr("disabled", false);
                                table.ajax.reload();
                                toastr.success(msg);
                                $("#loading-super").addClass("hidden");
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            toastr.error(xhr.responseJSON.msg);
                        },
                    })
                } else {
                    toastr.error("Detail empty");
                }
            }
        } else {
            toastr.error("input required");
        }
    }



    this.saveDetail = function () {
        toastr.remove();
        var param = {};
        $("#frmDetail #departure_id").val($("#frm #id").val());

        var data = {}, value = 0, total = 0;
        var url = "", method = "";
        var id = $("#frmDetail #id").val();
        var form = $("#frmDetail").serialize()
        var msg = 'Record Detail';
        var validate = $(".input-detail").validate();

        param.quantity = $("#frmDetail #quantity").val();

        obj.getItem($("#frmDetail #product_id").val());
        var quantity = listProductsStatic[rowItem].quantity;

//        if (quantity >= $("#frmDetail #quantity").val()) {
        listProducts[rowItem].quantity = $("#frmDetail #quantity").val();
        obj.printDetailTmp();
        toastr.success("Proceso realizado");
        $("#modalDetail").modal("hide");
//        } else {
//            toastr.error("La cantidad ingresa no puede ser mayor a " + quantity);
//        }
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
            if (val != undefined) {
                if (val.product_id == product_id) {
                    rowItem = i;
                    row = val;
                }
            }
        })
    }

    this.printDetailTmp = function () {
        var html = "", htmlEdit = "", htmlDel = "";
        $("#tblDetail tbody").html("");
        $.each(listProducts, function (i, val) {

            if (val != undefined) {
                htmlEdit = '<button type="button" class="btn btn-xs btn-primary" onclick=obj.editItem(' + val.product_id + ',' + i + ')>Edit</button>'
                htmlDel = '<button type="button" class="btn btn-xs btn-warning" onclick=obj.deleteItem(' + val.product_id + ',' + i + ')>Delete</button>'

                val.real_quantity = (val.real_quantity != null) ? val.real_quantity : '';
                val.comment = (val.comment != null) ? val.comment : '';

                html += '<tr id="row_' + i + '">';
                html += "<td>" + val.product + "</td>";
                html += "<td>" + val.comment + "</td>";
                html += "<td>" + val.quantity + "</td>";
                html += "<td>" + val.valueFormated + "</td>";
                html += "<td>" + val.totalFormated + "</td>";
                html += "<td>" + val.real_quantity + "</td>";
                html += "<td>" + val.valueFormated + "</td>";
                html += "<td>" + val.totalFormated_real + "</td>";
                html += '<td>' + htmlEdit + htmlDel + "</td>";
                html += "</tr>";
            }
        });

        $("#tblDetail tbody").html(html);
    }

    this.showModal = function (id) {
        var frm = $("#frmEdit"), btnEdit = true, btnDel = true;
        var data = frm.serialize();
        var url = "/creditnote/" + id + "/edit";
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $('#myTabs a[href="#management"]').tab('show');
                $(".input-departure").setFields({data: data.header, disabled: true});
                $("#frm #description").attr("disabled", false);
                listProducts = data.detail;
                listProductsStatic = data.detail;
                obj.printDetailTmp(data.detail, btnEdit, btnDel);
                tableNote = obj.tableNote(id);
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
    this.deleteNote = function (id) {
        var url = "/creditnote/detail/" + id;
        $.ajax({
            url: url,
            method: "DELETE",
            dataType: 'JSON',
            success: function (resp) {
                table.ajax.reload();
                tableNote.ajax.reload();

            }, error(xhr, responseJSON, thrown) {
                toastr.error(xhr.responseJSON.msg);
            }
        })
    }

    this.tableNote = function (id) {
        var html = '';
        var param = {};
        param.departure_id = id;

        table = $('#tblNote').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "/api/listCreditNotePDF",
                data: param
            },
            destroy: true,
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
                {data: "client"},
                {data: "departure_id"},
            ],
            order: [[1, 'DESC']],
            aoColumnDefs: [
                {
                    aTargets: [1],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.showModal(' + full.id + ')">' + data + '</a>';
                    }
                },

                {
                    targets: [5],
                    searchable: false,
                    mData: null,
                    mRender: function (data, type, full) {
                        if (data.credit_note != 0) {

                            html = '<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>';
                            html = '<img src="' + PATH + '/assets/images/pdf_23.png" style="cursor:pointer" onclick="obj.viewPdfNote(' + data.id + ')">';
                        } else {
                            html = ''
                        }

                        return html;
                    }
                },
                {
                    targets: [6],
                    searchable: false,
                    mData: null,
                    mRender: function (data, type, full) {
                        html = '<span style="cursor:pointer" class="glyphicon glyphicon-trash" aria-hidden="true" onclick=obj.deleteNote(' + data.id + ')></span>';
                        return html;
                    }
                }
            ]

        }
        );
        $('#tblNote tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {

                row.child(obj.formatNote(row.data())).show();
                tr.addClass('shown');
            }
        });

        return table;
    }

    this.table = function () {
        var html = '';
        table = $('#tbl').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/api/listCreditNote",
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
                    targets: [9],
                    searchable: false,
                    mData: null,
                    mRender: function (data, type, full) {
                        if (data.status_id != 1) {
                            html = '<img src="' + PATH + '/assets/images/pdf_23.png" style="cursor:pointer" onclick="obj.viewPdf(' + data.id + ')">';
                        } else {
                            html = ''
                        }
                        return html;
                    }
                }
                ,
                {
                    targets: [10],
                    searchable: false,
                    mData: null,
                    mRender: function (data, type, full) {
                        if (data.credit_note != 0) {
                            html = '<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>';
                        } else {
                            html = ''
                        }

                        return html;
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
                    $('td', row).eq(8).addClass('color-new');
                } else if (data.status_id == 2) {
                    $('td', row).eq(8).addClass('color-pending');
                } else if (data.status_id == 3) {
                    $('td', row).eq(8).addClass('color-checked');
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

    this.viewPdf = function (id) {
        window.open("departure/" + id + "/getInvoice");
    }
    this.viewPdfNote = function (id) {
        window.open(PATH + "/creditnote/" + id + "/getInvoice");
    }

    this.formatNote = function (d) {
        var url = "/creditnote/" + d.id + "/getCreditNote";
        var html = '<br><table class="table-detail">';
        html += '<thead>'
        html += '<tr><th>#</th><th>Product</th><th>Quantity</th>';
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
                    html += "</tr>";
                });

                html += "</tbody></table><br>";
            }
        })
        return html;
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

var obj = new CreditNote();
obj.init();