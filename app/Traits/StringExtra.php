<?php

namespace App\Traits;

use DB;

trait StringExtra {

      function cleanText($string) {
        $string = trim($string);
//        $string = utf8_encode((filter_var($string, FILTER_SANITIZE_STRING)));
        $string = str_replace(
                array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä', 'Ã'), array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A', 'A'), $string
        );
        $string = str_replace(
                array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'), array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'), $string
        );
        $string = str_replace(
                array('í', 'ì', 'ï', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'), array('i', 'i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'), $string
        );
        $string = str_replace(
                array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'), array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'), $string
        );
        $string = str_replace(
                array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'), array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'), $string
        );
        $string = str_replace(
                array('ñ', 'Ñ', 'ç', 'Ç'), array('n', 'N', 'c', 'C'), $string
        );
        $string = str_replace(
                array("\\", "¨", "º", "–", "~", "|", "·",
            "¡", "[", "^", "`", "]", "¨", "´", "¿",
            '§', '¤', '¥', 'Ð', 'Þ'), '', $string
        );
        $string = str_replace(
                array(";",), array(","), $string
        );
        $string = str_replace(
                array("&#39;", "&#39,", '&#34;', '&#34,'), array("'", "'", '"', '"'), $string
        );
        $string = htmlentities($string, ENT_QUOTES | ENT_IGNORE, 'UTF-8');

        $string = str_replace(
                array('&quot;', '&#39;', '&#039;'), array('"', "'", "'"), $string
        );
        $string = str_replace(
                array('&amp;', '&nbsp;'), array('&', ' '), $string
        );
        $string = str_replace(
                array('&deg;', '&sup3;', '&shy;'), array(''), $string
        );
        $string = str_replace(
                array('&copy;', '&sup3;', '&shy;', '&plusmn;'), array('e', 'o', 'i', 'n'), $string
        );
        return $string;
    }
}
