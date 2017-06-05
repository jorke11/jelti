function Briefcase() {
    var invoice = [], tableBrief;
    this.init = function () {
        tableBrief = obj.table();
        var html = '';

        $("#btnModalUpload").click(function () {
            $("#modalUpload").modal("show");
        })
        $("#insideManagement").click(function () {
            invoice = [], html = '';
            $("#table-invoices tbody").empty();
            $(".selected-invoice").each(function () {
                if ($(this).is(":checked")) {
                    html += "<tr><td>" + $(this).attr("invoice") + '</td><input type="hidden" name="invoices[]" value="' + $(this).val() + '"></tr>';
                    invoice.push({id: $(this).val(), invoice: $(this).attr("invoice")})
                }
            })
            $("#table-invoices tbody").html(html);
        })

        $("#btnSave").click(this.uploadExcel);


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
                if (data.suscess == true) {
                    Toastr.success("Ok");
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

    this.table = function () {
        var html = '';
        table = $('#tbl').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/briefcase/getInvoices",
            columns: [

                {data: "consecutive"},
                {data: "invoice"},
                {data: "created_at"},
                {data: "client"},
                {data: "responsible"},
                {data: "city"},
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
                    targets: [8],
                    searchable: false,
                    mData: null,
                    mRender: function (data, type, full) {
                        html = '<img src="assets/images/pdf_23.png" style="cursor:pointer" onclick="obj.viewPdf(' + data.id + ')">';
                        return html;
                    }
                }
                ,
                {
                    targets: [9],
                    searchable: false,
                    mData: null,
                    mRender: function (data, type, full) {
                        html = '<input type="checkbox" class="selected-invoice" value="' + data.id + '" invoice="' + data.invoice + '">'
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
                    $('td', row).eq(7).addClass('color-green');
                } else if (data.dias_vencidos < 0) {
                    $('td', row).eq(7).addClass('color-red');
                } else if (data.status_id == 3) {
                    $('td', row).eq(7).addClass('color-checked');
                }
            }
        });
        return table;
    }
}

var obj = new Briefcase();
obj.init();