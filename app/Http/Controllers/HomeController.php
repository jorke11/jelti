<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
//use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use App\Models\Administration\Comment;
use App\Models\Security\Users;
use App\Models\Security\Roles;
use App\Models\Administration\Warehouses;
use DB;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $sql = "
            SELECT p.title,sum(d.quantity) cantidadTotal,round(sum(d.value * d.quantity * d.units_sf)) as total
            FROM sales_detail d
            JOIN sales s ON s.id=d.sale_id  
            JOIN products p ON p.id=d.product_id  
            WHERE product_id IS NOT NULL AND s.created BETWEEN '" . date("Y-m") . "-01 00:00' and '" . date("Y-m-d") . " 23:59'
            GROUP BY 1
            ORDER BY 2 DESC LIMIT 1";
//        echo $sql;exit;
        $product = DB::select($sql);
        
        if (count($product) > 0) {
            $product = $product[0];
        }

        $sql = "
            SELECT client,sum(total) total,sum(subtotalnumeric) subtotal,sum(quantity) as unidades
            FROM vdepartures
            WHERE created BETWEEN '" . date("Y-m") . "-01 00:00' and '" . date("Y-m-d") . " 23:59' AND status_id=2
            group by 1
            ORDER BY 2 DESC
            LIMIT 1
            ";

        $client = DB::select($sql);
        if (count($client) > 0) {
            $client = $client[0];
        }

        $sql = "
            SELECT s.business proveedor,round(sum(d.quantity*d.units_sf)) cantidadtotal,round(sum(d.value * d.quantity * d.units_sf)) total
            FROM sales_detail d
            JOIN sales sal ON sal.id=d.sale_id  
            JOIN products p ON p.id=d.product_id  
            JOIN stakeholder s ON s.id=p.supplier_id  
            WHERE product_id is not null AND sal.created BETWEEN '" . date("Y-m") . "-01 00:00' and '" . date("Y-m-d") . " 23:59'
            GROUP BY 1
            ORDER BY 3 desc LIMIT 1";

        $supplier = DB::select($sql);
        
        if (count($supplier) > 0) {
            $supplier = $supplier[0];
        }
        $sql = "
            SELECT u.name ||' '|| u.last_name as vendedor,sum(d.quantity) cantidadtotal,round(sum(d.value * d.quantity * d.units_sf)) total
            FROM sales_detail d
            JOIN sales s ON s.id=d.sale_id
            JOIN users u ON u.id=s.responsible_id
            GROUP BY 1
            ORDER BY 3 desc";

        $commercial = DB::select($sql);
        if (count($commercial) > 0) {
            $commercial = $commercial[0];
        }

        $ant = date('Y-m', strtotime('-1 month', strtotime(date("Y-m"))));


        $sql = "
                SELECT count(*) estemes,(select count(*) 
                                        from stakeholder where created_at between '" . $ant . "-01 00:00' and '" . $ant . "-30 23:59') mesanterior 
                FROM stakeholder where created_at > '" . date("Y-m") . "-01 00:00'";

        $newClient = DB::select($sql);
        if (count($newClient) > 0) {
            $newClient = $newClient[0];
        }

        $sql = "
            select sum(d.quantity * d.value * d.units_supplier) estemes,
            (select sum(d.quantity * d.value * d.units_supplier)
            from purchases_detail  d
            JOIN purchases p ON p.id=d.purchase_id
            where d.product_id is not null and p.created_at between '" . $ant . "-01 00:00' and '" . $ant . "-30 23:59') mesanterior
            from purchases_detail  d
            JOIN purchases p ON p.id=d.purchase_id
            where d.product_id is not null and p.created_at > '" . date("Y-m") . "-01 00:00'
        ";
        $purchase = DB::select($sql);
        if (count($purchase) > 0) {
            $purchase = $purchase[0];
        }
        
//        dd($purchase);

        if (Auth::user()->status_id == 3) {
            $users = Auth::user();
            $roles = Roles::where("id", $users->role_id)->get();
            $warehouses = Warehouses::all();
            if ($users->status_id == 3) {
                return view('activation', compact("users", "roles", "warehouses"));
            } else {
                return \Redirect::to('/');
            }
        } else {
            if (Auth::user()->role_id == 2) {
                return view('client', compact("product", "client", "supplier", "commercial"));
            } else {
                return view('dashboard', compact("product", "client", "supplier", "commercial", "newClient","purchase"));
//                return view('dashboard');
            }
        }
    }

}
