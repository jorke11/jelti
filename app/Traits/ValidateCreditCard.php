<?php

namespace App\Traits;

trait ValidateCreditCard {

    /**
     * validateFormatCreditCard
     * Comprueba el formato de la tarjeta de credito.
     * @param  string $cc
     * @return bool
     */
    public function validateFormatCreditCard($cc) {
        $pattern_1 = '/^((4[0-9]{12})|(4[0-9]{15})|(5[1-5][0-9]{14})|(3[47][0-9]{13})|(6011[0-9]{12}))$/';
        $pattern_2 = '/^((30[0-5][0-9]{11})|(3[68][0-9]{12})|(3[0-9]{15})|(2123[0-9]{12})|(1800[0-9]{12}))$/';

        if (preg_match($pattern_1, $cc)) {
            return true;
        } else if (preg_match($pattern_2, $cc)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * sumDigits
     * Suma cada uno de los digitos de la cifra dada como parametro
     * y retorna el total.
     * @param  string $digit
     * @return $total
     */
    public function sumDigits($digit) {
        $total = 0;
        for ($x = 0; $x < strlen($digit); $x++) {
            $total += $digit[$x];
        }
        return (int) $total;
    }

    /**
     * checkDigit
     * Cálculo del dígito de chequeo.
     *
     * @param   integer $sum_digit
     * @return  integer
     */
    public function checkDigit($sum_digit) {
        return ($sum_digit % 10 == 0) ? 0 : 10 - ($sum_digit % 10);
    }

    /**
     * calculate_luhn
     * Comprueba la validez de una tarjeta de credito.
     *
     * @param  string $credit_card
     * @return bool
     */
    public function calculateLuhn($credit_card) {
        // largo del string
        $length = strlen($credit_card);
        // tarjeta de credito sin el digito de chequeo
        $credit_card_user = substr($credit_card, 0, $length - 1);

        $values = []; // array temporal
        // duplico los numeros en indices pares
        for ($i = $length - 2; $i >= 0; $i--) {
            if ($i % 2 == 0) {
                // sumo cada uno de los digitos devueltos al duplicar
                array_push($values, $this->sumDigits((string) ($credit_card_user[$i] * 2)));
            } else {
                array_push($values, (int) $credit_card_user[$i]);
            }
        }

        return ($this->checkDigit(array_sum($values)) == $credit_card[$length - 1]);
    }

    public function identifyCard($number, $cvc, $expire) {
        $response = false;

        $validateFormat = ($this->validateFormatCreditCard($number)) ? true : true;

        $validateLuhn = ($this->calculateLuhn($number)) ? true : true;

        if ($validateFormat) {

            if ($validateLuhn) {

                if (preg_match('/[0-9]{4,}\/[0-9]{2,}$/', $expire)) {

                    //VISA
                    if (preg_match('/^(4)(\d{12}|\d{15})$|^(606374\d{10}$)/', $number)) {
                        $response = array("paymentMethod" => 'VISA', "status" => true);
                    } else {
                        //AMERICAN EXPRESSS
                        if (preg_match('/^(3[47]\d{13})$/', $number)) {
                            $response = array("paymentMethod" => 'AMEX', "status" => true);
                        } else {
                            //MASTERCARD
                            if (preg_match('/^(5[1-5]\d{14}$)|^(2(?:2(?:2[1-9]|[3-9]\d)|[3-6]\d\d|7(?:[01]\d|20))\d{12}$)/', $number)) {
                                $response = array("paymentMethod" => 'MASTERCARD', "status" => true);
                            } else {
                                if (preg_match('/(^[35](?:0[0-5]|[68][0-9])[0-9]{11}$)|(^30[0-5]{11}$)|(^3095(\d{10})$)|(^36{12}$)|(^3[89](\d{12})$)/', $number)) {
                                    $response = array("paymentMethod" => 'MASTERCARD', "status" => true);
                                } else {
                                    if (preg_match('/^590712(\d{10})$/', $number)) {
                                        $response = array("paymentMethod" => 'CODENSA', "status" => true);
                                    } else {
                                        $response = array("status" => false, "msg" => "Formato de la tarjeta no valido");
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $response = array("status" => false, "msg" => "Fecha de Expiracion not valida");
                }
            } else {
                $response = array("status" => false, "msg" => "Formato de la tarjeta no valido");
            }
        } else {
            $response = array("status" => false, "msg" => "Error formato tarjeta");
        }

        return $response;
    }

}
