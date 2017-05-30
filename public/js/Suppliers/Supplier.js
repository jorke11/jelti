function Supplier() {
    var table, document_id, tableSpecial, tableContact;
    this.init = function () {

        table = this.table();
        $("#btnSave").click(this.save);
        $("#btnNew").click(this.new);

        $("#btnNewSpecial").click(this.newSpecial);
        $("#btnSaveSpecial").click(this.saveSpecial);

        $("#btnNewContact").click(this.newContact);
        $("#btnSaveContact").click(this.saveContact);

        $("#tabManagement").click(function () {
            $('#myTabs a[href="#management"]').tab('show');
        });

        $("#modalImage").click(function () {
//
//            $("#input-700").fileinput({
//                uploadUrl: "suppliers/upload", // server upload action
//                uploadAsync: true,
//                maxFileCount: 5,
//                uploadExtraData: {
//                    id: $("#frm #id").val(),
//                    document_id: document_id,
//
//                },
//            }).on('fileuploaded', function (event, data, id, index) {
//                $("#modalUpload").modal("hide");
//                obj.showImages(data.extra.suppliers_id);
//            }).on('filebrowse', function (event) {
//                document_id = $("#frmFile #document_id").val()
//            });
//
            $("#frmFile #suppliers_id").val($("#frm #id").val());
            $("#modalUpload").modal("show");
        })

        $("#document").blur(function () {
            if ($(this).val() != '') {
                $("#verification").val(obj.calcularDigitoVerificacion($(this).val()));
            } else {
                $("#verification").val("");
            }
        })

        $("#type_regime_id").change(function () {
            if ($(this).val() == 2) {
                $("#type_person_id option[value=2]").addClass("hidden");
            } else {
                $("#type_person_id option[value=2]").removeClass("hidden");
            }
        });

        $("#addJustify").click(this.addJustify);

        $("#btnUpload").click(function () {

            var formData = new FormData($("#frmFile")[0]);

            $.ajax({
                url: 'suppliers/upload',
                type: 'POST',
                data: formData,
                processData: false,
                cache: false,
                contentType: false,
                dataType: 'JSON',
                beforeSend: function () {
                    $(".cargando").removeClass("hidden");
                },
                success: function (data) {
                    obj.printImages(data);

                }, error: function (xhr, ajaxOptions, thrownError) {
                    //clearInterval(intervalo);
                    console.log(thrownError)
                    alert("Problemas con el archivo, informar a sistemas");
                }
            });
        })


        $("#btnUploadExcel").click(function () {

            var formData = new FormData($("#frmExcel")[0]);

            $.ajax({
                url: 'suppliers/uploadExcel',
                type: 'POST',
                data: formData,
                processData: false,
                cache: false,
                contentType: false,
                dataType: 'JSON',
                beforeSend: function () {
                    $(".cargando").removeClass("hidden");
                },
                success: function (data) {
                    if (data.success == true) {
                        table.ajax.reload();
                        obj.resultTableUpload(data.data);
                        $("#reviewResponse").html("<strong>Result:</strong> Quantity: " + data.quantity + " Inserted: " + data.inserted + " Updated: " +
                                data.updated + " contact new: " + data.contactnew + " contact edit: " + data.contactedit);
                        toastr.success("file uploaded");
                    }
                }, error: function (xhr, ajaxOptions, thrownError) {
                    //clearInte4rval(intervalo);
                    console.log(xhr)
                    console.log(ajaxOptions)
                    console.log(thrownError)
                    alert("Problemas con el archivo, informar a sistemas");
                }
            });
        })

        $("#btnUploadClient").click(function () {

            var formData = new FormData($("#frmClient")[0]);

            $.ajax({
                url: 'suppliers/uploadClient',
                type: 'POST',
                data: formData,
                processData: false,
                cache: false,
                contentType: false,
                dataType: 'JSON',
                beforeSend: function () {
                    $(".cargando").removeClass("hidden");
                },
                success: function (data) {
                    if (data.success == true) {
                        obj.printErrorClient(data.data);
                    }
                }, error: function (xhr, ajaxOptions, thrownError) {
                    //clearInte4rval(intervalo);
                    console.log(xhr)
                    console.log(ajaxOptions)
                    console.log(thrownError)
                    alert("Problemas con el archivo, informar a sistemas");
                }
            });
        })

        $("#tabSpecial").click(function () {
            $(".input-special").cleanFields();
            tableSpecial = obj.tableSpecial($("#frm #id").val());
        })

//        $("#tabManagement").click(function () {
//            $(".input-suppliers").cleanFields({disabled: false});
//            $("#tabBranch").addClass("hide");
//            $("#tabSpecial").addClass("hide");
//        })

        $("#tabList").click(function () {
            $("#tabSpecial").addClass("hide");
            $("#tabBranch").addClass("hide");
        })


        $("#tabContact").click(function () {
            $(".input-contact").cleanFields({disabled: false});
            $("#frmContact #stakeholder_id").val($("#frm #id").val());
            console.log()
            tableContact = obj.tableContact($("#frm #id").val());
        });

        $("#reset").click(function () {
            obj.MarkPrice(null, $("#frm #id").val());
        });

        $("#contract_expiration").datetimepicker({
            format: 'Y-m-d H:i',
        });
    }

    this.printErrorClient = function (detail) {
        var html = "", row;
        $.each(detail, function (i, val) {
            row = JSON.parse(val.data);
            html += "<tr><td>" + val.reason + "</td>"
            html += "<td>" + val.data + "</td></tr>";
        })
        $("#tblUpload tbody").html(html)
    }

    this.addJustify = function () {
        var valid = $(".input-justify").validate();
        $("#frmJustify #suppliers_id").val($("#frm #id").val());

        var data = $("#frmJustify").serialize();

        if (valid.length == 0) {
            $.ajax({
                url: 'suppliers/addChage',
                method: 'post',
                data: data,
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == true) {
                        $("#modelActive").modal("hide");
                    }
                }
            })
        } else {
            toastr.error("Fields Required")
        }

    }


    this.calcularDigitoVerificacion = function (myNit) {
        var vpri,
                x,
                y,
                z;

        // Se limpia el Nit
        myNit = myNit.replace(/\s/g, ""); // Espacios
        myNit = myNit.replace(/,/g, ""); // Comas
        myNit = myNit.replace(/\./g, ""); // Puntos
        myNit = myNit.replace(/-/g, ""); // Guiones

        // Se valida el nit
        if (isNaN(myNit)) {
            toastr.error("El nit/cédula '" + myNit + "' no es válido(a).")
            return "";
        }
        ;

        // Procedimiento
        vpri = new Array(16);
        z = myNit.length;

        vpri[1] = 3;
        vpri[2] = 7;
        vpri[3] = 13;
        vpri[4] = 17;
        vpri[5] = 19;
        vpri[6] = 23;
        vpri[7] = 29;
        vpri[8] = 37;
        vpri[9] = 41;
        vpri[10] = 43;
        vpri[11] = 47;
        vpri[12] = 53;
        vpri[13] = 59;
        vpri[14] = 67;
        vpri[15] = 71;

        x = 0;
        y = 0;
        for (var i = 0; i < z; i++) {
            y = (myNit.substr(i, 1));
            // console.log ( y + "x" + vpri[z-i] + ":" ) ;

            x += (y * vpri [z - i]);
            // console.log ( x ) ;    
        }

        y = x % 11;
        // console.log ( y ) ;

        return (y > 1) ? 11 - y : y;
    }

    this.resultTableUpload = function (detail) {
        var html = "";
        $.each(detail, function (i, val) {
            html += "<tr><td>" + val.business + "</td><td>" + val.business_name + "</td>";
            html += "<td>" + val.document + "</td><td>" + val.contact + "</td><td>" + val.phone_contact + "</td>";
            html += "<td>" + val.email + "</td></tr>";
        })
        $("#tblUpload tbody").html(html)
    }

    this.showModalJustif = function () {
        $("#modelActive").modal("show");
    }

    this.newSpecial = function () {
        $(".input-special").cleanFields();
    }

    this.newContact = function () {
        $(".input-contact").cleanFields();
        $("#btnSaveContact").attr("disabled", false);
    }

    this.new = function () {
        $(".input-suppliers").cleanFields();
        $("#btnSave").attr("disabled", false);
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
                url = "suppliers/StoreSpecial";
                msg = "Created Record";
            } else {
                method = 'PUT';
                url = "suppliers/UpdateSpecial/" + id;
                msg = "Edited Record";
            }

            $.ajax({
                url: url,
                method: method,
                data: data,
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == true) {
                        tableSpecial.ajax.reload();
                        toastr.success(msg);
                    }
                }
            })
        } else {

            toastr.error("Fields Required!");
        }
    }

    this.saveContact = function () {
        toastr.remove();
        var frm = $("#frmContact");
        $("#frmContact #supplier_id").val($("#frm #id").val());
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frmContact #id").val();

        var msg = '';

        var validate = $(".input-contact").validate();

        if (validate.length == 0) {
            if (id == '') {
                method = 'POST';
                url = "suppliers/StoreContact";
                msg = "Created Record";
            } else {
                method = 'PUT';
                url = "suppliers/UpdateContact/" + id;
                msg = "Edited Record";
            }


            $.ajax({
                url: url,
                method: method,
                data: data,
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == true) {
                        tableContact.ajax.reload();
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
            url: 'suppliers/getImages/' + id,
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
            html += '<tr><td>' + val.document + '</td><td>' + val.name + '</td><td><a href="images/suppliers/' + val.path + '" target="_blank">See</a></td>';
            html += '<td><button class="btn btn-xs btn-warning" onclick=obj.deleteImage(' + val.id + ',' + val.suppliers_id + ')><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></td></tr>';
        })
        $("#contentAttach tbody").html(html);
    }

    this.save = function () {
        var frm = $("#frm");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frm #id").val();
        var msg = '';

        var validate = $(".input-suppliers").validate();
        if (validate.length == 0) {
            if (id == '') {
                method = 'POST';
                url = "suppliers";
                msg = "Created Record";

            } else {
                method = 'PUT';
                url = "suppliers/" + id;
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
        var url = "/suppliers/" + id + "/edit";

        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $('#myTabs a[href="#management"]').tab('show');
                $(".input-suppliers").setFields({data: data.header});
                $("#tabSpecial").removeClass("hide");
                $("#tabContact").removeClass("hide");
                obj.printImages(data.images);
            }
        })
    }

    this.deleteImage = function (id, suppliers_id) {
        $("#div_" + id).remove();
        var obj = {};
        obj.suppliers_id = suppliers_id;
        $.ajax({
            url: 'suppliers/deleteImage/' + id,
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
            var url = "/suppliers/" + id;
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

    this.deleteBranch = function (id) {
        toastr.remove();
        if (confirm("Deseas eliminar")) {
            var token = $("input[name=_token]").val();
            var url = "/suppliers/deleteBranch/" + id;
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
            url: 'suppliers/updatePrice/' + client_id,
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
        return $('#tblStakeholder').DataTable({
            bSort: true,
            "dom":
                    "R<'row'<'col-sm-4'l><'col-sm-2 toolbar text-right'><'col-sm-3'B><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12't>>" +
                    "<'row'<'col-xs-3 col-sm-3 col-md-3 col-lg-3'i><'col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center'p><'col-xs-3 col-sm-3 col-md-3 col-lg-3'>>",
            "processing": true,
            "serverSide": true,
            "ajax": "/api/listSupplier",
            "scrollX": true,
            columns: [
                {data: "business_name", sWidth: "15%"},
                {data: "business"},
                {data: "document"},
                {data: "email"},
                {data: "address"},
                {data: "phone"},
                {data: "contact"},
                {data: "phone_contact"},
                {data: "term"},
                {data: "city"},
                {data: "typeperson"},
                {data: "typeregime"},
                {data: "status"},
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
                    aTargets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.showModal(' + full.id + ')">' + data + '</a>';
                    }
                },
                {
                    targets: [13],
                    searchable: false,
                    mData: null,
                    mRender: function (data, type, full) {
                        return '<button class="btn btn-danger btn-xs" onclick="obj.delete(' + data.id + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
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

    this.tableContact = function (id) {
        var obj = {}, checked = false;
        obj.stakeholder_id = id;

        return $('#tblContact').DataTable({
            "processing": true,
            "serverSide": true,
            destroy: true,
            "ajax": {
                url: "/api/listContact",
                type: 'GET',
                data: obj,
            },
            columns: [
                {data: "id"},
                {data: "name"},
                {data: "last_name"},
                {data: "city"},
                {data: "email"},
                {data: "mobile"},
                {data: "city"},
            ],
            order: [[1, 'ASC']],
            aoColumnDefs: [
                {
                    aTargets: [0, 1, 2, 3, 4, 5],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.showModalContact(' + full.id + ')">' + data + '</a>';
                    }
                }
                ,
                {
                    targets: [6],
                    searchable: false,
                    mData: null,
                    mRender: function (data, type, full) {
                        return '<button class="btn btn-danger btn-xs" onclick="obj.deleteContact(' + full.id + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                    }
                }
            ],
        });
    }
}

var obj = new Supplier();
obj.init();
