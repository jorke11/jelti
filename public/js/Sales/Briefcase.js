function Briefcase() {
    var invoice = [], tableBrief, dep = '';
    this.init = function () {
        tableBrief = obj.table();
        var html = '', param = {}, total = 0;


        $("#btnModalUpload").click(function () {
            $("#modalUpload").modal("show");
        })
        $("#insideManagement").click(function () {
            invoice = [], html = '', dep = '';
            $("#table-invoices tbody").empty();
            total = 0;
            $(".selected-invoice").each(function () {
                if ($(this).is(":checked")) {

                    html += "<tr><td>" + $(this).attr("invoice") + '<input type="hidden" name="invoices[]" value="' + $(this).val() + '"></td>';
                    html += '<td>' + obj.formatCurrency($(this).attr("total"), "$") + '</td><td><input type="text" class="form-control" name="values[]" value="' + $(this).attr("total") + '"></td></tr>';
                    invoice.push({id: $(this).val(), invoice: $(this).attr("invoice"), total: $(this).attr("total"), totalforamted: $(this).attr("total")})
                    dep += (dep == '') ? '' : ',';
                    dep += $(this).val();
                    total += parseFloat($(this).attr("total"));
                }
            })
            html += '<tr><td>Total</td><td>' + obj.formatCurrency(total, "$") + '</td></tr>';

            param.departures = dep;

            $.ajax({
                url: 'briefcase/getBriefcase',
                method: "GET",
                data: param,
                dataType: 'JSON',
                success: function (data) {
                    obj.loadTable(data.data);
                }
            })

            $("#table-invoices tbody").html(html);
        })

        $("#btnFilter").click(function () {

            table = obj.table();

        })

        $("#btnSave").click(this.uploadExcel);
        $("#btnPay").click(this.pay);

    }

    this.formatCurrency = function (n, currency) {
        n = parseFloat(n);
        return currency + " " + n.toFixed(2).replace(/./g, function (c, i, a) {
            return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
        });
    }


    this.pay = function () {
        var param = {};
        param.description = $("#frmPay #comment").val()
        param.saldo = $("#frmPay #saldo").val()

        $.ajax({
            url: "briefcase/payInvoice/" + $("#frmPay #departure_id").val(),
            method: "PUT",
            data: param,
            dataType: 'JSON',
            success: function (data) {
                if (data.success == true) {
                    table.ajax.reload();
                    $("#modalPayed").modal("hide");
                    toastr.success("Ok");
                }
            }, error: function (err) {
                toastr.error("No se puede borrra Este registro");
            }
        })
    }

    this.loadTable = function (detail) {
        var html = '';
        $.each(detail, function (i, value) {
            $.each(value, function (j, val) {
                if (val.total != undefined) {
                    html += '<tr style="background-color:#ececec"><td>Total</td><td>' + val.totalformated + '</td><td colspan="3"></td></tr>';
                } else {
                    html += '<tr id="id_"' + val.id + ' ><td>' + val.invoice + '</td><td>' + val.valuepayed + '</td><td>' + val.created_at + '</td>';
                    if (val.img != null) {
                        html += '<td><a href="' + val.img + '" target="_blank"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a></td>';
                    } else {
                        html += '<td></td>';
                    }
                    html += '<td><span style="cursor:pointer" class="glyphicon glyphicon-trash" aria-hidden="true" onclick=obj.deleteItem(' + val.id + ')></span></td>';
                    html += '</tr>';
                }
            })

        })
        $("#table-payed tbody").html(html);
    }

    this.deleteItem = function (id) {
        toastr.remove();
        var param = {};
        if (confirm("Deseas eliminar")) {
            param.departures = dep;
            var token = $("input[name=_token]").val();
            var url = "/briefcase/" + id;
            $.ajax({
                url: url,
                headers: {'X-CSRF-TOKEN': token},
                method: "DELETE",
                data: param,
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == true) {
                        $("#id_" + id).remove();
                        obj.loadTable(data.data);
                        table.ajax.reload();
                        toastr.warning("Ok");
                    }
                }, error: function (err) {
                    toastr.error("No se puede borrra Este registro");
                }
            })
        }
    }


    this.uploadExcel = function () {
        var formData = new FormData($("#frm")[0]);
//        formData.append("invoices", invoice);
        $.ajax({
            url: 'briefcase/uploadSupport',
            method: 'POST',
            data: formData,
            dataType: 'JSON',
            processData: false,
            cache: false,
            contentType: false,
            success: function (data) {
                if (data.success == true) {
                    toastr.success("Ok");
                    obj.loadTable(data.data)
                    tableBrief.ajax.reload();
                }
            }
        })

    }

    this.viewPdf = function (id) {
        window.open("departure/" + id + "/getInvoice");
    }

    this.showModal = function (id) {
        var frm = $("#frmEdit"), btnEdit = true, btnDel = true;
        var data = frm.serialize();
        var url = "/briefcase/" + id + "/edit";
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $('#myTabs a[href="#management"]').tab('show');
                obj.loadTable(data);

            }
        })
    }

    this.payed = function (id) {
        $("#modalPayed").modal("show");
        var total = $("#row_" + id).attr("total") - (($("#row_" + id).attr("payed") == "null") ? 0 : $("#row_" + id).attr("payed"));
        $("#frmPay #saldo").val(total);
        $("#frmPay #departure_id").val(id);
    }

    this.table = function () {
        var html = '', param = {};
        param.status_id = $("#frmFilter #status_id").val();
        table = $('#tbl').DataTable({
            "dom":
                    "R<'row'<'col-sm-4'l><'col-sm-2 toolbar text-right'><'col-sm-3'B><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12't>>" +
                    "<'row'<'col-xs-3 col-sm-3 col-md-3 col-lg-3'i><'col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center'p><'col-xs-3 col-sm-3 col-md-3 col-lg-3'>>",
            "processing": true,
            "serverSide": true,
            destroy: true,

            ajax: {
                url: "/briefcase/getInvoices",
                data: param
            },
            "lengthMenu": [[30, 100, 300, -1], [30, 100, 300, 'All']],
            columns: [
                {data: "id"},
                {data: "invoice"},
                {data: "created_at"},
                {data: "dispatched"},
                {data: "client"},
                {data: "business_name"},
                {data: "responsible"},
                {data: "city"},
                {data: "total", render: $.fn.dataTable.render.number(',', '.', 2)},
                {data: "payedformated"},
                {data: "dias_vencidos", render: function (data, type, row) {
                        return (row.paid_out == true) ? 0 : data;
                    }
                },
                {data: "term"},
                {data: "paid_out", render: function (data, type, row) {
                        var msg = '';
                        if (row.paid_out == null || row.paid_out == false) {
                            if (row.dias_vencidos < 0) {
                                msg = 'No Pago';
                            } else {
                                msg = 'En mora'
                            }
                        } else {
                            msg = 'Pago'
                        }
                        return msg;
                    }
                },
            ],
            buttons: [
                {

                    className: 'btn btn-primary glyphicon glyphicon-filter',
                    action: function (e, dt, node, config) {
                        $("#modalFilter").modal("show");
                    }
                },
                {
                    extend: 'excelHtml5',
//                    text: '<i class="fa fa-file-excel-o"></i>',
                    className: 'btn btn-primary glyphicon glyphicon-download',
                    titleAttr: 'Excel'
                },
            ],

            order: [[9, 'DESC']],
            aoColumnDefs: [
                {
                    aTargets: [1, 2, 3, 4],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.showModal(' + full.id + ')">' + data + '</a>';
                    }
                },
                {
                    targets: [12],
                    searchable: false,
                    mData: null,
                    mRender: function (data, type, full) {
                        html = '<img src="assets/images/pdf_23.png" style="cursor:pointer" onclick="obj.viewPdf(' + data.id + ')">';
                        return html;
                    }
                }
                ,
                {
                    targets: [13],
                    searchable: false,
                    mData: null,
                    mRender: function (data, type, full) {
                        html = '';

                        html = '<input type="checkbox" class="selected-invoice" value="' + data.id + '" invoice="' + data.invoice + '" payed="' + data.payed + '" total="' + data.total + '" totalformated="' + data.totalformated + '" id="row_' + data.id + '">&nbsp;&nbsp;'
                        if ($("#role_id").val() == 1 && data.paid_out != true) {
                            html += '<span style="cursor:pointer" class="glyphicon glyphicon-ok" aria-hidden="true" onclick=obj.payed(' + data.id + ')></span>';
                        }

                        return html;
                    }
                }
            ],
//            initComplete: function () {
//                this.api().columns().every(function () {
//                    var column = this;
//                    var type = $(column.header()).attr('rowspan');
//                    if (type != undefined) {
//                        var select = $('<select class="form-control"><option value="">' + $(column.header()).text() + '</option></select>')
//                                .appendTo($(column.footer()).empty())
//                                .on('change', function () {
//                                    var val = $.fn.dataTable.util.escapeRegex(
//                                            $(this).val()
//                                            );
//                                    column
////                                            .search(val ? val : '', true, false)
//                                            .search(val ? '^' + val + '$' : '', true, false)
//                                            .draw();
//                                });
//                        column.data().unique().sort().each(function (d, j) {
//                            select.append('<option value="' + d + '">' + d + '</option>')
//                        });
//                    }
//                });
//            },
            createdRow: function (row, data, index) {

                if (data.dias_vencidos < 0) {
                    $('td', row).eq(10).addClass('color-orange');
                } else if (data.dias_vencidos > 0 & data.paid_out != true) {
                    $('td', row).eq(10).addClass('color-red');
                } else if (data.status_id == 3) {
                    $('td', row).eq(10).addClass('color-checked');
                } else if (data.paid_out == true) {
                    $('td', row).eq(10).addClass('color-green');
                }
            },
            footerCallback: function (row, data, start, end, display) {
                var api = this.api(), data, total;

                var intVal = function (i) {
                    return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                };

                total = api
                        .column(8)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                $(api.column(8).footer()).html('(' + obj.formatCurrency(total, "$") + ')');

//                console.log(api)
            }
        });
        return table;
    }
}

var obj = new Briefcase();
obj.init();