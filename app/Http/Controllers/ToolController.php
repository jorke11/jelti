<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;

class ToolController extends Controller {

    public function index() {
        $this->readFile();
    }

    public function readFile() {

        $list = shell_exec('find  ' . public_path() . '/images/resize/ -name "*.png"');
        $list = explode("\n", $list);



        foreach ($list as $value) {
            if (is_file($value)) {
                $manager = new ImageManager(array('driver' => 'imagick'));

// to finally create image instances
                $image = $manager->make($value)->resize(300, 200);
            }
        }
    }

}
