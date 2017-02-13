function Product() {
    var table;
    this.init = function () {
        table = this.table();
        $("#new").click(this.save);
        $("#edit").click(this.edit);
        $("#tabManagement").click(function () {
            $(".input-product").val("");
            $('#myTabs a[href="#management"]').tab('show');
        });

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
                $("#frm #id").val(data.id);
                $("#frm #title").val(data.title);
                $("#frm #description").val(data.description);
                $("#frm #short_description").val(data.short_description);
                $("#frm #reference").val(data.reference);
                $("#frm #units_supplier").val(data.units_supplier);
                $("#frm #units_sf").val(data.units_sf);
                $("#frm #cost_sf").val(data.cost_sf);
                $("#frm #tax").val(data.tax);
                $("#frm #price_sf").val(data.price_sf);
                $("#frm #price_cust").val(data.price_cust);
                $("#frm #category_id").val(data.category_id);
                $("#frm #supplier_id").val(data.supplier_id);
                $("#frm #url_part").val(data.url_part);
                $("#frm #bar_code").val(data.bar_code);
                $("#frm #status").val(data.status);
                $("#frm #meta_title").val(data.meta_title);
                $("#frm #meta_keywords").val(data.meta_keywords);
                $("#frm #meta_description").val(data.meta_description);
                $("#frm #minimun_stock").val(data.minimun_stock);
                $("#frm #image").val(data.Image);
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
                {data: "image"},
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
                        return '<button class="btn btn-danger" onclick="obj.delete(' + full.id + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                    }
                }
            ],
        });
    }

}

var obj = new Product();
obj.init();
