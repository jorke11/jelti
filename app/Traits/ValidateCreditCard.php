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
                    if (strlen($number) == 16 && strlen($cvc) == 3) {
//                if (preg_match('/^4[0-9]{6,}$/', $number)) {
                        if (preg_match('/^(4)(\\d{12}|\\d{15})$|^(606374\\d{10}$)/', $number)) {
                            $response = array("paymentMethod" => 'VISA', "status" => true);
                        }
                    }

//Dinnesrs

                    if (strlen($number) == 14 && strlen($cvc) == 4) {
                        if (preg_match('/^(3(?:0[0-5]|[68][0-9])[0-9]{11})*$/', trim($number))) {
                            $response = array("paymentMethod" => 'DINERS', "status" => true);
                        }
                    }

//Mastercard
                    if (strlen($number) == 16 && strlen($cvc) == 4) {
//                if (preg_match('/^5[1-5][0-9]{5,}|222[1-9][0-9]{3,}|22[3-9][0-9]{4,}|2[3-6][0-9]{5,}|27[01][0-9]{4,}|2720[0-9]{3,}$/', trim($number))) {
                        if (preg_match('/^(5[1-5]\\d{14}$)|^(2(?:2(?:2[1-9]|[3-9]\\d)|[3-6]\\d\\dd|7(?:[01]\\d|20))\\d{12}$)/', trim($number))) {
                            $response = array("paymentMethod" => 'MASTERCARD', "status" => true);
                        }
                    }

                    /**
                     * Longitud 15
                     */
//American express
                    if (strlen($number) == 15 && strlen($cvc) == 4) {

//                if (preg_match('/^3[47][0-9]{5,}$/', $number)) {
                        if (preg_match('/^3[47]\\d{13}$/', $number)) {
                            $response = array("paymentMethod" => 'AMEX', "status" => true);
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
