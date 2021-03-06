<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Parameters;
use App\Models\Blog\Category;

class CategoryController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }

    public function index() {
        $types = Parameters::where("group", "type_category")->get();
        $categories = Category::orderBy("description", "asc")->get();
        
        return view("Blog.category.init", compact("types", "categories"));
    }

    public function create() {
        return "create";
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            $id = $input["id"];

            unset($input["id"]);
            $file = array_get($input, 'img');
            $banner = array_get($input, 'banner');

            $input["status_id"] = (isset($input["status_id"])) ? 1 : 0;
            $input["node_id"] = (isset($input["node_id"])) ? $input["node_id"] : null;

            if ($id != '') {
                $row = Category::find($id);
                $row->fill($input)->save();
            } else {
                $id = Category::create($input)->id;
            }

            $row = Category::find($id);

            if ($file != null) {
                if (file_exists($row->image))
                    unlink($row->image);
                $name = $file->getClientOriginalName();
                $path = "images/blog/category/" . $id . "/";
                $name = str_replace(" ", "", $name);
                $file->move($path, $name);
                $path .= $name;
                $row->image = $path;
            }

            if ($banner != null) {
                if (file_exists($row->banner))
                    unlink($row->banner);
                $namebanner = $banner->getClientOriginalName();
                $pathbanner = "images/blog/category/" . $id . "/header/";
                $namebanner = str_replace(" ", "", $namebanner);
                $banner->move($pathbanner, $namebanner);
                $pathbanner .= $namebanner;
                $row->banner = $pathbanner;
            }

            $row->save();

            if ($id) {
                return response()->json(['success' => true, "data" => $row]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function edit($id) {
        $suppliers = Category::Find($id);
        return response()->json($suppliers);
    }

    public function update(Request $request, $id) {
        $category = Category::FindOrFail($id);
        $input = $request->all();
        dd($input);
        $result = $category->fill($input)->save();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroy($id) {
        $category = Category::FindOrFail($id);
        $result = $category->delete();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

}
