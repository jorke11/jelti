function User() {
    var table, product_id = 0, $checkableTree;
    this.init = function () {
        table = this.table();
        $("#btnNew").click(this.new);
        $("#btnSave").click(this.save);
        $("#tabManagement").click(function () {
            $('#myTabs a[href="#management"]').tab('show');
        });

        $("#tabManagement").click(function () {
            $(".input-user").cleanFields({disabled: true});
        })

        $("#tabPermission").click(function () {
            obj.getListPermission();
        });

        $('#btnPermission').on('click', function () {
            obj.savePermission();
        });

    }

    this.new = function () {
        $("#btnSave").attr("disabled", false);
        $(".input-user").cleanFields({disabled: false});
    }

    this.getTree = function (permission) {
        $("#treeview-container").html("");
        var html = "<ul>", checked = "", check = "";
        $.each(permission, function (i, val) {

            checked = (val.allowed == true) ? "data-checked=true" : '';

            if (val.nodes) {
                html += '<li data-value="' + val.id + '" ' + checked + '> ' + val.title;
                html += "<ul>";
                $.each(val.nodes, function (i, value) {
                    check = (value.allowed == true) ? "data-checked=true" : ''
                    html += '<li data-value="' + value.id + '"  ' + check + '> ' + value.title + "</li>";
                });
                html += "</ul></li>";

            } else {
                html += '<li data-value="' + val.id + '" ' + checked + '> ' + val.title + '</li>';
            }
        });
        html += "</ul>";

        $("#treeview-container").html(html);

        $('#treeview-container').treeview({
            debug: false,
            data: ['3.2', '2.2.3']
        });


    }

    this.savePermission = function () {
        toastr.remove();
        var data = {};
        data.arr = ($('#treeview-container').treeview('selectedValues')).join();
        $.ajax({
            url: 'user/savePermission/' + $("#frm #id").val(),
            method: 'PUT',
            data: data,
            dataType: 'JSON',
            success: function (data) {
                toastr.success("Process Ok");
            }
        })
    }

    this.getListPermission = function () {

        $.ajax({
            url: 'user/getListPermission/' + $("#frm #id").val(),
            method: 'GET',
            dataType: 'JSON',
            success: function (data) {

                obj.getTree(data.tree)
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

        var validate = $(".input-user").validate();

        if (validate.length == 0) {
            var msg = '';
            if (id == '') {
                method = 'POST';
                url = "user";
                msg = "Created Record";
            } else {
                method = 'PUT';
                url = "user/" + id;
                msg = "Edited Record";
            }

            $.ajax({
                url: url,
                method: method,
                data: data,
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == true) {
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
        var url = "/user/" + id + "/edit";
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $('#myTabs a[href="#management"]').tab('show');
                $(".input-user").setFields({data: data.header, disabled: false});
                $("#btnSave").attr("disabled", false);
                if (data.header.status == true) {
                    $("#frm #status").prop("checked", true);
                } else {
                    $("#frm #status").prop("checked", false);
                }
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
                    if (data.success == true) {
                        table.ajax.reload();
                        toastr.warning("Ok");
                    }
                }, error: function (err) {
                    toastr.error("No se puede borrra Este registro");
                }
            })
        }
    }

    this.showPermission = function () {
        $('#myTabs a[href="#permission"]').tab('show');
    }

    this.table = function () {
        return $('#tbl').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/api/listUser",
            columns: [
                {data: "id"},
                {data: "name"},
                {data: "email"},
                {data: "role"},
                {data: "stakeholder"},
                {data: "city"},
                {data: "status"},
            ],
            order: [[0, 'ASC']],
            aoColumnDefs: [
                {
                    aTargets: [0, 1, 2, 3, 4, 5, 6],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.showModal(' + full.id + ')">' + data + '</a>';
                    }
                },
                {
                    targets: [7],
                    searchable: false,
                    mData: null,
                    mRender: function (data, type, full) {
                        var html = '<button class="close" aria-label="Close" onclick="obj.delete(' + full.id + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                        html += '<button class="btn btn-primary btn-xs" onclick="obj.showPermission()"><i class="fa fa-unlock-alt" aria-hidden="true"></i></button>';
                        return html;
                    }
                }
            ],
        });
    }

}

var obj = new User();
obj.init();
