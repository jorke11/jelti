<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use App\Models\Inventory\Departures;
use App\models\Administration\Consecutives;
use App\Models\Inventory\Entries;
use App\Models\Inventory\EntriesDetail;
use App\Models\Administration\Products;
use App\Models\Administration\Categories;
use App\Models\Administration\Characteristic;
use App\Models\Administration\ProductsImage;
use App\Models\Administration\Warehouses;
use DB;
use App\Models\Invoicing\SaleDetail;
use File;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Inventory\Inventory;
use App\Models\Inventory\InventoryLog;
use App\Models\Inventory\InventoryHold;
use Auth;

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

    public function fixedInvoice() {

        $sql = "select d.*,dep.invoice 
           from departures_detail d
           JOIN departures dep ON dep.id=d.departure_id and dispatched between '2017-08-01 00:00' and '2017-08-30 23:59' 
           where d.real_quantity =0";
        $data = DB::select($sql);
        foreach ($data as $val) {

            $sql = "select * from sales_detail where sale_id=(select id from sales where invoice='" . $val->invoice . "')";
            $d = DB::select($sql);

            foreach ($d as $value) {

                $sql = "select * from departures_detail where departure_id=(select id from departures where invoice='" . $val->invoice . "') and product_id=" . $value->product_id;
                $res = DB::select($sql);

                if (count($res) > 0) {
                    $res = $res[0];
                    $det = \App\Models\Inventory\DeparturesDetail::find($res->id);
                    echo "actual " . $det->real_quantity . " :: actualizacion: " . $value->quantity . "<br>";
                    $det->real_quantity = $value->quantity;
                    $det->save();
                }
            }
        }


        echo "termino ";
    }

    public function readImagesProducts() {
        $cmd = 'find  ' . public_path() . '/catalogo/ -name "*.png"';

        $list = shell_exec($cmd);

        $list = explode("\n", $list);


        foreach ($list as $value) {
            if (is_file($value)) {
                $manager = new ImageManager(array('driver' => 'imagick'));

                $image = $manager->make($value)->widen(700);
                if ($image->width() > 2000) {
                    $width = $image->width() - round($image->width() * 0.70);
                    $heigth = $image->height() - round($image->height() * 0.70);
                } else {
                    $width = $image->width() - round($image->width() * 0.70);
                    $heigth = $image->height() - round($image->height() * 0.70);
                }
//
//// to finally create image instances
                $imagethumb = $manager->make($value)->resize($width, $heigth);
//                echo $image->basename;
                $reference = str_replace(".png", "", $image->basename);
                $pro = Products::where("reference", $reference)->first();

                if ($pro != null) {
                    $path = public_path() . "/images/product/" . $pro->id . "/";
                    File::makeDirectory($path, $mode = 0777, true, true);
                    chmod($path, 0777);

                    $paththumb = public_path() . "/images/product/" . $pro->id . "/thumb/";
                    File::makeDirectory($paththumb, $mode = 0777, true, true);
                    chmod($paththumb, 0777);

                    $pathsys = "images/product/" . $pro->id . "/";
                    $pathsysthumb = "images/product/" . $pro->id . "/thumb/";

                    $path .= $image->basename;
                    $pathsys .= $image->basename;

                    $paththumb .= $image->basename;
                    $pathsysthumb .= $image->basename;

                    $image->save($path);
                    $imagethumb->save($paththumb);

                    $new["product_id"] = $pro->id;
                    $new["path"] = $pathsys;
                    $new["thumbnail"] = $pathsysthumb;
                    $new["main"] = true;

                    ProductsImage::create($new);
                    echo $path . "<br>";
                } else {
                    echo "Rechazado: " . $value . "<br>";
                }
            }
        }
    }

    public function updateSlug() {
        $pro = Products::all();

        foreach ($pro as $value) {
            $row = Products::find($value->id);
            $row->description = $row->description;
            $row->save();
        }
    }

    public function readImagesBanner() {

        $cmd = 'find  ' . public_path() . '/banner/ -name "*.jpg"';

        $list = shell_exec($cmd);

        $list = explode("\n", $list);

        foreach ($list as $value) {
            if (is_file($value)) {
                $manager = new ImageManager(array('driver' => 'imagick'));

                $image = $manager->make($value);


                $cod = substr($image->basename, 0, strpos($image->basename, "-"));
                $cod = explode("_", $cod);

                $pro = Categories::find($cod[1]);

                if ($pro != null) {
                    $path = public_path() . "/images/category/" . $pro->id . "/banner/";
                    File::makeDirectory($path, $mode = 0777, true, true);
                    chmod($path, 0777);

                    $pathsys = "images/category/" . $pro->id . "/banner/";

                    $path .= $image->basename;
                    $pathsys .= $image->basename;

                    $image->save($path);

                    $pro->banner = $pathsys;

                    $pro->save();
                    echo $path . "<br>";
                } else {
                    echo "Rechazado: " . $value . "<br>";
                }
            }
        }
    }

    public function readImagesCategory() {

        $cmd = 'find  ' . public_path() . '/categorias/ -name "*.jpg"';

        $list = shell_exec($cmd);
        $list = explode("\n", $list);


        foreach ($list as $value) {
            if (is_file($value)) {
                $manager = new ImageManager(array('driver' => 'imagick'));

                $image = $manager->make($value);

                $cod = substr($image->basename, 0, strpos($image->basename, "."));

                $cod = explode("_", $cod);

                $pro = Categories::find($cod[1]);

                if ($pro != null) {
                    $path = public_path() . "/images/category/" . $pro->id . "/";
                    File::makeDirectory($path, $mode = 0777, true, true);
//                    chmod($path, 0777);

                    $pathsys = "images/category/" . $pro->id . "/";

                    $path .= $image->basename;
                    $pathsys .= $image->basename;

                    $image->save($path);

                    $pro->image = $pathsys;
                    $pro->order = $cod[1];

                    $pro->save();
                    echo $path . "<br>";
                } else {
                    echo "Rechazado: " . $value . "<br>";
                }
            }
        }
    }

    public function excelCategory() {
        $cmd = 'find  ' . public_path() . '/excel/ -name "Categ*.xlsx"';

        $list = shell_exec($cmd);

        $list = explode("\n", $list);
        $list = array_filter($list);

        Excel::load($list[0], function($reader) {

            foreach ($reader->get() as $i => $book) {
                $pro = Products::where("reference", (int) $book->sf_code)->first();
                $char = array();


                if ($pro != null) {

                    if (strtoupper($book->paleo) == 'X') {
                        $cha = Characteristic::where(DB::raw("LOWER(description)"), "LIKE", '%paleo%')->first();

                        if ($cha != null) {
                            $char[] = $cha->id;
                        }
                    }
                    if (strtoupper($book->gluten_free) == 'X') {
                        $cha = Characteristic::where(DB::raw("LOWER(description)"), "LIKE", '%fluten free%')->first();

                        if ($cha != null) {
                            $char[] = $cha->id;
                        }
                    }
                    if (strtoupper($book->vegan) == 'X') {
                        $cha = Characteristic::where(DB::raw("LOWER(description)"), "LIKE", '%vegano%')->first();

                        if ($cha != null) {
                            $char[] = $cha->id;
                        }
                    }
                    if (strtoupper($book->non_gmo) == 'X') {
                        $cha = Characteristic::where(DB::raw("LOWER(description)"), "LIKE", '%no gmo%')->first();

                        if ($cha != null) {
                            $char[] = $cha->id;
                        }
                    }
                    if (strtoupper($book->organico) == 'X') {
                        $cha = Characteristic::where(DB::raw("LOWER(description)"), "LIKE", '%organico%')->first();

                        if ($cha != null) {
                            $char[] = $cha->id;
                        }
                    }
                    if (strtoupper($book->sin_grasas_trans) == 'X') {
                        $cha = Characteristic::where(DB::raw("LOWER(description)"), "LIKE", '%sin grasas trans%')->first();

                        if ($cha != null) {
                            $char[] = $cha->id;
                        }
                    }
                    if (strtoupper($book->sin_azucar_anadida) == 'X') {
                        $cha = Characteristic::where(DB::raw("LOWER(description)"), "LIKE", '%sin azucar%')->first();

                        if ($cha != null) {
                            $char[] = $cha->id;
                        }
                    }

                    if (strtoupper($book->cruelty_free) == 'X') {
                        $cha = Characteristic::where(DB::raw("LOWER(description)"), "LIKE", '%cruelty free%')->first();

                        if ($cha != null) {
                            $char[] = $cha->id;
                        }
                    }

                    if (strtoupper($book->de_origen_vegetal) == 'X') {
                        $cha = Characteristic::where(DB::raw("LOWER(description)"), "LIKE", '%origen vegetal%')->first();

                        if ($cha != null) {
                            $char[] = $cha->id;
                        }
                    }

                    if (strtoupper($book->no_testado_en_animales) == 'X') {
                        $cha = Characteristic::where(DB::raw("LOWER(description)"), "LIKE", '%no testado en animales%')->first();
                        if ($cha != null) {
                            $char[] = $cha->id;
                        }
                    }

                    $pro->characteristic = json_encode($char);

                    $pro->save();
                    echo $pro->title . " " . print_r($char, true) . "<br>";
                } else {
                    echo "ingreso:<br>";
                    print_r($book);
                    echo "<br>";
                }
            }
        });
    }

    public function excelTitle() {
        $cmd = 'find  ' . public_path() . '/excel/ -name "Nombres*.xlsx"';

        $list = shell_exec($cmd);

        $list = explode("\n", $list);
        $list = array_filter($list);

        Excel::load($list[0], function($reader) {

            foreach ($reader->get() as $i => $book) {


                $pro = Products::where("reference", (int) $book->sf_code)->first();
                $char = array();
                if ($pro != null) {
                    $pro->short_description = $book->title;
                    $pro->save();
                    echo $pro->title . " " . print_r($char, true) . "<br>";
                } else {
                    print_r($book);
                    echo "<br>";
                }
            }
        });
    }

    public function excelDescription() {
        $cmd = 'find  ' . public_path() . '/excel/ -name "Super*.xlsx"';

        $list = shell_exec($cmd);

        $list = explode("\n", $list);

        Excel::load($list[0], function($reader) {

            foreach ($reader->get() as $i => $book) {
                if ($book->sf_code != '') {

                    $pro = Products::where("reference", (int) $book->sf_code)->first();
                    $char = array();

                    if ($pro != null) {

                        $edit = Products::find($pro->id);
                        if ($book->acerca_del_producto != '') {
                            $edit->about = $book->acerca_del_producto;
                        }
                        if ($book->por_que_te_encantara != '') {
                            $edit->why = $this->cleanText($book->por_que_te_encantara);
                        }
                        if ($book->ingredientes != '') {
                            $edit->ingredients = $this->cleanText($book->ingredientes);
                        }

                        $edit->save();
                        echo $pro->title . " " . $pro->reference . "<br>";
                    } else {
                        print_r($book);
                        echo "<br>";
                    }
                } else {
                    echo "Sdasdsad";
                }
            }
        });
    }

    public function readImagesSubCategory() {

        $cmd = 'find  ' . public_path() . '/subcategorias -name "*.png"';

        $list = shell_exec($cmd);

        $list = explode("\n", $list);
        $list = array_filter($list);

        foreach ($list as $value) {
            if (is_file($value)) {
                $manager = new ImageManager(array('driver' => 'imagick'));

//                $image = $manager->make($value)->widen(150);
                $image = $manager->make($value);
//            dd($image);
                $cod = substr($image->basename, 0, strpos($image->basename, "."));
                $cod = explode("-", $cod);
//                dd($cod);
                $pro = Characteristic::where("order", $cod[1])->first();

//                dd($pro);

                if ($pro != null) {

                    $path = public_path() . "/images/subcategory/" . $pro->id . "/";
                    File::makeDirectory($path, $mode = 0777, true, true);
                    chmod($path, 0777);

                    $pathsys = "images/subcategory/" . $pro->id . "/";

                    $path .= $image->basename;
                    $pathsys .= $image->basename;

                    $image->save($path);

                    $pro->img = $pathsys;
                    $pro->order = $cod[1];

                    $res = $pro->save();

                    var_dump($res);
                    echo $pro->img . "<br>";
                    $cod = array();
                } else {
                    echo "Rechazado: " . $value . "<br>";
                }
            }
        }

        $cmd = 'find  ' . public_path() . '/subcategorias/Coloreadas/ -name "*.png"';

        $list = shell_exec($cmd);

        $list = explode("\n", $list);
        $pathsys = '';

        foreach ($list as $value) {
            if (is_file($value)) {
                $manager = new ImageManager(array('driver' => 'imagick'));

                $image = $manager->make($value)->widen(700);

                $cod = substr($image->basename, 0, strpos($image->basename, "-"));
                $cod = explode("_", $cod);

                $pro = Characteristic::find($cod[1]);

                if ($pro != null) {

                    $path = public_path() . "/images/subcategory/con/" . $pro->id . "/";
                    File::makeDirectory($path, $mode = 0777, true, true);
                    chmod($path, 0777);

                    $pathsys = "images/subcategory/con/" . $pro->id . "/";

                    $path .= $image->basename;
                    $pathsys .= $image->basename;

                    $image->save($path);

                    $pro->alternative = $pathsys;

                    $res = $pro->save();
                    var_dump($res);
                    echo $pro->img . "<br>";
                } else {
                    echo "Rechazado: " . $value . "<br>";
                }
            }
        }
    }

    public function getProduct($warehouse_id, $reference) {

        $ware = Warehouses::find($warehouse_id);
        var_dump($ware->description);

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
        ;
        $res = DB::select($sql);
        $res = $res[0];
        dd($res);
    }

    public function formInventory() {
        return view("Tool/uploadInventory");
    }

    public function storeInventory(Request $req) {

        $in = $req->all();

        $urls = $in["urls"];
        $urls = explode("\n", $urls);
        $urls = array_filter($urls);

        foreach ($urls as $value) {

            $handler = curl_init($value);
            $response = curl_exec($handler);
            curl_close($handler);
            echo $response;
            echo "<br>" . $value . "<br>";
        }


        return view("Tool/uploadInventory");
    }

    /**
     * 
     * Options 1. new 2. Update
     * 
     * @param type $warehouse_id
     * @param type $reference
     * @param type $quantity
     * @param type $lot
     * @param type $expire
     */
    public function addInventory($warehouse_id, $reference, $quantity, $lot, $expire, $cost_sf = null) {

        if (Auth::user() != null) {
            $ware = Warehouses::find($warehouse_id);

            if (Auth::user()->id == $ware->responsible_id || Auth::user()->id == 2) {
                if ($quantity > 0) {

                    $expire = date("Y-m-d", strtotime($expire));

                    $pro = Products::where("reference", $reference)->first();
                    $w = Warehouses::find($warehouse_id);

                    if ($cost_sf == null) {
                        $cost_sf = $pro->cost_sf;
                    }


                    if (strtotime($expire) > strtotime(date("Y-m-d"))) {
                        $inv = Inventory::where("product_id", $pro->id)->where("lot", $lot)->where("warehouse_id", $warehouse_id)->where("value", $cost_sf)->first();

                        $new["product_id"] = $pro->id;
                        $new["warehouse_id"] = $warehouse_id;
                        $new["value"] = $cost_sf;
                        $new["expiration_date"] = $expire;
                        $new["quantity"] = $quantity;

                        $new["lot"] = $lot;

                        $user_id = (isset(Auth::user()->id) ? Auth::user()->id : 1);

                        if (count($inv) > 0) {
                            $inv->update_id = $user_id;
                            $inv->quantity = $inv->quantity + $quantity;
                            $new["insert_id"] = $inv->update_id;
                            $new["update_id"] = $inv->update_id;
                            $new["type_move"] = "update";
                            InventoryLog::create($new);
                            $inv->save();
//                echo " OK:" . $reference . " actualizado" . $expire . "\n";
                        } else {
                            $new["insert_id"] = $user_id;
                            Inventory::create($new);
                            $new["type_move"] = "new";
                            InventoryLog::create($new);
//                echo " OK:" . $reference . " creado" . $expire . "\n";
                        }
                    } else {
                        echo " ERROR: reference:" . $reference . " date not valid " . $expire . "\n";
                        exit;
                    }
                } else {
                    return " ERROR: reference:" . $reference . " quantity = 0\n";
                }
            } else {
                return "No tienes permiso de agregar inventario";
            }
        } else {
            return "Debes estar logueado al sistema";
        }
    }

    public function addInventoryReverse($header, $detail) {

        foreach ($detail as $val) {
            $dataNew = json_decode($val->quantity_lots);

            foreach ($dataNew as $value) {
                $pro = Products::find($value->product_id);
                $this->addInventory($header->warehouse_id, $pro->reference, $value->quantity, $value->lot, $value->expiration_date, $value->cost_sf);
            }
        }
    }

    public function validateInventory($warehouse_id, $reference, $quantity, $lot, $expire, $cost_sf) {
        $pro = Products::where("reference", $reference)->first();

        $valid = Inventory::where("warehouse_id", $warehouse_id)->where("product_id", $pro->id)
                        ->where("lot", $lot)->where("expiration_date", $expire)->where("value", $cost_sf)->where("quantity", ">=", $quantity)->first();
        $resp = array("status" => false, "quantity" => 0);
        if (count($valid) > 0) {
            $resp = array("status" => true, "quantity" => $valid->quantity);
        }

        return $resp;
    }

    public function addInventoryHold($warehouse_id, $reference, $quantity, $lot, $expire, $cost_sf, $id) {
        try {
            DB::beginTransaction();

            $expire = date("Y-m-d", strtotime($expire));

            $pro = Products::where("reference", $reference)->first();
            $w = Warehouses::find($warehouse_id);

            if (strtotime($expire) > strtotime(date("Y-m-d"))) {
                $hold = InventoryHold::where("row_id", $id)->where("product_id", $pro->id)->where("lot", $lot)
                                ->where("expiration_date", $expire)->where("value", $cost_sf)->first();

                $new["product_id"] = $pro->id;
                $new["warehouse_id"] = $warehouse_id;
                $new["value"] = $cost_sf;
                $new["expiration_date"] = $expire;
                $new["quantity"] = $quantity;
                $new["lot"] = $lot;


                if (count($hold) > 0) {

                    $hold->update_id = Auth::user()->id;

                    $total = $hold->quantity - $quantity;

                    if ($quantity == 0) {
                        echo $total . " asdasdasd";
                        exit;
                    }


                    if ($hold->quantity > $quantity) {
                        $this->substractHold($hold->id, $quantity);
                        $this->addInventory($warehouse_id, $reference, $total, $lot, $expire, $cost_sf);

//                        if ($hold->quantity > $quantity) {
//                            $this->substractHold($hold->id, $total);
//                            $this->addInventory($warehouse_id, $reference, $total, $lot, $expire, $cost_sf);
//                        } else {
//                            $this->substractHold($hold->id, $quantity);
//                            $this->addInventory($warehouse_id, $reference, $total, $lot, $expire, $cost_sf);
//                        }

                        $hold->quantity = $quantity;
                        $new["insert_id"] = Auth::user()->id;
                        $new["update_id"] = $hold->update_id;

                        $new["type_move"] = "update_hold";
                        InventoryLog::create($new);

                        $hold->save();
                    } else {
                        if ($hold->quantity != $quantity) {
                            $total = $quantity - $hold->quantity;
                            $this->substractHold($hold->id, $quantity);
                            $this->outInventoryHold($warehouse_id, $reference, $total, $lot, $expire, $cost_sf);
                        } else {
                            $this->substractHold($hold->id, $quantity);
                        }
                    }
                } else {

                    if ($quantity > 0) {
                        $new["insert_id"] = Auth::user()->id;
                        $new["row_id"] = $id;

                        $this->outInventoryHold($warehouse_id, $reference, $quantity, $lot, $expire, $cost_sf);

                        InventoryHold::create($new);
                        $new["type_move"] = "new_hold";
                        unset($new["row_id"]);
                        InventoryLog::create($new);
                    }
                }

                DB::commit();
            } else {
                echo " ERROR: reference:" . $reference . " date not valid " . $expire . "\n";
                exit;
            }
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, "msg" => "Wrong"], 409);
        }
    }

    public function outInventoryHold($warehouse_id, $reference, $quantity, $lot, $expire, $cost_sf) {
        $pro = Products::where("reference", $reference)->first();
        $w = Warehouses::find($warehouse_id);
        $inv = Inventory::where("product_id", $pro->id)->where("lot", $lot)->where("warehouse_id", $warehouse_id)->where("value", $cost_sf)->first();

        $up["product_id"] = $pro->id;
        $up["warehouse_id"] = $warehouse_id;
        $up["value"] = $cost_sf;
        $up["expiration_date"] = $expire;
        $up["quantity"] = $quantity;
        $up["lot"] = $lot;
        $up["type_move"] = "out_hold";
        $up["insert_id"] = Auth::user()->id;


        $inv->quantity = $inv->quantity - $quantity;

        if ($inv->quantity > 0) {
            $inv->save();
            InventoryLog::create($up);
        } else {
            $inv->delete();
            $up["type_move"] = "delete producto per inexistence";
            InventoryLog::create($up);
        }
    }

    public function substractHold($id, $quantity) {
        $hold = InventoryHold::find($id);

        $up["product_id"] = $hold->product_id;
        $up["warehouse_id"] = $hold->warehouse_id;
        $up["value"] = $hold->value;
        $up["expiration_date"] = $hold->expiration_date;
        $up["quantity"] = $hold->quantity;
        $up["lot"] = $hold->lot;
        $up["insert_id"] = Auth::user()->id;

        if ($quantity == 0) {
            $up["type_move"] = "quit hold quantity in equal to 0";
            $hold->delete();
        } else {
            $hold->quantity = $quantity;
            $up["type_move"] = "substract_hold";
            $hold->save();
        }

        InventoryLog::create($up);
    }

    public function substract($row_id) {
        $hold = InventoryHold::where("row_id", $row_id)->first();
        if ($hold != null) {
            $up["row_id"] = $row_id;
            $up["product_id"] = $hold->product_id;
            $up["warehouse_id"] = $hold->warehouse_id;
            $up["value"] = $hold->value;
            $up["expiration_date"] = $hold->expiration_date;
            $up["quantity"] = $hold->quantity;
            $up["lot"] = $hold->lot;
            $up["type_move"] = "substract_hold";
            $up["insert_id"] = Auth::user()->id;
            InventoryLog::create($up);

            $hold->delete();
        } else {
            echo $row_id;
            exit;
        }
    }

    public function addInventoryRow($row_id) {
        $hold = InventoryHold::where("row_id", $row_id)->first();
        $pro = Products::find($hold->product_id);

        $this->addInventory($hold->warehouse_id, $pro->reference, $hold->quantity, $hold->lot, $hold->expiration_date, $hold->value);
        $up["row_id"] = $row_id;
        $up["product_id"] = $hold->product_id;
        $up["warehouse_id"] = $hold->warehouse_id;
        $up["value"] = $hold->value;
        $up["expiration_date"] = $hold->expiration_date;
        $up["quantity"] = $hold->quantity;
        $up["lot"] = $hold->lot;
        $up["type_move"] = "substract_hold";
        $up["insert_id"] = Auth::user()->id;
        InventoryLog::create($up);
        $hold->delete();
    }

}
