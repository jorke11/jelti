function formatRepo(data) {
    return data.text;
}

function formatRepoSelection(data) {
    return data.text;
}

jQuery.fn.getSeeker = function (param) {
    param = param || {};
    this.each(function () {
        var elem = $(this);

        if (typeof param.api === 'undefined') {
            param.api = elem.data("api");
        }


        if (typeof param.default !== 'undefined') {
            if (param.default == true) {
                var obj = {};
                obj.id = param.default;
                $.ajax({
                    url: param.api + "?q=0",
                    type: 'GET',
                    data: obj,
                    async: false,
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.items.length > 0) {
                            elem.append('<option value=' + data.items[0].id + '>' + data.items[0].text + '</option>');
                            elem.select2({'data': [{'id': data.items[0].id, 'text': data.items[0].text}]});
                            elem.val(data.items[0].id).trigger('change');
                        }
                    }
                })
            }
        }

        if (typeof param.disabled !== 'undefined') {
            if (param.default == true) {
                elem.prop("disabled", true);
            } else {
                elem.prop("disabled", false);
            }
        }
        var multiple = false;
        if (elem.attr("multiple") != undefined) {
            multiple = true;
        }

        if (elem.data("api") != undefined) {
            elem.select2({
                placeholder: "Select",
                multiple: multiple,
                ajax: {
                    url: elem.data("api"),
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page,
                            filter: param.filter
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.items,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    }
                },
                escapeMarkup: function (markup) {
                    return markup;
                }, // let our custom formatter work
                minimumInputLength: 1,
                templateResult: formatRepo, // omitted for brevity, see the source of this page
                templateSelection: formatRepoSelection, // omitted for brevity, see the source of this page

            });
        }

    })
}


jQuery.fn.setFields = function (param) {
    param = param || {};
    this.each(function () {
        var elem = $(this);

        if (typeof param.disabled === "undefined") {
            param.disabled = false;
        }
        $.each(param.data, function (i, val) {
            if (elem.attr("id") == i) {

                $("#error_" + elem.attr("id")).remove();
                elem.parent().parent().removeClass("has-error");

                if (elem.data("api") != undefined) {
                    var obj = {};
                    obj.id = val;
                    $.ajax({
                        url: elem.data("api"),
                        type: 'GET',
                        data: obj,
                        async: false,
                        dataType: 'JSON',
                        success: function (data) {
                            if (data.items.length > 0) {
                                var sel = [];
                                elem.empty();
                                $.each(data.items, function (i, val) {
                                    elem.append('<option value=' + val.id + '>' + val.text + '</option>');
                                    elem.select2({'data': [{'id': val.id, 'text': val.text}]});
                                    sel.push(val.id);
                                });

                                elem.val(sel).trigger('change');
                            }
                        }
                    })
                    elem.getSeeker(elem.data("api"));
                } else {
                    if (elem.attr('type') == 'checkbox') {
                        (val == 1) ? elem.prop('checked', true) : elem.prop('checked', false);
                    } else if (elem.get(0).tagName == 'IMG') {
                        elem.attr("src", BASE_URL + val);
                    } else if (elem.attr("type") == 'file') {
                        elem.attr("disabled", true);
                    } else if (elem.attr('type') == 'radio') {
                        if (val == elem.val()) {
                            elem.prop('checked', true);
                        }
                    } else if (elem.get(0).tagName == 'DD') {
                        elem.html(val);
                    } else if (elem.get(0).tagName == 'SELECT') {
                        if (val != null) {
                            elem.val(val).trigger('change');
                        } else {
                            elem.val(0);

                        }
                    } else {
                        elem.val(val);
                    }
                }
            }
        })

        elem.attr("disabled", param.disabled);

    });
}


jQuery.fn.cleanFields = function (param) {
    param = param || {};
    if (typeof param.disabled == 'undefined') {
        param.disabled = false;
    }
    this.each(function () {
        var elem = $(this);
        elem.removeClass("ok").removeClass("error");
        elem.removeClass("error2");

        if (elem.get(0).tagName == 'INPUT') {
            if (elem.attr("type") == 'datetime') {
                elem.currentDate();
            } else {
                elem.val('');
            }
        }

        if (elem.get(0).tagName == 'SELECT') {
            if (typeof elem.data("api") !== 'undefined') {
                elem.val(0);
                elem.getSeeker({api: elem.data("api")});
            } else {
//                elem.val(0).select2();
                elem.val(0);
            }
        }

        if (elem.get(0).tagName == 'TEXTAREA' || elem.attr("type") == 'hidden') {
            elem.val('');
        }

        if (elem.attr("type") == 'checkbox' || elem.attr("type") == 'radio') {
            elem.attr("checked", false);
        }

        if (elem.attr('tipo') == 'numero') {
            elem.val('0');
        }

        elem.attr("disabled", param.disabled)
    });
}


