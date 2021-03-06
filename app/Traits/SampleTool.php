<?php

namespace App\Traits;

use DB;

trait SampleTool {

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
    private $quantity;
    private $quantity_real;

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
        $this->quantity = 0;
        $this->quantity_real = 0;
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

    function formatDetail($id) {
        $detail = DB::table("samples_detail")
                ->select("samples_detail.id", "samples_detail.status_id", DB::raw("coalesce(samples_detail.description,'') as comment"), "samples_detail.real_quantity", "samples_detail.quantity", "samples_detail.value", DB::raw("products.reference ||' - ' ||products.title || ' - ' || stakeholder.business  as product"), "samples_detail.description", "parameters.description as status", "stakeholder.business as stakeholder", "products.bar_code", "products.units_sf", "samples_detail.tax")
                ->join("products", "samples_detail.product_id", "products.id")
                ->join("stakeholder", "stakeholder.id", "products.supplier_id")
                ->join("parameters", "samples_detail.status_id", DB::raw("parameters.id and parameters.group='entry'"))
                ->where("sample_id", $id)
                ->orderBy("id", "asc")
                ->get();

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

            $this->quantity += $detail[$i]->quantity;
            $this->quantity_real += $detail[$i]->real_quantity;


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
        $detail = DB::table("sales_detail")->
                        select("sales_detail.id", "sales_detail.quantity", "sales_detail.value", DB::raw("products.reference ||' - ' ||products.title || ' - ' || stakeholder.business  as product"), "sales_detail.description", "stakeholder.business as stakeholder", "products.bar_code", "products.units_sf", "sales_detail.tax")
                        ->join("products", "sales_detail.product_id", "products.id")
                        ->join("stakeholder", "stakeholder.id", "products.supplier_id")
                        ->where("sale_id", $id)->orderBy("products.supplier_id", "asc")->orderBy(DB::raw("3"), "DESC")->get();

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


        return $detail;
    }

}
