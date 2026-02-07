<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Controllers\globalHelper\globalHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Email;
use Config;

class BlogController extends Controller
{
    public function __construct()
    {

    }

    
    public function listPage(){
       $viewData = [];
        
        return view('blog/list',$viewData); 
    }
}
