function Briefcase() {
    this.init = function () {
        obj.table();

        $("#btnModalUpload").click(function () {
            $("#modalUpload").modal("show");
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