<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Administration\Warehouse;
use App\Models\Administration\Product;
use App\Models\Inventory\Entry;
use App\Models\Inventory\EntryDetail;
use App\Models\Administration\Category;
use \App\Models\Invoicing\Purchage;
use Session;

class EntryController extends Controller {

    public function index() {
        $category = Category::all();
        return view("entry.init", compact("category"));
    }

    public function getConsecutive($id) {
        return response()->json(["response" => 'prueba']);
    }

    public function getDetailProduct($id) {
        $category = DB::table("product")
                ->select("product.id", "product.title", "category.description as caterory", "product.price_sf")
                ->join("category", "category.id", "=", "product.category_id")
                ->where("product.id", $id)
                ->first();

        return response()->json(["response" => $category]);
    }

    public function getSupplier($id) {
        $supplier = \App\Models\Administration\Supplier::findOrFail($id);
        return response()->json(["response" => $supplier]);
    }

    public function getProducts($id) {
        $resp = \App\Models\Administration\Product::where("supplier_id", $id);
        return response()->json(["response" => $resp]);
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
//            $user = Auth::User();
//            $input["users_id"] = 1;
            $input["status_id"] = 1;
            $result = Entry::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                $resp = Entry::FindOrFail($result["attributes"]["id"]);
                return response()->json(['success' => 'true', "data" => $resp]);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

    public function sendEntry(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();

            $purchage = new \App\Models\Invoicing\Purchage();
            $entry = Entry::findOrFail($input["id"]);


//            dd($purchage->all());Exit;
//            $user = Auth::User();
//            $input["users_id"] = 1;
            DB::transaction(function() {
                $id = DB::table("purchage")->insertGetId(
                        ["entry_id" => $entry->id, "warehouse_id" => $entry->warehouse_id, "responsable_id" => $entry->responsable_id,
                            "supplier_id" => $entry->supplier_id, "city_id" => $entry->city_id, "description" => $entry->description,
                            "avoice" => $entry->avoice, "status_id" => $entry->status_id, "created" => $entry->created]
                );
                $detail = EntryDetail::where()->get();

                foreach ($detail as $value) {
                    $pro = Product::findOrFail($value->product_id);
                    Purchage::insert([
                        'purchage_id' => $id, "entry_id" => $input["id"], "product_id" => $value->product_id,
                        "category_id" => $value->category_id, "quantity" => $value->quantity,
                        "expiration_date" => $value->expiration_date, "value" => $value->value, "tax" => $pro->tax
                    ]);
                }
            });

            $purchage = $entry;
            $entry->status_id = 2;
            $entry->save();
        }
    }

    public function edit($id) {
        $entry = Entry::FindOrFail($id);
        $detail = DB::table("entry_detail")->where("entry_id", "=", $id)->get();
        return response()->json(["header" => $entry, "detail" => $detail]);
    }

    public function getDetail($id) {
        $detail = EntryDetail::FindOrFail($id);
        return response()->json($detail);
    }

    public function update(Request $request, $id) {
        $entry = Entry::FindOrFail($id);
        $input = $request->all();
        $result = $entry->fill($input)->save();
        if ($result) {
            $resp = Entry::FindOrFail($id);
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true', "data" => $resp]);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function updateDetail(Request $request, $id) {
        $entry = EntryDetail::FindOrFail($id);
        $input = $request->all();
        $result = $entry->fill($input)->save();
        if ($result) {
            $resp = DB::table("entry_detail")->where("entry_id", "=", $input["entry_id"])->get();
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true', "data" => $resp]);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function destroy($id) {
        $entry = Entry::FindOrFail($id);
        $result = $entry->delete();
        Session::flash('delete', 'Se ha eliminado correctamente');
        if ($result) {
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true']);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function destroyDetail($id) {
        $entry = EntryDetail::FindOrFail($id);
        $result = $entry->delete();
        Session::flash('delete', 'Se ha eliminado correctamente');
        if ($result) {
            $resp = DB::table("entry_detail")->where("entry_id", "=", $entry["entry_id"])->get();
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true', "data" => $resp]);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function storeDetail(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();

            unset($input["id"]);
//            $user = Auth::User();
//            $input["users_id"] = 1;
            $result = EntryDetail::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                $resp = EntryDetail::where("entry_id", $input["entry_id"])->get();
                return response()->json(['success' => 'true', "data" => $resp]);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

}
