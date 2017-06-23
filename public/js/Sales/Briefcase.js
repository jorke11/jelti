function Briefcase() {
    var invoice = [], tableBrief, dep = '';
    this.init = function () {
        tableBrief = obj.table();
        var html = '', param = {};

        $("#btnModalUpload").click(function () {
            $("#modalUpload").modal("show");
        })
        $("#insideManagement").click(function () {
            invoice = [], html = '', dep = '';
            $("#table-invoices tbody").empty();

            $(".selected-invoice").each(function () {
                if ($(this).is(":checked")) {
                    html += "<tr><td>" + $(this).attr("invoice") + '<input type="hidden" name="invoices[]" value="' + $(this).val() + '"></td>';
                    html += '<td>' + $(this).attr("totalformated") + '</td><td><input type="text" class="form-control" name="values[]" value="' + $(this).attr("total") + '"></td></tr>';
                    invoice.push({id: $(this).val(), invoice: $(this).attr("invoice"), total: $(this).attr("total"), totalforamted: $(this).attr("totalforamted")})
                    dep += (dep == '') ? '' : ',';
                    dep += $(this).val();
                }
            })
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

        $("#btnSave").click(this.uploadExcel);


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
            }
        })
    }

    this.payed = function () {
        $("#modalPayed").modal("show");
    }

    this.table = function () {
        var html = '';
        table = $('#tbl').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/briefcase/getInvoices",
            columns: [

                {data: "id"},
                {data: "invoice"},
                {data: "created_at"},
                {data: "client"},
                {data: "responsible"},
                {data: "city"},
                {data: "totalformated"},
                {data: "payedformated"},
                {data: "dias_vencidos"},
                {data: "paid_out", render: function (data, type, row) {
                        var msg = '';
                        if (row.paid_out == null || row.paid_out == false) {
                            if (row.dias_vencidos < 0) {
                                msg = 'En mora';
                            } else {
                                msg = 'No Pago'
                            }
                        } else {
                            msg = 'Pago'
                        }
                        return msg;
                    }
                },
            ],
            order: [[7, 'DESC']],
            aoColumnDefs: [
                {
                    aTargets: [1, 2, 3, 4],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.showModal(' + full.id + ')">' + data + '</a>';
                    }
                },
                {
                    targets: [10],
                    searchable: false,
                    mData: null,
                    mRender: function (data, type, full) {
                        html = '<img src="assets/images/pdf_23.png" style="cursor:pointer" onclick="obj.viewPdf(' + data.id + ')">';
                        return html;
                    }
                }
                ,
                {
                    targets: [11],
                    searchable: false,
                    mData: null,
                    mRender: function (data, type, full) {
                        html = '<input type="checkbox" class="selected-invoice" value="' + data.id + '" invoice="' + data.invoice + '" total="' + data.total + '" totalformated="' + data.totalformated + '">'
                        html += '&nbsp;&nbsp;<span style="cursor:pointer" class="glyphicon glyphicon-ok" aria-hidden="true" onclick=obj.payed(' + data.id + ')></span>';
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

                if (data.dias_vencidos >= 0 && data.dias_vencidos <= 3) {
                    $('td', row).eq(8).addClass('color-green');
                } else if (data.dias_vencidos < 0) {
                    $('td', row).eq(8).addClass('color-red');
                } else if (data.status_id == 3) {
                    $('td', row).eq(8).addClass('color-checked');
                }
            }
        });
        return table;
    }
}

var obj = new Briefcase();
obj.init();