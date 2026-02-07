<?php

namespace App\Http\Controllers\Wiedza;

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

class WiedzaController extends Controller
{
    public function __construct()
    {

    }

    public function showList(Request $request){
        $viewData = [];

        $articles = DB::connection('mysql-esklep')->select('SELECT article.*, media__media.provider_reference as image_name FROM article '
                . ' LEFT JOIN media__media ON media__media.id = article.media_id'
                . ' ORDER BY id DESC LIMIT 80', []);
        $viewData['articles'] = $articles;
        return view('pages.wiedza-list',$viewData);
    }
    
    
    
    
    
}
