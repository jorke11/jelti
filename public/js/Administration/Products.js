function Product() {
    var table, product_id = 0, tableSpecial;
    this.init = function () {
        table = this.table();
        $("#btnNew").click(this.new);
        $("#btnSave").click(this.save);
        $("#tabManagement").click(function () {
            $(".input-product").val("");
            $('#myTabs a[href="#management"]').tab('show');
        });

        $("#modalImage").click(function () {
            $("#input-700").fileinput({
                uploadUrl: "product/upload", // server upload action
                uploadAsync: true,
                maxFileCount: 5,
                allowedFileExtensions: ['jpg', 'jpeg', 'png', 'gif'],
                uploadExtraData: {
                    id: $("#frm #id").val()
                },
            }).on('fileuploaded', function (event, data, id, index) {
                $("#modalUpload").modal("hide");

                obj.showImages(data.extra.id);
            })

            $("#modalUpload").modal("show");
        })

        $("#tabList").click(function () {
            table.ajax.reload();
        });

        $("#tabManagement").click(function () {
            $(".input-product").cleanFields({disabled: true});
        });

        $("#tabSpecial").click(function () {
            $(".input-special").cleanFields();
            tableSpecial = obj.tableSpecial($("#frm #id").val());
        })

        $("#btnNewSpecial").click(this.newSpecial);
        $("#btnSaveSpecial").click(this.saveSpecial);

        $("#btnUpload").click(this.uploadExcel)
        $("#btnUpload_code").click(this.uploadExcelCode)
    }

    this.uploadExcel = function () {

        var elem = $(this);

        var formData = new FormData($("#frmFile")[0]);

        $.ajax({
            url: 'product/uploadExcel',
            method: 'POST',
            data: formData,
            dataType: 'JSON',
            processData: false,
            cache: false,
            contentType: false,
            beforeSend: function () {
                $("#loading-super").removeClass("hidden");
                $("#tblUpload tbody").empty();
                elem.attr("disabled",true);
            },
            success: function (data) {
                elem.attr("disabled",false);
                $("#loading-super").addClass("hidden");
                obj.setDetailExcel(data.data)
            }
        })

    }
    this.uploadExcelCode = function () {
        var formData = new FormData($("#frmFileCode")[0]);

        $.ajax({
            url: 'product/uploadExcelCode',
            method: 'POST',
            data: formData,
            dataType: 'JSON',
            processData: false,
            cache: false,
            contentType: false,
            success: function (data) {
                console.log(data);
                obj.setDetailExcel(data.data)
            }
        })

    }

    this.setDetailExcel = function (detail) {
        var html = "";

        $.each(detail, function (i, val) {
            html += "<tr><td>" + val.sf_code + "</td><td>" + val.title + "</td><td>" + val.price_sf + "</td><td>" + val.msg + "</td></tr>";
        })
        $("#tblUpload tbody").html(html);
    }

    this.new = function () {
        $(".input-product").cleanFields();
    }
    this.newSpecial = function () {
        $(".input-special").cleanFields();
    }

    this.showImages = function (id) {
        $.ajax({
            url: 'product/getImages/' + id,
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

            html += '<div class="col-sm-6 col-lg-3" id="div_' + val.id + '">' +
                    '<div class="thumbnail" style="height:auto">' +
                    '<img src="' + val.path + '" alt="Product">' +
                    '<div class="caption">' +
                    '<h4>Check Main <input type="radio" name="main[]" onclick=obj.checkMain(' + val.id + ',' + val.id + ')></h4>' +
//                    '<p><button type="button" class="btn btn-primary btn-xs" aria-label="Left Align" ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>' +
                    '<p>' +
                    '<button type="button" class="btn btn-danger btn-xs" onclick=obj.deleteImage(' + val.id + ',' + val.id + ')><span class="glyphicon glyphicon-remove" aria-hidden="true" ></span></button>' +
                    '</p>' +
                    '</div></div></div>';
        })

        $("#contentImages").html(html);
    }

    this.checkMain = function (id, product_id) {
        var obj = {};
        obj.product_id = product_id;
        $.ajax({
            url: 'product/checkmain/' + id,
            method: 'PUT',
            data: obj,
            dataType: 'JSON',
            success: function (data) {
                $("#imageMain").attr("src", "/images/product/" + data.path.path);
            }
        })
    }

    this.deleteImage = function (id, product_id) {
        $("#div_" + id).remove();
        var obj = {};
        obj.product_id = product_id;
        $.ajax({
            url: 'product/deleteImage/' + id,
            method: 'DELETE',
            data: obj,
            dataType: 'JSON',
            success: function (data) {
                toastr.success("Image Deleted")
//                $("#imageMain").attr("src", "/images/product/" + data.path.path);
            }
        })
    }

    this.save = function () {
        toastr.remove();
        var frm = $("#frm"), elem;
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frm #id").val();
        var msg = '';

        var validate = $(".input-product").validate();

        if (validate.length == 0) {
            if (id == '') {
                method = 'POST';
                url = "product";
                msg = "Created Record";
            } else {
                method = 'PUT';
                url = "product/" + id;
                msg = "Edited Record";
            }

            elem = $("#frm #reference");

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
                        table.ajax.reload();
                        $(".input-product").setFields({data: data.header});
                        $("#error_" + elem.attr("id")).remove();
                        elem.removeClass("error");
                        elem.parent().parent().removeClass("has-error")
                        toastr.success(msg);
                    }
                }, error: function (xhr, ajaxOptions, thrownError) {
                    if (xhr.responseJSON.reference) {
                        elem.addClass("error");
                        elem.after('<small class="help-block" id="error_' + elem.attr("id") + '" data-fv-validator="notEmpty" data-fv-for="firstName" data-fv-result="INVALID" style="">' + elem.attr("id") + ' already exists</small>')
                        elem.parent().parent().addClass("has-error")
                    }
                },
                complete: function () {
                    $("#loading-super").addClass("hidden");
                }
            })
        } else {

            toastr.error("Fields Required!");
        }
    }
    this.saveSpecial = function () {
        toastr.remove();
        var frm = $("#frmSpecial");
        $("#frmSpecial #product_id").val($("#frm #id").val());
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frmSpecial #id").val();

        var msg = '';

        var validate = $(".input-special").validate();

        if (validate.length == 0) {
            if (id == '') {
                method = 'POST';
                url = "product/StoreSpecial";
                msg = "Created Record";
            } else {
                method = 'PUT';
                url = "product/UpdateSpecial/" + id;
                msg = "Edited Record";
            }

            $.ajax({
                url: url,
                method: method,
                data: data,
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == 'true') {
                        tableSpecial.ajax.reload();
                        toastr.success(msg);
                    }
                }
            })
        } else {

            toastr.error("Fields Required!");
        }
    }

    this.showModal = function (id) {

        var frm = $("#frm");
        var data = frm.serialize();
        var url = "/product/" + id + "/edit";
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $('#myTabs a[href="#management"]').tab('show');
                $(".input-product").cleanFields();

                if ($("#role_id").val() == 1) {
                    $(".input-product").setFields({data: data.header});
                } else {

                    $(".input-product").setFields({data: data.header, disabled: true});
                }

                if (data.header.image != null) {
                    $("#imageMain").attr("src", data.header.image);
                }
                obj.printImages(data.images);
            }
        })
    }

    this.delete = function (id) {
        toastr.remove();
        if (confirm("Deseas eliminar")) {
            var token = $("input[name=_token]").val();
            var url = "/product/" + id;
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
        return $('#tblProducts').DataTable({
            "processing": true,
            "dom":
                    "R<'row'<'col-sm-4'l><'col-sm-2 toolbar text-right'><'col-sm-3'B><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12't>>" +
                    "<'row'<'col-xs-3 col-sm-3 col-md-3 col-lg-3'i><'col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center'p><'col-xs-3 col-sm-3 col-md-3 col-lg-3'>>",
            "serverSide": true,
            "ajax": "/api/listProduct",
            scrollX: true,
            "lengthMenu": [[30, 100, 300, -1], [30, 100, 300, 'All']],
            columns: [
                {data: "id", sWidth: "50px"},
                {data: "reference", sWidth: "100px"},
                {data: "title", sWidth: "400px"},
                {data: "supplier", sWidth: "100px"},
                {data: "bar_code"},
                {data: "units_supplier", sWidth: "100px"},
                {data: "cost_sf", render: $.fn.dataTable.render.number('.', ',', 2)},
                {data: "tax"},
                {data: "units_sf"},
                {data: "price_sf"},
                {data: "thumbnail", width: 10, searchable: false, render: function (data, type, row) {

                        if (data == null) {
                            data = "/images/product/default.jpg";
                        }
                        return '<img src="' + data + '" width="25px">';
                    }
                },
                {data: "status"},
                {data: "id"},
            ],
            order: [[1, 'ASC']],
            aoColumnDefs: [
                {
                    aTargets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.showModal(' + full.id + ');return false";>' + data + '</a>';
                    }
                },
                {
                    targets: [12],
                    searchable: false,
                    mData: null,
                    mRender: function (data, type, full) {
                        return '<button class="btn btn-danger btn-xs" onclick="obj.delete(' + full.id + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                    }
                }
            ],
            buttons: [
                {
                    extend: 'excelHtml5',
//                    text: '<i class="fa fa-file-excel-o"></i>',
                    className: 'btn btn-primary glyphicon glyphicon-download',
                    titleAttr: 'Excel'
                },
            ],
        });
    }
    this.tableSpecial = function (id) {
        var obj = {};
        obj.product_id = id;
        return $('#tblSpecial').DataTable({
            "processing": true,
            "serverSide": true,
            destroy: true,
            "ajax": {
                url: "/api/listSpecial",
                type: 'GET',
                data: obj,
            },
            columns: [
                {data: "id"},
                {data: "client_id"},
                {data: "product_id"},
                {data: "price_sf"},
                {data: "margin"},
                {data: "margin_sf"},
                {data: "tax"},
            ],
            order: [[1, 'ASC']],
            aoColumnDefs: [
                {
                    aTargets: [0],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.showModal(' + full.id + ');return false";>' + data + '</a>';
                    }
                }
            ],
        });
    }

}

var obj = new Product();
obj.init();
