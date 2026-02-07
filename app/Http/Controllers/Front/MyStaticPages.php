<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Email;
use App\Http\Controllers\globalHelper\globalHelper;
use Config;

class MyStaticPages extends Controller
{
    public function __construct()
    {

    }
    
    public function homepage()
    {
        echo 'esklep';
    }
    
    public function regulaminPage(){
        $viewData = [];
        
        return view('front/regulamin',$viewData);
    }
    
    public function politykaPrywatnosciPage(){
        $viewData = [];
        
        return view('front/polityka-prywatnosci',$viewData);
    }
    
    public function kontaktPage(){
       $viewData = [];
        
        return view('front/kontakt',$viewData); 
    }
    
}