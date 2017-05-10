<?php

namespace App\Http\Controllers\Security;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Security\Users;
use App\Models\Security\Permissions;
use App\Models\Security\PermissionsUser;
use App\Models\Security\Roles;
use App\Models\Administration\Suppliers;
use App\Models\Administration\Cities;
use Session;
use DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Uploads\Base;
use Mail;

class UserController extends Controller {

    public $resp;
    public $cont;
    public $email;

    public function __construct() {
        $this->middleware("auth");
        $this->resp = array();
        $this->cont = 0;
        $this->email = "";
    }

    public function index() {
        $profile = Roles::all();
        return view("Security.user.init", compact("profile", "supplier", "city"));
    }

    public function create() {
        return "create";
    }

    public function storeExcel(Request $request) {
        if ($request->ajax()) {

            $input = $request->all();
            $this->name = '';
            $this->path = '';
            $file = array_get($input, 'file_excel');
            $this->name = $file->getClientOriginalName();
            $this->name = str_replace(" ", "_", $this->name);
            $this->path = "uploads/users/" . date("Y-m-d") . "/" . $this->name;

            $file->move("uploads/users/" . date("Y-m-d") . "/", $this->name);

            Excel::load($this->path, function($reader) {
                $in["name"] = $this->name;
                $in["path"] = $this->path;
                $in["quantity"] = count($reader->get());

                $base_id = Base::create($in)->id;

                foreach ($reader->get() as $book) {
                    if ($book->correo != '') {
                        $rol = Roles::where("description", "ILIKE", "%" . $book->perfil . "%")->first();
              
                        if (count($rol) > 0) {
                            $input["role_id"] = $rol->id;
                        } else {
                            $rol = Roles::where("description", "ILIKE", "%operations%")->first();
                            $input["role_id"] = $rol->id;
                        }

                        $input["status_id"] = 3;

                        $this->email = $book->correo;

                        $pos = strpos($book->correo, "@");
                        $input["name"] = substr($book->correo, 0, $pos);
                        $input["password"] = bcrypt(substr($book->correo, 0, $pos));
                        $input["email"] = $book->correo;

                        if ($book->correo != 'tech@superfuds.com.co') {
                            $user = Users::where("email", "ILIKE", "%" . $book->correo . "%")
                                    ->first();

                            $noti["email"] = $book->correo;
                            $noti["password"] = substr($book->correo, 0, $pos);
                            
                            
                            Mail::send("Notifications.activation", $noti, function($msj) {
                                $msj->subject("Solicitud de activación para: " . $this->email);
                                $msj->to($this->email, "info")->cc('tech@superfuds.com.co');
                            });

                            if (count($user) > 0) {
                                unset($input["email"]);
                                $user->fill($input)->save();
                            } else {
                                Users::create($input);
                            }
                        }
                    }
                }
            })->get();

            return response()->json(["success" => true, "data" => Cities::all()]);
        }
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
            if (!isset($input["status"])) {
                $input["status"] = false;
            }


            if ($input["password"] != '') {
                $input["password"] = bcrypt($input["password"]);
            } else {
                unset($input["password"]);
            }
//            $user = Auth::User();
//            $input["users_id"] = 1;


            $result = Users::create($input);
            if ($result) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function edit($id) {
        $resp["header"] = Users::where("id", $id)->first();
        unset($resp["header"]["password"]);
        return response()->json($resp);
    }

    public function getPermission($id) {
        $sql = "
                                        SELECT p.id = ANY (SELECT permission_id FROM permissions_user where users_id=" . $id . " and permission_id=p.id) allowed,p.*
                                        from permissions p 
                                        WHERE parent_id=0 
                                        AND typemenu_id=0 
                                        ORDER BY priority asc";

        $this->resp["permission"] = DB::select($sql);

        $this->recursivePermission($this->resp["permission"], $id);

        $resp["tree"] = $this->resp["tree"];

        $resp["permissionuser"] = PermissionsUser::where("users_id", $id)->get();

        return response()->json($resp);
    }

    public function recursivePermission($param, $id) {
        $cont = 0;
        foreach ($param as $key => $val) {
            $query = "
                                        SELECT p.id = ANY (SELECT permission_id FROM permissions_user where users_id=" . $id . " and permission_id=p.id) allowed,p.*
                                        from permissions p 
                                        WHERE parent_id=" . $val->id . "
                                        ORDER BY priority asc";

            $children = DB::select($query);


            if (count($children) > 0) {
                $this->resp["tree"][$cont] = $val;
                $this->resp["tree"][$cont]->nodes = $children;
                $this->recursivePermission($children, $id);
            } else {
//                $this->resp["tree"][] = $val;
            }
            $cont++;
        }
    }

    public function update(Request $request, $id) {
        $user = Users::FindOrFail($id);
        $input = $request->all();

        if (!isset($input["status_id"])) {
            $input["status_id"] = false;
        } else {
            $input["status_id"] = 1;
        }


        if ($input["password"] != '') {
            $input["password"] = bcrypt($input["password"]);
        } else {
            unset($input["password"]);
        }


        $result = $user->fill($input)->save();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function savePermission(Request $request, $id) {
        $input = $request->all();
        $per = explode(",", $input["arr"]);

        $del = PermissionsUser::whereNotIn("permission_id", $per)->where("users_id", $id)->delete();

        foreach ($per as $val) {
            $us = PermissionsUser::where("permission_id", $val)->where("users_id", $id)->get();
            if (count($us) == 0) {
                $per = new PermissionsUser();
                $per->users_id = $id;
                $per->permission_id = $val;
                $per->save();
            }
        }
        return response()->json(['success' => true]);
    }

    public function destroy($id) {
        $user = Users::FindOrFail($id);
        $result = $user->delete();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => Ffalse]);
        }
    }

    public function logOut() {
        Auth::logout();
//         return Redirect::to('/')->with('msg', 'Gracias por visitarnos!.');
        return \Redirect::to('/');
    }

}
