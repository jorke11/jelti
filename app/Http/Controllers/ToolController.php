<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToolController extends Controller {

    public function index() {

        $path = public_path() . '/images/resize';

        $this->readFile($path);
    }

    public function readFile($path) {
        $archivo = '';
        if (is_dir($path)) {

            if ($aux = opendir($path)) {

                while (($archivo = readdir($aux)) !== false) {

                    if ($archivo != '.' && $archivo != '..' && $archivo[0] != '.') {
                        echo $archivo . "<br>";
                        $this->readFile($path . "/" . $archivo);
                    }
                }
//                return "asdsa";
//                exit;
            }
        }
    }

}
