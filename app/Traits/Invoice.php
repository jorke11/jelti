<?php

namespace App\Traits;

use DB;
use App\Models\Administration\Comment;
use Auth;

trait Invoice {

    private $total;
    private $total_real;
    private $subtotal;
    private $subtotal_real;
    private $exento;
    private $exento_real;
    private $tax19;
    private $tax19_real;
    private $tax5;
    private $tax5_real;
    private $detail;

    public function __construct() {
        $this->total = 0;
        $this->total_real = 0;
        $this->subtotal = 0;
        $this->subtotal_real = 0;
        $this->tax19 = 0;
        $this->tax19_real = 0;
        $this->tax5 = 0;
        $this->tax5_real = 0;
        $this->exento = 0;
        $this->exento_real = 0;
    }

    function formatDetailJSON($data, $id) {

        $data["detail"] = $this->formatDetail($id);

        if ($data["header"]->discount > 0) {
            $this->total = $this->total - $data["header"]->discount;
            $this->total_real = $this->total_real - $data["header"]->discount;
        }

        if ($data["header"]->shipping_cost != 0) {
            if ($this->tax19 > 0) {
                $this->tax5 += 0.19 * $data["header"]->shipping_cost;
            } else if ($this->tax19 == 0 && $this->tax5 > 0) {
                $this->tax5 += 0.05 * $data["header"]->shipping_cost;
            }
        }

        $data["discount"] = "$ " . number_format($data["header"]->discount, 0, ",", ".");
        $data["total"] = "$ " . number_format($this->total, 0, ",", ".");
        $data["total_real"] = "$ " . number_format($this->total_real, 0, ",", ".");
        $data["subtotal"] = "$ " . number_format($this->subtotal, 0, ",", ".");
        $data["subtotal_real"] = "$ " . number_format($this->subtotal_real, 0, ",", ".");
        $data["tax5"] = "$ " . number_format($this->tax5, 0, ",", ".");
        $data["tax5_real"] = "$ " . number_format($this->tax5_real, 0, ",", ".");
        $data["tax19"] = "$ " . number_format($this->tax19, 0, ",", ".");
        $data["tax19_real"] = "$ " . number_format($this->tax19_real, 0, ",", ".");

        return $data;
    }

    function formatDetail($id, $zero = null) {

        $detail = DB::table("departures_detail")->
                select("departures_detail.id", "departures_detail.status_id", "departures_detail.product_id", DB::raw("coalesce(departures_detail.description,'') as comment"), "departures_detail.real_quantity", "departures_detail.quantity", "departures_detail.value", DB::raw("products.reference ||' - ' ||products.title || ' - ' || stakeholder.business  as product"), "departures_detail.description", "parameters.description as status", "stakeholder.business as stakeholder", "products.bar_code", "products.units_sf", "departures_detail.tax", "departures_detail.cost_sf", "products.category_id", "departures_detail.quantity_lots")
                ->join("products", "departures_detail.product_id", "products.id")
                ->join("stakeholder", "stakeholder.id", "products.supplier_id")
                ->join("parameters", "departures_detail.status_id", DB::raw("parameters.id and parameters.group='entry'"))
                ->where("departure_id", $id);


        if ($zero == true) {
            $detail->where("real_quantity", ">", 0);
        }

        $detail = $detail
                        ->orderBy("products.supplier_id", "asc")
                        ->orderBy(DB::raw("8"), "ASC")->get();

        $this->total = 0;
        $this->subtotal = 0;
        foreach ($detail as $i => $value) {
            $detail[$i]->valueFormated = "$" . number_format($value->value, 0, ",", ".");
            $detail[$i]->total = $detail[$i]->quantity * $detail[$i]->value * $detail[$i]->units_sf;
            $detail[$i]->total_real = $detail[$i]->real_quantity * $detail[$i]->value * $detail[$i]->units_sf;

            $detail[$i]->totalFormated = "$" . number_format($detail[$i]->total, 0, ",", ".");
            $detail[$i]->totalFormated_real = "$" . number_format($detail[$i]->total_real, 0, ",", ".");
            $this->subtotal += $detail[$i]->total;
            $this->subtotal_real += $detail[$i]->total_real;

            $this->total += $detail[$i]->total + ($detail[$i]->total * $value->tax);
            $this->total_real += $detail[$i]->total_real + ($detail[$i]->total_real * $value->tax);

            if ($value->tax == 0) {
                $this->exento += $detail[$i]->total;
                $this->exento_real += $detail[$i]->total_real;
            }
            if ($value->tax == 0.05) {
                $this->tax5 += $detail[$i]->total * $value->tax;
                $this->tax5_real += $detail[$i]->total_real * $value->tax;
            }
            if ($value->tax == 0.19) {
                $this->tax19 += $detail[$i]->total * $value->tax;
                $this->tax19_real += $detail[$i]->total_real * $value->tax;
            }
        }
        return $detail;
    }

