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
    }

    this.save = function () {
        var frm = $("#frm");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frm #id").val();
        var msg = '';
        if (id == '') {
            method = 'POST';
            url = "supplier";
            msg="Created Record";
 
        } else {
            method = 'PUT';
            url = "supplier/" + id;
            msg="Edited Record";
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
                $("#frm #id").val(data.id);
                $("#frm #name").val(data.name);
                $("#frm #last_name").val(data.last_name);
                $("#frm #document").val(data.document);
                $("#frm #phone").val(data.phone);
                $("#frm #email").val(data.email);
                $("#frm #address").val(data.address);
                $("#frm #term").val(data.term);
                $("#frm #city_id").val(data.city_id);
                $("#frm #web_site").val(data.web_site);
                $("#frm #contact").val(data.contact);
                $("#frm #phone_contact").val(data.phone_contact);
                $("#frm #type_regimen_id").val(data.type_regimen_id);
                $("#frm #type_person_id").val(data.type_person_id);
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
                {data: "type_person_id"},
                {data: "type_regime_id"},
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

}

var obj = new Suppliers();
obj.init();