jQuery.fn.currentDate = function (min, format) {
    var day;
    this.each(function () {
        min = min || false;
        format = format || false;
        var elem = $(this), d = new Date(), fecha = '', mes = d.getMonth() + 1, minutos = 0;
        minutos = (d.getMinutes() <= 9) ? '0' + d.getMinutes() : d.getMinutes();
        mes = (mes <= 9) ? '0' + mes : mes;
        if (format == false) {
            day = d.getDate();
            day = (day <= 9) ? '0' + day : day;
            fecha = d.getFullYear() + "-" + mes + "-" + day;
            fecha += (min == false) ? " " + d.getHours() + ':' + minutos : '';
        } else {
            fecha = d.getDate() + "-" + mes + "-" + d.getFullYear();
            fecha += (min == false) ? " " + d.getHours() + ':' + minutos : '';
        }

        elem.val(fecha);
    })
    return this;
}

jQuery.fn.validate = function (param) {
    param = param || {};
    var arrData = []
    this.each(function () {
        var elem = $(this);
        if (elem.attr("required") != undefined) {
            $("#error_" + elem.attr("id")).remove();
            elem.getSeeker();
            if (elem.data("api") == undefined) {
                if (elem.val() == '') {
                    elem.after('<small class="help-block" id="error_' + elem.attr("id") + '" data-fv-validator="notEmpty" data-fv-for="firstName" data-fv-result="INVALID" style="">' + elem.attr("id") + ' is Required</small>')
                    elem.parent().parent().addClass("has-error")
                    arrData.push({id: elem.attr("id"), value: elem.val(), element: elem.get(0).tagName});
                } else {

                    if (elem.data("type") != undefined) {

                        $("#error_" + elem.attr("id")).remove();
                        if (elem.data("type") == 'number' && isNaN(elem.val())) {
                            elem.after('<small class="help-block" id="error_' + elem.attr("id") + '" data-fv-validator="notEmpty" data-fv-for="firstName" data-fv-result="INVALID" style="">' + elem.attr("id") + ' is not Numeric</small>')
                            elem.parent().parent().addClass("has-error")
                            arrData.push({id: elem.attr("id"), value: elem.val(), element: elem.get(0).tagName});
                        } else {
                            elem.parent().parent().removeClass("has-error")
                        }
                    } else {
                        $("#error_" + elem.attr("id")).remove();
                        if (elem.val() != null && elem.val() != 0) {
                            elem.parent().parent().removeClass("has-error")
                        } else {
                            elem.after('<small class="help-block" id="error_' + elem.attr("id") + '" data-fv-validator="notEmpty" data-fv-for="firstName" data-fv-result="INVALID" style="">' + elem.attr("id") + ' is Required</small>')
                            elem.parent().parent().addClass("has-error")
                            arrData.push({id: elem.attr("id"), value: elem.val(), element: elem.get(0).tagName});

                        }
                    }
                }
            } else {
                var cont = elem.next("span").children().children();
                if (elem.val() == null) {
                    cont.addClass("error");
                    arrData.push({id: elem.attr("id"), value: elem.val(), element: elem.get(0).tagName});
                } else {
                    cont.removeClass("error");
                }
            }
        }
    })
    return arrData;
}


jQuery.fn.capital = function (str) {
    return str.replace(/^(.)|\s(.)/g, function ($1) {
        return $1.toUpperCase();
    });
}
jQuery.fn.getData = function () {
    var resp = '', id;

    this.each(function () {
        var elem = $(this);
        if (elem.attr("name") != '' && elem.attr("name") != undefined) {
            if (elem.val() != 0 && elem.val() != '') {
                id = elem.attr("id");
                resp += (resp == '') ? '' : ',';
                resp += '"' + id + '":"' + elem.val() + '"';
            }
        }

    })

    resp = '{' + resp + '}';

    return JSON.parse(resp);
}