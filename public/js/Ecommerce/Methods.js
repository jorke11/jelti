function MethodsPayment() {
    this.init = function () {

        $('.input-number').on('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        $('.input-alpha').on('input', function () {
            this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
        });

        $('.input-date').on('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        $("#number").blur(this.validateTarjet);

        $("#checkpayer").click(function () {
            if ($(this).is(":checked")) {
                $("#divaddpayer").addClass("hide");
            } else {
                $("#divaddpayer").removeClass("hide");
            }
        })

        $("#frm").submit(function () {

            var validate = $(".input-extern").validate();
            if (validate.length > 0) {
                toastr.error("Datos pendientes");
                return false;
            }


        })

    }

    this.validateTarjet = function () {

        var amex = /^(3[47]\d{13})$/
        if (amex.test(this.value)) {
            $("#crc").attr("maxlength", 4).val("");
            $("#imgCard").attr("src", PATH + "/images/amex.jpg");
        } else {
            $("#crc").attr("maxlength", 3).val("");
            $("#imgCard").attr("src", PATH + "/images/visa.png");
        }


//        if (preg_match('/[0-9]{4,}\/[0-9]{2,}$/', $expire)) {
//
//                    //VISA
//                    if (preg_match('/^(4)(\d{12}|\d{15})$|^(606374\d{10}$)/', $number)) {
//                        $response = array("paymentMethod" => 'VISA', "status" => true);
//                    } else {
//                        //AMERICAN EXPRESSS
//                        if (preg_match('/^(3[47]\d{13})$/', $number)) {
//                            $response = array("paymentMethod" => 'AMEX', "status" => true);
//                        } else {
//                            //MASTERCARD
//                            if (preg_match('/^(5[1-5]\d{14}$)|^(2(?:2(?:2[1-9]|[3-9]\d)|[3-6]\d\d|7(?:[01]\d|20))\d{12}$)/', $number)) {
//                                $response = array("paymentMethod" => 'MASTERCARD', "status" => true);
//                            } else {
//                                if (preg_match('/(^[35](?:0[0-5]|[68][0-9])[0-9]{11}$)|(^30[0-5]{11}$)|(^3095(\d{10})$)|(^36{12}$)|(^3[89](\d{12})$)/', $number)) {
//                                    $response = array("paymentMethod" => 'DINERS', "status" => true);
//                                } else {
//                                    if (preg_match('/^590712(\d{10})$/', $number)) {
//                                        $response = array("paymentMethod" => 'CODENSA', "status" => true);
//                                    } else {
//                                        $response = array("status" => false, "msg" => "Formato de la tarjeta no valido");
//                                    }
//                                }
//                            }
//                        }
//                    }
//                } else {
//                    $response = array("status" => false, "msg" => "Fecha de Expiracion not valida");
//                }

    }


    this.payu = function () {
        var form = $("#frm").serialize();
        $.ajax({
            url: PATH + '/payment/target',
            data: form,
            method: "post",
            success: function () {

            }


        })

    }

    this.deleteItem = function (product_id, order_id) {
        var obj = {};
        obj.product_id = product_id;
        $.ajax({
            url: 'deleteDetail/' + order_id,
            method: 'DELETE',
            data: obj,
            dataType: 'JSON',
            success: function (data) {
                obj.getDetail();
            }
        })
    }
}

var obj = new MethodsPayment();
obj.init();
