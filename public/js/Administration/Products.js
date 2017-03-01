function Product() {
    var table, product_id = 0;
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
            $(".input-product").cleanFields();
        });

        $("#tabSpecial").click(function () {
            $(".input-special").cleanFields();
        })
    }
    this.new = function () {
        $(".input-product").cleanFields();
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
                    '<div class="thumbnail">' +
                    '<img src="/images/product/' + val.path + '" alt="Product">' +
                    '<div class="caption">' +
                    '<h4>Check Main <input type="radio" name="main[]" onclick=obj.checkMain(' + val.id + ',' + val.id + ')></h4>' +
                    '<p><button type="button" class="btn btn-primary btn-xs" aria-label="Left Align" ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>' +
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
        var frm = $("#frm");
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
                $(".input-product").setFields({data: data.header});


                if (data.header.image != null) {
                    $("#imageMain").attr("src", "/images/product/" + data.header.image);
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
            "serverSide": true,
            "ajax": "/api/listProduct",
            columns: [
                {data: "id"},
                {data: "title"},
                {data: "description"},
                {data: "reference"},
                {data: "bar_code"},
                {data: "units_supplier"},
                {data: "units_sf"},
                {data: "cost_sf"},
                {data: "tax"},
                {data: "price_sf"},
                {data: "price_cust"},
                {data: "image", width: 10, render: function (data, type, row) {

                        if (data == null) {
                            data = "default.jpg";
                        }
                        return '<img src="/images/product/' + data + '" width="25px">';
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
                        return '<a href="#" onclick="obj.showModal(' + full.id + ')">' + data + '</a>';
                    }
                },
                {
                    targets: [13],
                    searchable: false,
                    mData: null,
                    mRender: function (data, type, full) {
                        return '<button class="btn btn-danger btn-xs" onclick="obj.delete(' + full.id + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                    }
                }
            ],
        });
    }

}

var obj = new Product();
obj.init();
