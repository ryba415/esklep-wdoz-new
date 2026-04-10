<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Email;
use App\Models\Products;
use App\Http\Controllers\globalHelper\globalHelper;
use Config;

use App\Http\Controllers\Cms\TableList;
use App\Http\Controllers\Cms\TableEdit;

class AdminDashboard extends Controller
{
    public function __construct()
    {

    }



    public function showDashboard(Request $request){
        //phpinfo();
//        dd([
//            'gd_loaded' => extension_loaded('gd'),
//            'imagewebp' => function_exists('imagewebp'),
//            'imagecreatefromjpeg' => function_exists('imagecreatefromjpeg'),
//            'imagecreatefrompng' => function_exists('imagecreatefrompng'),
//            'gd_info' => function_exists('gd_info') ? gd_info() : null,
//        ]);
        return view('admin.dashboard');
    }

    public function slidersList(Request $request){
        $list = new TableList('AdminSliders');

        return $list->render($request);
    }

    public function editSlide($id){
        $edit = new TableEdit('AdminSliders');

        return $edit->render($id);
    }

}
