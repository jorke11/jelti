<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use App\Models\Inventory\Departures;
use App\models\Administration\Consecutives;
use App\Models\Inventory\Entries;
use App\Models\Inventory\EntriesDetail;
use App\Models\Administration\Products;
use App\Models\Administration\Warehouses;
use DB;

class ToolController extends Controller {

    private $UNIDADES = array(
        '',
        'UN ',
        'DOS ',
        'TRES ',
        'CUATRO ',
        'CINCO ',
        'SEIS ',
        'SIETE ',
        'OCHO ',
        'NUEVE ',
        'DIEZ ',
        'ONCE ',
        'DOCE ',
        'TRECE ',
        'CATORCE ',
        'QUINCE ',
        'DIECISEIS ',
        'DIECISIETE ',
        'DIECIOCHO ',
        'DIECINUEVE ',
        'VEINTE '
    );
    private $DECENAS = array(
        'VENTI',
        'TREINTA ',
        'CUARENTA ',
        'CINCUENTA ',
        'SESENTA ',
        'SETENTA ',
        'OCHENTA ',
        'NOVENTA ',
        'CIEN '
    );
    private $CENTENAS = array(
        'CIENTO ',
        'DOSCIENTOS ',
        'TRESCIENTOS ',
        'CUATROCIENTOS ',
        'QUINIENTOS ',
        'SEISCIENTOS ',
        'SETECIENTOS ',
        'OCHOCIENTOS ',
        'NOVECIENTOS '
    );
    private $MONEDAS = array(
        array('country' => 'Colombia', 'currency' => 'COP', 'singular' => 'PESO COLOMBIANO', 'plural' => 'PESOS COLOMBIANOS', 'symbol', '$'),
        array('country' => 'Estados Unidos', 'currency' => 'USD', 'singular' => 'DÓLAR', 'plural' => 'DÓLARES', 'symbol', 'US$'),
        array('country' => 'Europa', 'currency' => 'EUR', 'singular' => 'EURO', 'plural' => 'EUROS', 'symbol', '€'),
        array('country' => 'México', 'currency' => 'MXN', 'singular' => 'PESO MEXICANO', 'plural' => 'PESOS MEXICANOS', 'symbol', '$'),
        array('country' => 'Perú', 'currency' => 'PEN', 'singular' => 'NUEVO SOL', 'plural' => 'NUEVOS SOLES', 'symbol', 'S/'),
        array('country' => 'Reino Unido', 'currency' => 'GBP', 'singular' => 'LIBRA', 'plural' => 'LIBRAS', 'symbol', '£'),
        array('country' => 'Argentina', 'currency' => 'ARS', 'singular' => 'PESO', 'plural' => 'PESOS', 'symbol', '$')
    );
    private $separator = '.';
    private $decimal_mark = ',';
    private $glue = ' CON ';

    public function index() {
        $this->readFile();
    }

    public function readFile() {

        $list = shell_exec('find  ' . public_path() . '/images/resize/ -name "*.png"');
        $list = explode("\n", $list);



        foreach ($list as $value) {
            if (is_file($value)) {
                $manager = new ImageManager(array('driver' => 'imagick'));

// to finally create image instances
                $image = $manager->make($value)->resize(300, 200);
            }
        }
    }

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

    /**
     * Evalua si el número contiene separadores o decimales
     * formatea y ejecuta la función conversora
     * @param $number número a convertir
     * @param $miMoneda clave de la moneda
     * @return string completo
     */
    public function to_word($number, $miMoneda = null) {
        if (strpos($number, $this->decimal_mark) === FALSE) {
            $convertedNumber = array(
                $this->convertNumber($number, $miMoneda, 'entero')
            );
        } else {
            $number = explode($this->decimal_mark, str_replace($this->separator, '', trim($number)));
            $convertedNumber = array(
                $this->convertNumber($number[0], $miMoneda, 'entero'),
                $this->convertNumber($number[1], $miMoneda, 'decimal'),
            );
        }
        return implode($this->glue, array_filter($convertedNumber));
    }

    /**
     * Convierte número a letras
     * @param $number
     * @param $miMoneda
     * @param $type tipo de dígito (entero/decimal)
     * @return $converted string convertido
     */
    private function convertNumber($number, $miMoneda = null, $type) {

        $converted = '';
        if ($miMoneda !== null) {
            try {

                $moneda = array_filter($this->MONEDAS, function($m) use ($miMoneda) {
                    return ($m['currency'] == $miMoneda);
                });
                $moneda = array_values($moneda);
                if (count($moneda) <= 0) {
                    throw new Exception("Tipo de moneda inválido");
                    return;
                }
                ($number < 2 ? $moneda = $moneda[0]['singular'] : $moneda = $moneda[0]['plural']);
            } catch (Exception $e) {
                echo $e->getMessage();
                return;
            }
        } else {
            $moneda = '';
        }
        if (($number < 0) || ($number > 999999999)) {
            return false;
        }
        $numberStr = (string) $number;
        $numberStrFill = str_pad($numberStr, 9, '0', STR_PAD_LEFT);
        $millones = substr($numberStrFill, 0, 3);
        $miles = substr($numberStrFill, 3, 3);
        $cientos = substr($numberStrFill, 6);
        if (intval($millones) > 0) {
            if ($millones == '001') {
                $converted .= 'UN MILLON ';
            } else if (intval($millones) > 0) {
                $converted .= sprintf('%sMILLONES ', $this->convertGroup($millones));
            }
        }

        if (intval($miles) > 0) {
            if ($miles == '001') {
                $converted .= 'MIL ';
            } else if (intval($miles) > 0) {
                $converted .= sprintf('%sMIL ', $this->convertGroup($miles));
            }
        }
        if (intval($cientos) > 0) {
            if ($cientos == '001') {
                $converted .= 'UN ';
            } else if (intval($cientos) > 0) {
                $converted .= sprintf('%s ', $this->convertGroup($cientos));
            }
        }
        $converted .= $moneda;
        return $converted;
    }