    function formatDetailSales($id) {
        $sale = \App\Models\Invoicing\Sales::find($id);
        $dep = \App\Models\Inventory\Departures::find($sale->departure_id);

//        dd($dep);
        $detail = DB::table("sales_detail")->
                        select("sales_detail.id", "sales_detail.quantity", "sales_detail.value", DB::raw("products.reference ||' - ' ||products.title || ' - ' || stakeholder.business  as product"), "sales_detail.description", "stakeholder.business as stakeholder", "products.bar_code", "products.units_sf", "sales_detail.tax")
                        ->join("products", "sales_detail.product_id", "products.id")
                        ->join("stakeholder", "stakeholder.id", "products.supplier_id")
                        ->where("sale_id", $id)
                        ->orderBy("products.supplier_id", "asc")
                        ->orderBy(DB::raw("4"), "ASC")->get();

        $this->total = 0;
        $this->subtotal = 0;

        foreach ($detail as $i => $value) {
            $detail[$i]->valueFormated = "$" . number_format($value->value, 2, ",", ".");
            $detail[$i]->total = $detail[$i]->quantity * $detail[$i]->value * $detail[$i]->units_sf;
            $detail[$i]->totalFormated = "$" . number_format($detail[$i]->total, 2, ",", ".");

            $this->subtotal += $detail[$i]->total;
            $this->total += $detail[$i]->total + ($detail[$i]->total * $value->tax);

            if ($value->tax == 0) {
                $this->exento += $detail[$i]->total;
            }
            if ($value->tax == 0.05) {
                $this->tax5 += $detail[$i]->total * $value->tax;
            }
            if ($value->tax == 0.19) {
                $this->tax19 += $detail[$i]->total * $value->tax;
            }
        }


        if ($dep->shipping_cost_tax == 0.05) {
            $this->tax5 += $dep->shipping_cost * $dep->shipping_cost_tax;
        }

        if ($dep->shipping_cost_tax == 0.19) {
            $this->tax19 += $dep->shipping_cost * $dep->shipping_cost_tax;
        }

        $this->subtotal += $dep->shipping_cost;

        $this->total_real = $this->subtotal + $this->tax19 + $this->tax5 + (- $dep->discount);
        return $detail;
    }

    function formatDetailNote($id) {

        $sale = Sales::where("departure_id", $id)->first();
        $credit = CreditNote::where("departure_id", $id)->first();

        $dep = \App\Models\Inventory\Departures::find($sale->departure_id);

//        dd($dep);

        $detail = CreditNoteDetail::select("credit_note_detail.id", "credit_note_detail.quantity", DB::raw("products.reference ||' - ' ||products.title || ' - ' || stakeholder.business  as product"), "departures_detail.value", "departures_detail.real_quantity")
                ->join("products", "products.id", "credit_note_detail.product_id")
                ->join("stakeholder", "stakeholder.id", "products.supplier_id")
                ->join("credit_note", "credit_note.id", "credit_note_detail.creditnote_id")
                ->join("vdepartures", "vdepartures.id", "credit_note.departure_id")
                ->join("departures_detail", "departures_detail.departure_id", DB::raw("credit_note.departure_id and departures_detail.product_id=credit_note_detail.product_id"))
                ->where("credit_note_detail.creditnote_id", $credit->id)
                ->orderBy("products.supplier_id", "asc")
                ->orderBy(DB::raw("3"), "ASC")
                ->get();

        $this->total = 0;
        $this->subtotal = 0;

        foreach ($detail as $i => $value) {
            $detail[$i]->valueFormated = "$" . number_format($value->value, 2, ",", ".");
            $detail[$i]->total = $detail[$i]->quantity * $detail[$i]->value * $detail[$i]->units_sf;
            $detail[$i]->totalFormated = "$" . number_format($detail[$i]->total, 2, ",", ".");

            $this->subtotal += $detail[$i]->total;
            $this->total += $detail[$i]->total + ($detail[$i]->total * $value->tax);

            if ($value->tax == 0) {
                $this->exento += $detail[$i]->total;
            }
            if ($value->tax == 0.05) {
                $this->tax5 += $detail[$i]->total * $value->tax;
            }
            if ($value->tax == 0.19) {
                $this->tax19 += $detail[$i]->total * $value->tax;
            }
        }


        if ($dep->shipping_cost_tax == 0.05) {
            $this->tax5 += $dep->shipping_cost * $dep->shipping_cost_tax;
        }

        if ($dep->shipping_cost_tax == 0.19) {
            $this->tax19 += $dep->shipping_cost * $dep->shipping_cost_tax;
        }

        $this->subtotal += $dep->shipping_cost;

        $this->total_real = $this->subtotal + $this->tax19 + $this->tax5 + (- $dep->discount);
        return $detail;
    }
    
    public function formatDetailOrder($order) {
        $detail = null;
        if (Auth::user() != null) {
            
            if ($order != null) {
                
                $sql = "
                SELECT p.title product,s.business as supplier,d.product_id,d.order_id,sum(d.quantity) quantity,d.price_sf as value,sum(d.quantity * d.price_sf) total,
                p.image,p.thumbnail,
                d.units_sf,d.tax
                FROM orders_detail d
                    LEFT JOIN vproducts p ON p.id=d.product_id
                    LEFT JOIN stakeholder s ON s.id=p.supplier_id
                WHERE order_id=" . $order->id . "
                GROUP BY 1,2,3,4,d.units_sf,product_id,p.image,d.tax,p.thumbnail,d.price_sf
                ORDER BY 1";
                $detail = DB::select($sql);
                
                dd($detail);

                $detail = json_decode(json_encode($detail), true);
                return $detail;
            } else {
                return null;
            }
        }
    }
    

    public function logClient($client_id, $comment) {
        $in["user_id"] = Auth::user()->id;
        $in["stakeholder_id"] = $client_id;
        $in["description"] = $comment;
        Comment::create($in);
    }

}
