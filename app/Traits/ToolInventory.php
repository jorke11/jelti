<?php

namespace App\Traits;

use App\Models\Inventory\InventoryHold;
use App\Models\Inventory\Inventory;
use App\Models\Inventory\InventoryLog;
use App\Models\Administration\Products;
use DB;
use Auth;
use Log;

trait ToolInventory {

    public function __construct() {
        
    }

    public function addInventory($warehouse_id, $reference, $quantity, $lot, $expiration_date, $cost_sf, $price_sf, $type_move = 'supplier_to_inv') {
        $expire = date("Y-m-d", strtotime($expiration_date));

        $response = array("status" => true);
        $pro = \App\Models\Administration\Products::where("reference", $reference)->first();



        if ($pro != null) {
            if (strtotime($expire) > strtotime(date("Y-m-d"))) {
                $new["warehouse_id"] = $warehouse_id;
                $new["product_id"] = $pro->id;
                $new["cost_sf"] = $cost_sf;
                $new["price_sf"] = $price_sf;
                $new["lot"] = $lot;
                $new["quantity"] = $quantity;
                $new["insert_id"] = 1;
                $new["expiration_date"] = $expire;

                $inventory = Inventory::where("warehouse_id", $warehouse_id)->where("product_id", $pro->id)
                                ->where("cost_sf", $pro->cost_sf)
                                ->where("price_sf", $pro->price_sf)->where("lot", $lot)->first();

                if ($inventory != null) {
                    $new["current_quantity"] = $inventory->quantity;
                    $inventory->quantity = $inventory->quantity + $quantity;
                    $inventory->save();
                    $new["previous_quantity"] = $inventory->quantity;
                    $new["type_move"] = $type_move;
                    $new["subtype"] = "update_inv_add";
                    InventoryLog::create($new);
                } else {
                    Inventory::create($new);
                    $new["current_quantity"] = 0;
                    $new["previous_quantity"] = 0;
                    $new["type_move"] = $type_move;
                    $new["subtype"] = "create_inv_add";
                    InventoryLog::create($new);
                }

                $response = array("status" => true);
            } else {
                $response = array("status" => false, "msg" => "Fecha de vencimiento no valida");
            }
        } else {
            $response = array("status" => false, "msg" => "producto no existe");
        }

        return $response;
    }

    public function validateInventory($warehouse_id, $reference, $quantity, $lot, $expire, $cost_sf) {
        $pro = Products::where("reference", $reference)->first();

        $valid = Inventory::where("warehouse_id", $warehouse_id)->where("product_id", $pro->id)
                        ->where("lot", $lot)->where("expiration_date", $expire)->where("cost_sf", $cost_sf)->where("quantity", ">=", $quantity)->first();

        $resp = array("status" => false, "quantity" => 0);
        if (count($valid) > 0) {
            $resp = array("status" => true, "quantity" => $valid->quantity);
        }

        return $resp;
    }

    public function substractForSale($row_id, $quantity_lots) {
        $quantity_lots = json_decode($quantity_lots);

        foreach ($quantity_lots as $value) {
            $hold = InventoryHold::where("row_id", $row_id)->where("lot", $value->lot)->first();
            if ($hold != null) {
                $up["row_id"] = $row_id;
                $up["product_id"] = $hold->product_id;
                $up["warehouse_id"] = $hold->warehouse_id;
                $up["cost_sf"] = $hold->cost_sf;
                $up["expiration_date"] = $hold->expiration_date;
                $up["quantity"] = $hold->quantity;
                $up["lot"] = $hold->lot;
                $up["type_move"] = "hold_to_client";
                $up["subtype"] = "update_hold_substract";
                $up["current_quantity"] = $hold->quantity;
                $up["insert_id"] = Auth::user()->id;
                InventoryLog::create($up);
                $hold->delete();
            } else {
                echo $row_id;
                exit;
            }
        }
    }

    public function substractForDelete($row_id) {
        $hold = InventoryHold::where("row_id", $row_id)->first();
        if ($hold != null) {
            $up["row_id"] = $row_id;
            $up["product_id"] = $hold->product_id;
            $up["warehouse_id"] = $hold->warehouse_id;
            $up["cost_sf"] = $hold->cost_sf;
            $up["expiration_date"] = $hold->expiration_date;
            $up["quantity"] = $hold->quantity;
            $up["lot"] = $hold->lot;
            $up["type_move"] = "hold_to_inv";
            $up["subtype"] = "update_hold_substract";
            $up["current_quantity"] = $hold->quantity;
            $up["insert_id"] = Auth::user()->id;
            InventoryLog::create($up);
            $hold->delete();
        } else {
            echo $row_id;
            exit;
        }
    }

