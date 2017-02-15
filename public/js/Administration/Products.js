function Product() {
    var table, product_id = 0;
    this.init = function () {
        table = this.table();
        $("#new").click(this.save);
        $("#edit").click(this.edit);
        $("#tabManagement").click(function () {
            $(".input-product").val("");
            $('#myTabs a[href="#management"]').tab('show');
        });
        $("#modalImage").click(function () {

            $("#input-700").fileinput({
                uploadUrl: "product/upload", // server upload action
                uploadAsync: true,
                maxFileCount: 5,
                allowedFileExtensions: ['jpg', 'png', 'gif'],
                uploadExtraData: {
                    product_id: $("#frm #id").val()
                },
            }).on('fileuploaded', function (event, data, id, index) {
                $("#modalUpload").modal("hide");
                obj.showImages(data.extra.product_id);
            })

            $("#modalUpload").modal("show");
        })
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
                    '<h4>Check Main <input type="radio" name="main[]" onclick=obj.checkMain(' + val.id + ',' + val.product_id + ')></h4>' +
                    '<p><button type="button" class="btn btn-primary btn-xs" aria-label="Left Align" ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>' +
                    '<button type="button" class="btn btn-danger btn-xs" onclick=obj.deleteImage(' + val.id + ',' + val.product_id + ')><span class="glyphicon glyphicon-remove" aria-hidden="true" ></span></button>' +
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
        var frm = $("#frm");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frm #id").val();
        var msg = '';
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
                $("#frm #id").val(data.header.id);
                $("#frm #title").val(data.header.title);
                $("#frm #description").val(data.header.description);
                $("#frm #short_description").val(data.header.short_description);
                $("#frm #reference").val(data.header.reference);
                $("#frm #units_supplier").val(data.header.units_supplier);
                $("#frm #units_sf").val(data.header.units_sf);
                $("#frm #cost_sf").val(data.header.cost_sf);
                $("#frm #tax").val(data.header.tax);
                $("#frm #price_sf").val(data.header.price_sf);
                $("#frm #price_cust").val(data.header.price_cust);
                $("#frm #category_id").val(data.header.category_id);
                $("#frm #supplier_id").val(data.header.supplier_id);
                $("#frm #url_part").val(data.header.url_part);
                $("#frm #bar_code").val(data.header.bar_code);
                $("#frm #status").val(data.header.status);
                $("#frm #meta_title").val(data.header.meta_title);
                $("#frm #meta_keywords").val(data.header.meta_keywords);
                $("#frm #meta_description").val(data.header.meta_description);
                $("#frm #minimun_stock").val(data.header.minimun_stock);
                $("#frm #image").val(data.header.Image);
                $("#imageMain").attr("src", "/images/product/" + data.header.image);
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
                {data: "image", render: function (data, type, row) {

                        if (data == null) {
                            data = "default.jpg";
                        }
                        return '<img src="/images/product/' + data + '" width="50%">';
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
