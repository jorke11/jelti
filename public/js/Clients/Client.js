function Client() {
    var table, document_id, tableSpecial, tableContact;
    this.init = function () {

        table = this.table();
        $("#btnSave").click(this.save);
        $("#btnNew").click(this.new);
        $("#btnNewSpecial").click(this.newSpecial);
        $("#btnSaveSpecial").click(this.saveSpecial);
        $("#btnNewContact").click(this.newContact);
        $("#btnSaveContact").click(this.saveContact);
        $("#tabInvoice").click(function () {
            obj.tableInvoice($("#frm #id").val());
        });
        //        $("#tabContact").click(function () {
        //            $(".input-contact").cleanFields({disabled: true});
        //
        //        });

        $("#modalImage").click(function () {
            //
            //            $("#input-700").fileinput({
            //                uploadUrl: "clients/upload", // server upload action
            //                uploadAsync: true,
            //                maxFileCount: 5,
            //                uploadExtraData: {
            //                    id: $("#frm #id").val(),
            //                    document_id: document_id,
            //
            //                },
            //            }).on('fileuploaded', function (event, data, id, index) {
            //                $("#modalUpload").modal("hide");
            //                obj.showImages(data.extra.clients_id);
            //            }).on('filebrowse', function (event) {
            //                document_id = $("#frmFile #document_id").val()
            //            });
            //
            $("#frmFile #clients_id").val($("#frm #id").val());
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
        //        $("#frm #stakeholder_id").change(function () {
        //            if ($(this).val() != 0) {
        //                if (confirm("La informacion del formulario de Sobreescribira, esta seguro de carga los datos?")) {
        //                    obj.getCuenta($(this).val());
        //                }
        //
        //            }
        //        });

        $("#frm #stakeholder_id").on('select2:closing', function (evt) {
            var cont = 0;
            var elem = $(this);
            $(".input-clients").each(function () {
                if ($(this).val() != '') {
                    cont++;
                }
            })

            if (cont > 0) {
                if (confirm("Los datos del formulario se reemplazaran, esta seguro que quiere seleccionarlo?")) {
                    var frm = $("#frm");
                    var data = frm.serialize();
                    var url = "/clients/" + elem.val() + "/edit";
                    $.ajax({
                        url: url,
                        method: "GET",
                        data: data,
                        success: function (resp) {
                            var stakeholder = resp.header.stakeholder_id;
                            delete resp.header.stakeholder_id;

                            $(".input-clients").setFields({data: resp.header});
                            $("#frm #id").val("");
                        }
                    })
                }
            }
        });

        $("#addJustify").click(this.addJustify);
        $("#btnUpload").click(function () {

            var formData = new FormData($("#frmFile")[0]);
            $.ajax({
                url: 'clients/upload',
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
                url: 'clients/uploadExcel',
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
                url: 'clients/uploadClient',
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

        $("#frmSpecial #product_id").change(function () {
            var param = {};
            param.client_id = $("#frm #id").val();
            $.ajax({
                url: 'departure/' + $(this).val() + '/getDetailProduct',
                method: 'GET',
                data: param,
                dataType: 'JSON',
                success: function (resp) {
                    $("#frmSpecial #tax").val(resp.response.tax);
                    $("#frmSpecial #price_sf").val(resp.response.price_sf);
                }, error: function (xhr, ajaxOptions, thrownError) {
                    toastr.error(xhr.responseJSON.msg);
                }
            })
        });
        $("#tabList").click(function () {
            $("#tabSpecial").addClass("hide");
            $("#tabContact").addClass("hide");
            $("#tabInvoice").addClass("hide");
        })
        $("#tabContact").click(function () {
            $(".input-contact").cleanFields({disabled: true});
            $("#frmContact #stakeholder_id").val($("#frm #id").val());
            tableContact = obj.tableContact($("#frm #id").val());
        });
        $("#reset").click(function () {
            obj.MarkPrice(null, $("#frm #id").val());
        });
        $("#contract_expiration").datetimepicker({
            format: 'Y-m-d H:i',
        });
        $("#btnComment").click(this.addCommnet);
        $("#btnUpload_code").click(this.uploadExcelCode)

    }

    this.uploadExcelCode = function () {
        $("#frmFileCode #client_id").val($("#frm #id").val());
        var formData = new FormData($("#frmFileCode")[0]);
        $.ajax({
            url: '/clients/uploadExcelCode',
            method: 'POST',
            data: formData,
            dataType: 'JSON',
            processData: false,
            cache: false,
            contentType: false,
            success: function (data) {
                obj.setDetailExcel(data.data)
            }
        })

    }

    this.setDetailExcel = function (detail) {
        var html = "";
        console.log(detail)
        $.each(detail, function (i, val) {
            html += "<tr><td>" + val.item + "</td><td>" + val.reference + "</td><td>" + val.title + "</td><td>" + val.bar_code + "</td><td>" + val.price_sf + "</td></tr>";
        })
        $("#tblUpload tbody").html(html);
    }


    this.getCuenta = function (id, path) {
        var html = "";
        var url = 'departure/' + id + '/getClient';
        if (path == undefined) {
            url = '../../departure/' + id + '/getClient';
        }

        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'JSON',
            success: function (resp) {
                $("#frm #business").val(resp.data.client.business);
                $("#frm #business_name").val(resp.data.client.business_name);
                $("#frm #document").val(resp.data.client.document);
                $("#frm #term").val(resp.data.client.term);
                $("#frm #web_site").val(resp.data.client.web_site);
                $("#frm #email").val(resp.data.client.email);
                $("#frm #verification").val(resp.data.client.verification);
                $("#frm #address").val(resp.data.client.address_send);
                $("#frm #phone").val(resp.data.client.phone);
                $("#frm #city_id").setFields({data: {city_id: resp.data.client.city_id}});
                $("#frm #destination_id").setFields({data: {destination_id: resp.data.client.city_id}});
                $("#frm #responsible_id").setFields({data: {responsible_id: resp.data.client.responsible_id}});
                console.log(resp.data.client)
            }
        })
    }

    this.addCommnet = function () {
        var data = {};
        data.comment = $("#txtComment").val();
        data.client_id = $("#frm #id").val();
        $.ajax({
            url: 'clients/addComment',
            method: 'post',
            data: data,
            dataType: 'JSON',
            success: function (data) {
                if (data.success == true) {
                    $("#modelActive").modal("hide");
                    obj.tableComment(data.detail)
                }
            }
        })
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
        $("#frmJustify #clients_id").val($("#frm #id").val());
        var data = $("#frmJustify").serialize();
        if (valid.length == 0) {
            $.ajax({
                url: 'clients/addChage',
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
        $(".input-clients").cleanFields();
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
                url = "clients/StoreSpecial";
                msg = "Created Record";
            } else {
                method = 'PUT';
                url = "clients/updatePriceId/" + id;
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
        $("#frmContact #stakeholder_id").val($("#frm #id").val());
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frmContact #id").val();
        var msg = '';
        var validate = $(".input-contact").validate();
        if (validate.length == 0) {
            if (id == '') {
                method = 'POST';
                url = "clients/StoreContact";
                msg = "Created Record";
            } else {
                method = 'PUT';
                url = "clients/UpdateContact/" + id;
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
            url: 'clients/getImages/' + id,
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
            html += '<tr><td>' + val.document + '</td><td>' + val.name + '</td><td><a href="images/clients/' + val.path + '" target="_blank">See</a></td>';
            html += '<td><button class="btn btn-xs btn-warning" onclick=obj.deleteImage(' + val.id + ',' + val.clients_id + ')><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></td></tr>';
        })
        $("#contentAttach tbody").html(html);
    }

    this.save = function () {
        var frm = $("#frm");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frm #id").val();
        var msg = '';
        var validate = $(".input-clients").validate();
        if (validate.length == 0) {
            if (id == '') {
                method = 'POST';
                url = "clients";
                msg = "Created Record";
            } else {
                method = 'PUT';
                url = "clients/" + id;
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
                }, error: function (xhr, ajaxOptions, thrownError) {
                    toastr.error(xhr.responseJSON.msg);
                }
            })
        } else {
            toastr.error("Fields Required!");
        }
    }

    this.showModal = function (id) {
        var frm = $("#frm");
        var data = frm.serialize();
        var url = "/clients/" + id + "/edit";
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            beforeSend: function () {
                $("#loading-super").removeClass("hidden");
            },
            success: function (data) {
                $(".input-clients").setFields({data: data.header});
                obj.printImages(data.images);
                obj.tableComment(data.comments);
            },
            complete: function (data) {
                $('#myTabs a[href="#management"]').tab('show');
                $("#btnSave").attr("disabled", false);
                $("#tabSpecial").removeClass("hide");
                $("#tabContact").removeClass("hide");
                $("#tabInvoice").removeClass("hide");
                $("#loading-super").addClass("hidden");
            }
        })
    }

    this.tableComment = function (detail) {
        var html = '';
        $("#listComments").empty();
        $.each(detail, function (i, val) {
            html += '<li class="list-group-item"><span class="badge">' + val.name + '</span>[' + val.created_at + ']' + val.description + '</li>';
        })
        $("#listComments").html(html);
    }

    this.showModalContact = function (id) {
        var frm = $("#frm");
        var data = frm.serialize();
        var url = "/clients/contact/" + id;
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            beforeSend: function () {
                $("#loading-super").removeClass("hidden");
            },
            success: function (data) {
                $(".input-contact").setFields({data: data});
                $("#btnSaveContact").attr("disabled", false);
            },
            complete: function (data) {
                $("#loading-super").addClass("hidden");
            }
        })
    }

    this.deleteImage = function (id, clients_id) {
        $("#div_" + id).remove();
        var obj = {};
        obj.clients_id = clients_id;
        $.ajax({
            url: 'clients/deleteImage/' + id,
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
            var url = "/clients/" + id;
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

    this.deleteContact = function (id) {
        toastr.remove();
        if (confirm("Deseas eliminar")) {
            var token = $("input[name=_token]").val();
            var url = "/clients/deleteContact/" + id;
            $.ajax({
                url: url,
                headers: {'X-CSRF-TOKEN': token},
                method: "DELETE",
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == true) {
                        tableContact.ajax.reload();
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
            url: 'clients/updatePrice/' + client_id,
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
        var tableStake = $('#tblStakeholder').DataTable({
            bSort: true,
            "dom":
                    "R<'row'<'col-sm-4'l><'col-sm-2 toolbar text-right'><'col-sm-3'B><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12't>>" +
                    "<'row'<'col-xs-3 col-sm-3 col-md-3 col-lg-3'i><'col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center'p><'col-xs-3 col-sm-3 col-md-3 col-lg-3'>>",
            "processing": true,
            "serverSide": true,
            "ajax": "/api/listClient",
            "scrollX": true,
            columns: [
                {
                    className: 'details-control',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                    searchable: false,
                },
                {data: "business_name"},
                {data: "business"},
                {data: "document"},
                {data: "email"},
                {data: "address"},
                {data: "term"},
                {data: "city"},
                {data: "responsible"},
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
            order: [[2, 'ASC']],
            aoColumnDefs: [
                {
                    aTargets: [1, 2, 3, 4, 5, 6],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.showModal(' + full.id + ')">' + data + '</a>';
                    }
                },
                {
                    targets: [12],
                    searchable: false,
                    mData: null,
                    mRender: function (data, type, full) {
                        return '<button class="btn btn-danger btn-xs" onclick="obj.delete(' + data.id + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                    }
                }
            ],
            //            initComplete: function () {
            //                this.api().columns().every(function () {
            //                    var column = this;
            //                    var type = $(column.header()).attr('rowspan');
            //                    if (type != undefined) {
            //                        var select = $('<select class="form-control"><option value="">' + $(column.header()).text() + '</option></select>')
            //                                .appendTo($(column.footer()).empty())
            //                                .on('change', function () {
            //                                    var val = $.fn.dataTable.util.escapeRegex(
            //                                            $(this).val()
            //                                            );
            //                                    column
            ////                                            .search(val ? val : '', true, false)
            //                                            .search(val ? '^' + val + '$' : '', true, false)
            //                                            .draw();
            //                                });
            //                        column.data().unique().sort().each(function (d, j) {
            //                            select.append('<option value="' + d + '">' + d + '</option>')
            //                        });
            //                    }
            //                });
            //            },
        });
        $('#tblStakeholder tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                row.child(obj.format(row.data())).show();
                tr.addClass('shown');
            }
        });
        return tableStake;
    }

    this.format = function (d) {

        var html = '<br><table class="table-detail">';
        html += '<thead>'
        html += '<tr><th>#</th><th>Cuenta</th><th>Razón Social</th><th>Documento</th><th>Correo</th><th>Dirección</th><th>Plazo de pago</th><th>Ciudad</th></tr></thead>';
        $.ajax({
            url: 'clients/' + d.id + "/getBranch",
            method: "GET",
            dataType: 'JSON',
            async: false,
            success: function (data) {
                html += "<tbody>";
                $.each(data.response, function (i, val) {

                    html += "<tr>";
                    html += "<td>" + val.id + "</td>";
                    html += "<td>" + val.business + "</td>";
                    html += "<td>" + val.business_name + "</td>";
                    html += "<td>" + val.document + "</td>";
                    html += "<td>" + val.email + "</td>";
                    html += "<td>" + val.address + "</td>";
                    html += "<td>" + val.term + "</td>";
                    html += "<td>" + val.city + "</td>";
                    html += "</tr>";
                });
                html += "</tbody></table><br>";
            }
        })
        return html;
    }

    this.showModalSpecial = function (id) {
        $.ajax({
            url: 'clients/' + id + '/getSpecialId',
            method: 'get',
            dataType: 'JSON',
            success: function (data) {
                $(".input-special").setFields({data: data.response})
            }
        })
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
                {data: "client"},
                {data: "product"},
                {data: "reference"},
                {data: "item"},
                {data: "packaging"},
                {data: "price_sf"},
                {data: "margin"},
                {data: "margin_sf"},
                {data: "tax"},
            ],
            order: [[1, 'ASC']],
            aoColumnDefs: [
                {
                    aTargets: [0, 1, 2, 3, 4],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.showModalSpecial(' + full.id + ')">' + data + '</a>';
                    }
                }
                ,
                {
                    targets: [10],
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


    this.tableInvoice = function (id) {
        var html = '';
        table = $('#tblInvoice').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/briefcase/getInvoices/" + id,
                method: 'GET',
            },
            columns: [

                {data: "consecutive"},
                {data: "invoice"},
                {data: "created_at"},
                {data: "client"},
                {data: "responsible"},
                {data: "city"},
                {data: "dias_vencidos"},
                {data: "paid_out", render: function (data, type, row) {
                        var msg = '';
                        if (row.paid_out == null || row.paid_out == false) {
                            if (row.dias_vencidos < 0) {
                                msg = 'En mora';
                            } else {
                                msg = 'No Pago'
                            }
                        } else {
                            msg = 'Pago'
                        }
                        return msg;
                    }
                },
            ],
            order: [[7, 'DESC']],
            aoColumnDefs: [
                {
                    aTargets: [1, 2, 3, 4],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.showModal(' + full.id + ')">' + data + '</a>';
                    }
                },
                {
                    targets: [8],
                    searchable: false,
                    mData: null,
                    mRender: function (data, type, full) {
                        html = '<img src="assets/images/pdf_23.png" style="cursor:pointer" onclick="obj.viewPdf(' + data.id + ')">';
                        return html;
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
            createdRow: function (row, data, index) {

                if (data.dias_vencidos >= 0 && data.dias_vencidos <= 3) {
                    $('td', row).eq(7).addClass('color-green');
                } else if (data.dias_vencidos < 0) {
                    $('td', row).eq(7).addClass('color-red');
                } else if (data.status_id == 3) {
                    $('td', row).eq(7).addClass('color-checked');
                }
            }
        });
        return table;
    }
}

var obj = new Client();
obj.init();
