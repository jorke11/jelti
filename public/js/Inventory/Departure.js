function Sale() {
    var table, maxDeparture = 0;
    this.init = function () {
        table = this.table();
        $("#btnNew").click(this.new);
        $("#btnSave").click(this.save);
        $("#newDetail").click(this.saveDetail);
        $(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii'});
        $("#edit").click(this.edit);
        $("#tabManagement").click(function () {
//            $(".input-entry").val("");
            $('#myTabs a[href="#management"]').tab('show');
        });

        $("#client_id").change(function () {
            if ($(this).val() != 0) {
                obj.getSupplier($(this).val());
            } else {
                $("#frm #name_client").val("");
                $("#frm #address_supplier").val("");
                $("#frm #phone_supplier").val("");
            }
        });

        if ($("#id_orderext").val() != '') {
            obj.infomationExt($("#id_orderext").val(), true);
        }

        $("#insideManagement").click(function () {
            $(".input-departure").cleanFields();
            $("#frm #consecutive").val(1);
            $("#frm #warehouse_id").getSeeker({default: true, api: '/api/getWarehouse', disabled: true});
            $("#frm #responsible_id").getSeeker({default: true, api: '/api/getResponsable', disabled: true});
            $("#frm #city_id").getSeeker({default: true, api: '/api/getCity', disabled: true});
            $("#frm #status_id").val(1).trigger('change');
            $("#frm #status_id").prop("disabled", true);
            $.ajax({
                url: 'departure/1/consecutive',
                method: 'GET',
                dataType: 'JSON',
                success: function (resp) {

                }
            })
        });

        $("#btnmodalDetail").click(function () {
            $("#modalDetail").modal("show");
            $("#frmDetail #product_id").getSeeker({filter: {supplier_id: $("#frm #supplier_id").val()}});
            $(".input-detail").cleanFields();

        });

        $("#frmDetail #product_id").change(function () {
            $.ajax({
                url: 'departure/' + $(this).val() + '/getDetailProduct',
                method: 'GET',
                dataType: 'JSON',
                success: function (resp) {
                    $("#frmDetail #category_id").val(resp.response.id).trigger('change');
                    $("#frmDetail #value").val(resp.response.price_sf)

                    $("#frmDetail #quantityMax").html(resp.quantity)
                    if (resp.quantity > 0) {
                        $("#frmDetail #quantity").attr("disabled", false);
                        $("#newDetail").attr("disabled", false);
                    } else {
                        $("#newDetail").attr("disabled", true);
                        $("#frmDetail #quantity").attr("disabled", true);
                    }

                }
            })
        });


        $("#quantity").blur(function () {
            if (maxDeparture < $(this).val()) {
                toastr.warning("No hay sufiente disponible");
                $(this).val("");
            }
        });
    }

    this.new = function () {
        toastr.remove();
        $(".input-departure").cleanFields();

        $(".input-detail").cleanFields();
        $(".input-fillable").prop("readonly", false);
        $("#tblDetail tbody").empty();
        $("#frm #status_id").val(1).trigger("change").prop("disabled", true);
        $("#frm #supplier_id").prop("disabled", false);
        $("#btnSave").prop("disabled", false);
        $("#frm #warehouse_id").getSeeker({default: true, api: '/api/getWarehouse', disabled: true});
        $("#frm #responsible_id").getSeeker({default: true, api: '/api/getResponsable', disabled: true});
        $("#frm #city_id").getSeeker({default: true, api: '/api/getCity', disabled: true});
    }
    this.getSupplier = function (id, path) {
        var url='entry/' + id + '/getSupplier';
        if (path == undefined) {
            url='../../entry/' + id + '/getSupplier';
        }

        $.ajax({
            url:url,
            method: 'GET',
            dataType: 'JSON',
            success: function (resp) {
                $("#frm #name_client").val(resp.response.name + " " + resp.response.last_name);
                $("#frm #address").val(resp.response.address);
                $("#frm #phone").val(resp.response.phone);
            }
        })
    }

    this.save = function () {
        $("#frm #warehouse_id").prop("disabled", false);
        $("#frm #responsible_id").prop("disabled", false);
        $("#frm #city_id").prop("disabled", false);
        var frm = $("#frm");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frm #id").val();
        var msg = '';

        if ($("#id_orderext").val() == '') {
            if (id == '') {
                method = 'POST';
                url = "departure";
                msg = "Created Record";

            } else {
                method = 'PUT';
                url = "departure/" + id;
                msg = "Edited Record";
            }

            $.ajax({
                url: url,
                method: method,
                data: data,
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == 'true') {
                        $("#frm #id").val(data.data.id);
                        table.ajax.reload();
                        toastr.success(msg);
                        $("#btnmodalDetail").attr("disabled", false);

                    }
                }
            })
        } else {
            var obj = {};
            obj.id = $("#id_orderext").val();
            $.ajax({
                url: "../../departure/storeExt",
                method: 'POST',
                data: data,
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == 'true') {
                        $("#frm #id").val(data.data.id);
                        table.ajax.reload();
                        toastr.success("ok");
                        $("#btnmodalDetail").attr("disabled", false);
                        location.href="/";
                    }
                }
            })
        }
    }

    this.saveDetail = function () {
        $("#frmDetail #departure_id").val($("#frm #id").val());
        var frm = $("#frmDetail");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frmDetail #id").val();
        var msg = 'Record Detail';
        if (id == '') {
            method = 'POST';
            url = "departure/storeDetail";
            msg = "Created " + msg;

        } else {
            method = 'PUT';
            url = "departure/detail/" + id;
            msg = "Edited " + msg;
        }

        $.ajax({
            url: url,
            method: method,
            data: data,
            dataType: 'JSON',
            success: function (data) {
                if (data.success == 'true') {
                    toastr.success(msg);
                    $("#btnmodalDetail").attr("disabled", false);
                    obj.printDetail(data.data);
//                    $("#modalDetail").modal("hide");
                    $("#newDetail").attr("disabled", true);
                    $("#frmDetail #quantity").attr("disabled", true);
                }
            }
        })

    }

    this.showModal = function (id) {
        var frm = $("#frmEdit");
        var data = frm.serialize();
        var url = "/departure/" + id + "/edit";
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $('#myTabs a[href="#management"]').tab('show');
                $(".input-departure").setFields({data: data.header});

                if (data.header.id != '') {
                    $("#btnmodalDetail").attr("disabled", false);
                }

                obj.printDetail(data.detail);
            }
        })
    }

    this.infomationExt = function (id) {
        var frm = $("#frmEdit");
        var data = frm.serialize();
        var url = "/departure/" + id + "/editExt";
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
              
                $('#myTabs a[href="#management"]').tab('show');
                $(".input-departure").setFields({data: data.header});

                if (data.header.id != '') {
                    $("#btnmodalDetail").attr("disabled", false);
                }

                obj.printDetail(data.detail);
            }
        })
    }

    this.editDetail = function (id) {
        var frm = $("#frm");
        var data = frm.serialize();
        var url = "/departure/" + id + "/detail";
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $("#modalDetail").modal("show");
                $(".input-detail").setFiedls({data:data})
            }
        })
    }

    this.printDetail = function (data) {
        var html = "";
        $("#tblDetail tbody").empty();
        $.each(data, function (i, val) {
            html += "<tr>";
            html += "<td>" + val.id + "</td>";
            html += "<td>" + val.product_id + "</td>";
            html += "<td>" + val.quantity + "</td>";
            html += "<td>" + val.value + "</td>";
            html += '<td><button type="button" class="btn btn-xs btn-primary" onclick=obj.editDetail(' + val.id + ')>Edit</button>';
            html += '<button type="button" class="btn btn-xs btn-warning" onclick=obj.deleteDetail(' + val.id + ')>Delete</button></td>';
            html += "</tr>";
        });

        $("#tblDetail tbody").html(html);
    }

    this.delete = function (id) {
        toastr.remove();
        if (confirm("Deseas eliminar")) {
            var token = $("input[name=_token]").val();
            var url = "/departure/" + id;
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

    this.deleteDetail = function (id) {
        toastr.remove();
        if (confirm("Do you want delete this record?")) {
            var token = $("input[name=_token]").val();
            var url = "/departure/detail/" + id;
            $.ajax({
                url: url,
                headers: {'X-CSRF-TOKEN': token},
                method: "DELETE",
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == 'true') {
                        toastr.warning("Record deleted");
                        obj.printDetail(data.data);
                    }
                }, error: function (err) {
                    toastr.error("No se puede borrra Este registro");
                }
            })
        }
    }

    this.table = function () {
        return $('#tbl').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/api/listDeparture",
            columns: [
                {data: "id"},
                {data: "id"},
                {data: "created"},
                {data: "order"},
                {data: "warehouse_id"},
                {data: "city_id"},
                {data: "status_id"},
            ],
            order: [[1, 'ASC']],
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
                    "mData": null,
                    "mRender": function (data, type, full) {
                        return '<button class="btn btn-danger btn-xs" onclick="obj.delete(' + data.id + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                    }
                }
            ],
        });
    }

}

var obj = new Sale();
obj.init();