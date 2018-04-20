<?php

namespace App\Traits;

use App\Models\Inventory\InventoryHold;
use App\Models\Inventory\Inventory;
use App\Models\Inventory\InventoryLog;
use DB;
use Auth;

trait ToolInventory {

    public function __construct() {
        
    }

    public function addInventory($warehouse_id, $reference, $quantity, $lot, $expiration_date, $cost_sf, $price_sf) {
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
                $new["insert_id"] = Auth::user()->id;
                $new["expiration_date"] = $expiration_date;

                $inv = Inventory::where("warehouse_id", $warehouse_id)->where("product_id", $pro->product_id)->where("cost_sf", $pro->cost_sf)->where("price_sf", $pro->price_sf)->where("lot", $lot)->first();

                if ($inv != null) {
                    $inv->quantity = $inventory->quantity + $quantity;
                    $inv->save();
                    $new["previous_quantity"] = $inventory->quantity;
                    $new["type_move"] = "Add new Inventory to product existance";
                    InventoryLog::create($new);
                } else {
                    Inventory::create($new);
                    $new["previous_quantity"] = 0;
                    $new["type_move"] = "Add new Inventory";
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

    public function moveHold($row_id, $inventory_id, $quantity) {
        $hold = InventoryHold::where("row_id", $row_id)->first();
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

        if ($hold != null) {
            if ($hold->quantity != $quantity) {
                $new["previous_quantity"] = $inventory->quantity;
                if ($hold->quantity < $quantity) {
                    $quit_inventory = $quantity - $hold->quantity;
                    $hold->quantity = $quantity;
                    $inventory->quantity = $inventory->quantity - $quit_inventory;
                    $new["quantity"] = $hold->quantity;
                    $new["type_move"] = "Add quantity to inventory existence";
                    InventoryLog::create($new);
                } else {
                    $add_inventory = $hold->quantity - $quantity;
                    $hold->quantity = $quantity;
                    $inventory->quantity = $inventory->quantity + $add_inventory;
                    $new["quantity"] = $hold->quantity;
                    $new["type_move"] = "delete quantity to inventory existence";
                    InventoryLog::create($new);
                }
                $inventory->save();
                $hold->save();
            }
        } else {
            InventoryHold::create($new);
            $new["previous_quantity"] = $inventory->quantity;
            $inventory->quantity = $inventory->quantity - $quantity;
            $inventory->save();
            $new["type_move"] = "Insert to Hold";
            InventoryLog::create($new);
        }
    }

}
