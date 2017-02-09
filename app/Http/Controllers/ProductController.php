<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Core;
use App\Models\Administration;
use Session;
class ProductController extends Controller
{
    public function index(){
        $categories= Core\Categories::all();
        $suppliers= Administration\Suppliers::all();
        return view("products.init", compact("categories","suppliers"));
    }
    
      public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
//            $user = Auth::User();
//            $input["users_id"] = 1;
            $result = Core\Products::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                return response()->json(['success' => 'true']);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

    public function edit($id) {
        $product = Core\Products::FindOrFail($id);
        return response()->json($product);
    }

    public function update(Request $request, $id) {
        $product = Core\Products::FindOrFail($id);
        $input = $request->all();
        $result = $product->fill($input)->save();
        if ($result) {
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true']);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function destroy($id) {
        $product = Core\Products::FindOrFail($id);
        $result = $product->delete();
        Session::flash('delete', 'Se ha eliminado correctamente');
        if ($result) {
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true']);
        } else {
            return response()->json(['success' => 'false']);
        }
    }
}
