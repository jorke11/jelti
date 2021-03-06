function Suppliers() {
    var table, document_id, tableSpecial,tableBranch;
    this.init = function () {
        table = this.table();
        $("#btnSave").click(this.save);
        $("#btnNew").click(this.new);
        
        $("#btnNewSpecial").click(this.newSpecial);
        $("#btnSaveSpecial").click(this.saveSpecial);
        
        $("#btnNewBranch").click(this.newBranch);
        $("#btnSaveBranch").click(this.saveBranch);
        
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
                    id: $("#frm #id").val(),
                    document_id: document_id,

                },
            }).on('fileuploaded', function (event, data, id, index) {
                $("#modalUpload").modal("hide");
                obj.showImages(data.extra.supplier_id);
            }).on('filebrowse', function (event) {
                document_id = $("#frmFile #document_id").val()
            });

            $("#modalUpload").modal("show");
        })

        $("#tabSpecial").click(function () {
            $(".input-special").cleanFields();
            tableSpecial = obj.tableSpecial($("#frm #id").val());
        })
        $("#tabManagement").click(function () {
            $(".input-supplier").cleanFields();
        })
        $("#tabList").click(function () {
            $("#tabSpecial").addClass("hide");
            $("#tabBranch").addClass("hide");
        })
        $("#tabBranch").click(function () {
            $(".input-branch").cleanFields();
            tableBranch = obj.tableBranch($("#frm #id").val());
        })

        $("#reset").click(function () {
            obj.MarkPrice(null, $("#frm #id").val());
        });
    }

    this.newSpecial = function () {
        $(".input-special").cleanFields();
    }
    
    this.newBranch = function () {
        $(".input-branch").cleanFields();
    }
    
    this.new = function () {
        $(".input-supplier").cleanFields();
    }


    this.saveSpecial = function () {
        toastr.remove();
        var frm = $("#frmSpecial");
        $("#frmSpecial #client_id").val($("#frm #id").val());
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frmSpecial #id").val();

        var msg = '';

        var validate = $(".input-special").validate();

        if (validate.length == 0) {
            if (id == '') {
                method = 'POST';
                url = "supplier/StoreSpecial";
                msg = "Created Record";
            } else {
                method = 'PUT';
                url = "supplier/UpdateSpecial/" + id;
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
    
    this.saveBranch = function () {
        toastr.remove();
        var frm = $("#frmBranch");
        $("#frmBranch #client_id").val($("#frm #id").val());
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frmSpecial #id").val();

        var msg = '';

        var validate = $(".input-branch").validate();

        if (validate.length == 0) {
            if (id == '') {
                method = 'POST';
                url = "supplier/StoreBranch";
                msg = "Created Record";
            } else {
                method = 'PUT';
                url = "supplier/UpdateBranch/" + id;
                msg = "Edited Record";
            }

            $.ajax({
                url: url,
                method: method,
                data: data,
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == 'true') {
                        tableBranch.ajax.reload();
                        toastr.success(msg);
                    }
                }
            })
        } else {

            toastr.error("Fields Required!");
        }
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
            html += '<tr><td>' + val.id + '</td><td><a href="images/supplier/' + val.path + '" target="_blank">See</a></td>';
            html += '<td><button class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></td></tr>';
        })
        $("#contentAttach tbody").html(html);
    }

    this.save = function () {
        var frm = $("#frm");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frm #id").val();
        var msg = '';

        var validate = $(".input-supplier").validate();
        if (validate.length == 0) {
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
        } else {
            toastr.error("Fields Required!");
        }
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
                $("#tabSpecial").removeClass("hide");
                $("#tabBranch").removeClass("hide");
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
    
    this.deleteBranch = function (id) {
        toastr.remove();
        if (confirm("Deseas eliminar")) {
            var token = $("input[name=_token]").val();
            var url = "/supplier/deleteBranch/" + id;
            $.ajax({
                url: url,
                headers: {'X-CSRF-TOKEN': token},
                method: "DELETE",
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == true) {
                        tableBranch.ajax.reload();
                        toastr.warning("Ok");
                    }
                }, error: function (err) {
                    toastr.error("No se puede borrra Este registro");
                }
            })
        }
    }

    this.MarkPrice = function (id, client_id) {
        toastr.remove();
        var obj = {};
        obj.id = id;
        $.ajax({
            url: 'supplier/updatePrice/' + client_id,
            method: 'PUT',
            data: obj,
            dataType: 'JSON',
            success: function (data) {
                if (data.success == true) {
                    toastr.success('Updated');
                    tableSpecial.ajax.reload();
                }
            }
        })
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
                {data: "id"},
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
                        return '<a href="#" onclick="obj.showModal(' + full.id + ')">' + data + '</a>';
                    }
                },
                {
                    targets: [14],
                    searchable: false,
                    mData: null,
                    mRender: function (data, type, full) {
                        return '<button class="btn btn-danger btn-xs" onclick="obj.delete(' + data.id + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                    }
                }
            ],
        });
    }

    this.tableSpecial = function (id) {
        var obj = {}, checked = false;
        obj.client_id = id;

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
                        return '<a href="#" onclick="obj.showModal(' + full.id + ')">' + data + '</a>';
                    }
                }
                ,
                {
                    targets: [7],
                    searchable: false,
                    mData: null,
                    mRender: function (data, type, full) {
                        checked = (data.priority == true) ? 'checked' : '';
//                        return '<button class="btn btn-danger btn-xs" onclick="obj.delete(' + data.id + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                        return '<input type="radio" ' + checked + ' name="all" onclick=obj.MarkPrice(' + data.id + ',' + data.client_id + ')>';
                    }
                }
            ],
        });
    }
    
    this.tableBranch = function (id) {
        var obj = {}, checked = false;
        obj.client_id = id;

        return $('#tblBranch').DataTable({
            "processing": true,
            "serverSide": true,
            destroy: true,
            "ajax": {
                url: "/api/listBranch",
                type: 'GET',
                data: obj,
            },
            columns: [
                {data: "id"},
                {data: "city_id"},
                {data: "address"},
                {data: "name"},
                {data: "phone"},
            ],
            order: [[1, 'ASC']],
            aoColumnDefs: [
                {
                    aTargets: [0],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.showModal(' + full.id + ')">' + data + '</a>';
                    }
                }
                ,
                {
                    targets: [5],
                    searchable: false,
                    mData: null,
                    mRender: function (data, type, full) {
                        return '<button class="btn btn-danger btn-xs" onclick="obj.deleteBranch(' + data.id + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';                        
                    }
                }
            ],
        });
    }


}

var obj = new Suppliers();
obj.init();
