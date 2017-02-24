function formatRepo(data) {
    return data.description;
}

function formatRepoSelection(data) {
    if (data.text == '')
        data.text = data.description
    
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
                            elem.append('<option value=' + data.items[0].id + '>' + data.items[0].description + '</option>');
                            elem.select2({'data': [{'id': data.items[0].id, 'text': data.items[0].description}]});
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
       
        if (elem.data("api") != undefined) {
            elem.select2({
                placeholder: "Select",
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
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
                        params.page = params.page || 1;

                        return {
                            results: data.items,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    },

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
                                elem.append('<option value=' + data.items[0].id + '>' + data.items[0].description + '</option>');
                                elem.select2({'data': [{'id': data.items[0].id, 'text': data.items[0].text}]});
                                elem.val(data.items[0].id).trigger('change');   
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
            elem.val('')
        }

        if (elem.get(0).tagName == 'SELECT') {
            if (typeof elem.data("api") !== 'undefined') {
                elem.val(0);
                elem.getSeeker({api: elem.data("api")});
            } else {
                elem.val(0).select2();
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
    this.each(function () {
        min = min || false;
        format = format || false;
        var elem = $(this), d = new Date(), fecha = '', mes = d.getMonth() + 1, minutos = 0;
        minutos = (d.getMinutes() <= 9) ? '0' + d.getMinutes() : d.getMinutes();
        mes = (mes <= 9) ? '0' + mes : mes;
        if (format == false) {
            fecha = d.getFullYear() + "-" + mes + "-" + d.getDate();
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

        if (elem.attr('disabled') != 'disabled') {

            if (elem.attr("required")) {
                if (elem.hasClass("Seeker")) {
                    var sel = elem.next("span")
                            .children('.selection')
                            .find('span.select2-selection--single');
                    if (elem.val() == "0" || elem.val() == null || elem.val() == "-1") {
                        arrData.push({id: elem.attr("id"), value: elem.val(), element: elem.get(0).tagName});
                        sel.css({'border': '1px solid red'});
                    } else {
                        sel.css({'border': '1px solid #aaaaaa'});
                    }
                } else {

                    if (elem.data("type") != 'undefined') {
                        if (elem.data("type") == 'number') {
                            if (isNaN(elem.val())) {
                                elem.addClass("error");
                                arrData.push({id: elem.attr("id"), value: elem.val(), element: elem.get(0).tagName});
                            } else {
                                elem.removeClass("error");
                            }
                        } else if (elem.data("type") == 'address') {
                            if (elem.val() == '') {
                                arrData.push({id: elem.attr("id"), value: elem.val(), element: elem.get(0).tagName});
                                elem.addClass("error");
                            } else {
                                elem.removeClass("error");
                            }
                        } else {
                            var sel = elem.next("span")
                                    .children('.selection')
                                    .find('span.select2-selection--single');


                            if (elem.get(0).tagName == 'SELECT') {
                                if (elem.val() == '0') {
                                    arrData.push({id: elem.attr("id"), value: elem.val(), element: elem.get(0).tagName});

                                    sel.css({'border': '1px solid red'});
                                } else {
                                    sel.css({'border': '1px solid #aaaaaa'});
                                }
                            } else if (elem.get(0).tagName == 'INPUT') {
                                if (elem.val() == '') {
                                    arrData.push({id: elem.attr("id"), value: elem.val(), element: elem.get(0).tagName});
                                    elem.addClass("error");
                                } else {
                                    elem.removeClass("error");
                                }
                            }

                        }
                    }
                }
            }

        }
    })
    return arrData;
}


$.capital = function (str) {
    return str.replace(/^(.)|\s(.)/g, function ($1) {
        return $1.toUpperCase();
    });
}