    /**
     * Define el tipo de representación decimal (centenas/millares/millones)
     * @param $n
     * @return $output
     */
    private function convertGroup($n) {
        $output = '';
        if ($n == '100') {
            $output = "CIEN ";
        } else if ($n[0] !== '0') {
            $output = $this->CENTENAS[$n[0] - 1];
        }
        $k = intval(substr($n, 1));
        if ($k <= 20) {
            $output .= $this->UNIDADES[$k];
        } else {
            if (($k > 30) && ($n[2] !== '0')) {
                $output .= sprintf('%sY %s', $this->DECENAS[intval($n[1]) - 2], $this->UNIDADES[intval($n[2])]);
            } else {
                $output .= sprintf('%s%s', $this->DECENAS[intval($n[1]) - 2], $this->UNIDADES[intval($n[2])]);
            }
        }
        return $output;
    }

    public function getProduct($warehouse_id, $reference) {

        $sql = "
            select 
                p.id,
                p.reference,
                p.title as product,
                (
                    select coalesce(sum(quantity),0) 
                    from entries_detail
                    JOIN entries ON entries.id=entries_detail.entry_id
                    WHERE entries.status_id=2 and entries_detail.product_id=p.id 
                    and entries.warehouse_id=$warehouse_id
                ) entradas,
                (
                    select coalesce(sum(quantity),0) 
                    from sales_detail
                    JOIN sales ON sales.id=sales_detail.sale_id
                    WHERE sales_detail.product_id is not null and sales_detail.product_id=p.id
                    and sales.warehouse_id=$warehouse_id
                ) salidas,
                (
                    select coalesce(sum(quantity),0) 
                    from entries_detail
                    JOIN entries ON entries.id=entries_detail.entry_id
                    WHERE entries.status_id=2 and entries_detail.product_id=p.id
                    and entries.warehouse_id=$warehouse_id
                ) - (
                    select coalesce(sum(quantity),0) 
                    from sales_detail
                    JOIN sales ON sales.id=sales_detail.sale_id
                    WHERE sales_detail.product_id is not null and sales_detail.product_id=p.id
                    and sales.warehouse_id=$warehouse_id
                ) Total
            from products p
            where p.reference=$reference
            order by p.title asc";
        $res = DB::select($sql);
        $res = $res[0];
        dd($res);
    }

    public function addInventory($warehouse_id, $reference, $quantity) {

        $sql = "
            select 
                p.id,
                p.reference,
                p.title as product,
                (
                    select coalesce(sum(quantity),0) 
                    from entries_detail
                    JOIN entries ON entries.id=entries_detail.entry_id
                    WHERE entries.status_id=2 and entries_detail.product_id=p.id 
                    and entries.warehouse_id=$warehouse_id
                ) entradas,
                (
                    select coalesce(sum(quantity),0) 
                    from sales_detail
                    JOIN sales ON sales.id=sales_detail.sale_id
                    WHERE sales_detail.product_id is not null and sales_detail.product_id=p.id
                    and sales.warehouse_id=$warehouse_id
                ) salidas,
                (
                    select coalesce(sum(quantity),0) 
                    from entries_detail
                    JOIN entries ON entries.id=entries_detail.entry_id
                    WHERE entries.status_id=2 and entries_detail.product_id=p.id
                    and entries.warehouse_id=$warehouse_id
                ) - (
                    select coalesce(sum(quantity),0) 
                    from sales_detail
                    JOIN sales ON sales.id=sales_detail.sale_id
                    WHERE sales_detail.product_id is not null and sales_detail.product_id=p.id
                    and sales.warehouse_id=$warehouse_id
                ) Total
            from products p
            where p.reference=$reference
            order by p.title asc";
        $res = DB::select($sql);
        $res = $res[0];


        $pro = Products::where("reference", $reference)->first();

        $w = Warehouses::find($warehouse_id);

        $en["warehouse_id"] = $warehouse_id;
        $en["responsible_id"] = $w->responsible_id;
        $en["supplier_id"] = $pro->supplier_id;
        $en["purchase_id"] = 0;
        $en["city_id"] = $w->city_id;
        $en["description"] = "initial inventory";
        $en["invoice"] = "system";
        $en["status_id"] = 2;
        $en["created"] = date("Y-m-d H:i:s");

        $total = ($res->total < 0 ) ? $res->total * -1 : $res->total;

        if ($res->total < 0) {
            $quantity = $quantity + ($res->total * -1);
        } else {
            $quantity = $quantity - $res->total;
        }

        $entry_id = Entries::create($en)->id;
        echo "entry:" . $entry_id;


        $det["entry_id"] = $entry_id;
        $det["product_id"] = $pro->id;
        $det["quantity"] = $quantity;
        $det["real_quantity"] = $quantity;
        $det["value"] = $pro->price_sf;
        $det["lot"] = "system";
        $det["description"] = "system";
        $det["status_id"] = 3;
        $det["created_at"] = date("Y-m-d H:i:s");

        $detail_id = EntriesDetail::create($det)->id;
        echo " detail:" . $detail_id;
    }

}
