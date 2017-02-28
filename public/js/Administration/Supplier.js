function Suppliers() {
    var table;
    this.init = function () {
        table = this.table();
        $("#new").click(this.save);
        $("#edit").click(this.edit);
        $("#tabManagement").click(function () {
            $(".input-supplier").val("");
            $('#myTabs a[href="#management"]').tab('show');
        });

        $("#modalImage").click(function () {

            $("#input-700").fileinput({
                uploadUrl: "supplier/upload", // server upload action
                uploadAsync: true,
                maxFileCount: 5,
                uploadExtraData: {
                    supplier_id: $("#frm #id").val(),
                    document_id: $("#document_id").val(),

                },
            }).on('fileuploaded', function (event, data, id, index) {
                $("#modalUpload").modal("hide");
                obj.showImages(data.extra.supplier_id);
            })

            $("#modalUpload").modal("show");
        })
    }
    this.showImages = function (id) {
        $.ajax({
            url: 'supplier/getImages/' + id,
            method: 'GET',
            dataType: 'JSON',
            success: function (data) {
                obj.printImages(data);
            }
        })
    }
    this.printImages = function (data) {
        var html = '';
        $.each(data, function (i, val) {
            html += '<tr><td>' + val.document_id + '</td><td><a href="images/supplier/' + val.path + '" target="_blank">See</a></td>';
            html += '<td><button class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></td></tr>';
        })
        $("#contentAttach tbody").html(html);
    }

    this.save = function () {
        var frm = $("#frm");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frm #supplier_id").val();
        var msg = '';
        if (id == '') {
            method = 'POST';
            url = "supplier";
            msg = "Created Record";

        } else {
            method = 'PUT';
            url = "supplier/" + id;
            msg = "Edited Record";
        }

        $.ajax({
            url: url,
            method: method,
            data: data,
            dataType: 'JSON',
            success: function (data) {
                if (data.success == 'true') {
                    table.ajax.reload();
                    toastr.success(msg);
                }
            }
        })
    }

    this.showModal = function (id) {
        var frm = $("#frm");
        var data = frm.serialize();
        var url = "/supplier/" + id + "/edit";
        $('#myTabs a[href="#management"]').tab('show');
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                
                $(".input-supplier").setFields({data: data.header});

                obj.printImages(data.images);
            }
        })
    }

    this.deleteImage = function (id, product_id) {
        $("#div_" + id).remove();
        var obj = {};
        obj.product_id = product_id;
        $.ajax({
            url: 'supplier/deleteImage/' + id,
            method: 'DELETE',
            data: obj,
            dataType: 'JSON',
            success: function (data) {
                toastr.success("Image Deleted")
//                $("#imageMain").attr("src", "/images/product/" + data.path.path);
            }
        })
    }

    this.delete = function (id) {
        toastr.remove();
        if (confirm("Deseas eliminar")) {
            var token = $("input[name=_token]").val();
            var url = "/supplier/" + id;
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

    this.table = function () {
        return $('#tblSuppliers').DataTable({
            bSort: true,
            "dom":
                    "R<'row'<'col-sm-4'l><'col-sm-2 toolbar text-right'><'col-sm-3'B><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12't>>" +
                    "<'row'<'col-xs-3 col-sm-3 col-md-3 col-lg-3'i><'col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center'p><'col-xs-3 col-sm-3 col-md-3 col-lg-3'>>",
            "processing": true,
            "serverSide": true,
            "ajax": "/api/listSupplier",
            columns: [
                {data: "supplier_id"},
                {data: "name"},
                {data: "last_name"},
                {data: "document"},
                {data: "email"},
                {data: "address"},
                {data: "phone"},
                {data: "contact"},
                {data: "phone_contact"},
                {data: "term"},
                {data: "city_id"},
                {data: "web_site"},
                {data: "typeperson"},
                {data: "typeregime"},
            ],
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            order: [[1, 'ASC']],
            aoColumnDefs: [
                {
                    aTargets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.showModal(' + full.supplier_id + ')">' + data + '</a>';
                    }
                },
                {
                    targets: [14],
                    searchable: false,
                    mData: null,
                    mRender: function (data, type, full) {
                        return '<button class="btn btn-danger btn-xs" onclick="obj.delete(' + data.supplier_id + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                    }
                }
            ],
        });
    }

}

var obj = new Suppliers();
obj.init();