    public function reverseInventoyHold($data, $detail) {
        
        foreach ($detail as $value) {
            if ($value->quantity_lots != null) {
                $hold = json_decode($value->quantity_lots);
                
                foreach ($hold as $val) {

                    if (!isset($val->price_sf) || $val->price_sf == "null") {
                        $pro = \App\Models\Administration\Products::find($val->product_id);
                        $val->price_sf = $pro->price_sf;
                    }

                    $new["row_id"] = $value->id;
                    $new["product_id"] = $val->product_id;
                    $new["warehouse_id"] = $data->warehouse_id;
                    $new["cost_sf"] = $val->cost_sf;
                    $new["expiration_date"] = $val->expiration_date;
                    $new["quantity"] = $val->quantity;
                    $new["lot"] = $val->lot;
                    $new["price_sf"] = $val->price_sf;
                    $new["insert_id"] = Auth::user()->id;

                    $hold = InventoryHold::where("price_sf", $val->price_sf)->where("lot", $val->lot)->where("expiration_date", $val->expiration_date)
                                    ->where("cost_sf", $val->cost_sf)->where("warehouse_id", $data->warehouse_id)->where("product_id", $val->product_id)->first();

                    $new["type_move"] = "client_to_inv";
                    $new["subtype"] = "update";

                    if ($hold != null) {
                        $new["current_quantity"] = $hold->quantity;
                        $hold->quantity = $hold->quantity + $val->quantity;
                        $hold->save();
                        $new["subtype"] = "update_hold_add";
                        $new["previous_quantity"] = $hold->quantity;
                    } else {
                        InventoryHold::create($new);
                        $new["current_quantity"] = 0;
                        $new["subtype"] = "create_hold_add";
                        $new["previous_quantity"] = 0;
                    }

                    InventoryLog::create($new);
                }
            }
        }
    }

    public function moveHold($row_id, $inventory_id, $quantity, $lot) {
        $hold = InventoryHold::where("row_id", $row_id)->where("lot", $lot)->first();
        $inventory = Inventory::find($inventory_id);


        $new["row_id"] = $row_id;
        $new["product_id"] = $inventory->product_id;
        $new["warehouse_id"] = $inventory->warehouse_id;
        $new["cost_sf"] = $inventory->cost_sf;
        $new["expiration_date"] = $inventory->expiration_date;
        $new["quantity"] = $quantity;
        $new["lot"] = $inventory->lot;
        $new["price_sf"] = $inventory->price_sf;
        $new["insert_id"] = Auth::user()->id;
        $new["price_sf"] = $inventory->price_sf;

        if ($hold != null) {
            if ($hold->quantity != $quantity) {
                Log::debug("-1 si");
                $new["previous_quantity"] = $inventory->quantity;
                if ($hold->quantity < $quantity) {
                    Log::debug("primer si");
                    $quit_inventory = $quantity - $hold->quantity;
                    $hold->quantity = $quantity;
                    $inventory->quantity = $inventory->quantity - $quit_inventory;
                    $new["current_quantity"] = $inventory->quantity;
                    $new["quantity"] = $hold->quantity;
                    $new["type_move"] = "inv_to_hold";
                    $new["subtype"] = "update_hold_add";
                    InventoryLog::create($new);
                } else {
                    Log::debug("segundo si");
                    $add_inventory = $hold->quantity - $quantity;
                    $hold->quantity = $quantity;
                    $inventory->quantity = $inventory->quantity + $add_inventory;
                    $new["current_quantity"] = $inventory->quantity;
                    $new["quantity"] = $hold->quantity;
                    $new["type_move"] = "hold_to_inv";
                    $new["subtype"] = "update_hold_subtract";
                    InventoryLog::create($new);
                }
                $inventory->save();
                $hold->save();
            }

            Log::debug("no hizo nada");
        } else {
            Log::debug("nuevo");
//            Log::debug($new);
            InventoryHold::create($new);
            $new["previous_quantity"] = $inventory->quantity;
            $inventory->quantity = $inventory->quantity - $quantity;
            $inventory->save();
            $new["current_quantity"] = $inventory->quantity;
            $new["type_move"] = "inv_to_hold";
            $new["subtype"] = "create_hold_add";
            InventoryLog::create($new);
        }

        return $inventory->id;
    }

}
