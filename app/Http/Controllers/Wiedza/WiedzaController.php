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
        
        $requestData = $request->all();
        
        $articlesCount = DB::connection('mysql-esklep')->select('SELECT COUNT(*) as count FROM article ',[]);
        $articlesCount = intval($articlesCount[0]->count);
        $articlesOnPage = 24;
        $viewData['allPagesCount'] = ceil($articlesCount/$articlesOnPage);
        
        if (isset($requestData['page']) && intval($requestData['page']) > 0){
            $currentPage = intval($requestData['page']);
        } else {
            $currentPage = 1;
        }
        $viewData['currentPage'] = $currentPage;
        
        $startPaginationNumber = $currentPage - 1;
        if ($startPaginationNumber < 1){
            $startPaginationNumber = 1;
        }
        $viewData['startPaginationNumber'] = $startPaginationNumber;
        
        $finishPaginationNumber = $currentPage + 1;
            if ($finishPaginationNumber > $viewData['allPagesCount']){
                $finishPaginationNumber = $allPagesCount;
            }
            $viewData['finishPaginationNumber'] = $finishPaginationNumber;
        
        $offset = ($currentPage - 1) * $articlesOnPage;
        
        $category = new \stdClass();
        $category->slug = '/wiedza-farmaceutyczna/';
        $viewData['category'] = $category;
                
        $articles = DB::connection('mysql-esklep')->select('SELECT article.*, media__media.provider_reference as image_name, article_category.title as category'
                . ' FROM article '
                . ' LEFT JOIN media__media ON media__media.id = article.media_id'
                . ' LEFT JOIN article_category ON article_category.id = article.article_category_id '
                . ' ORDER BY id DESC LIMIT ' . $articlesOnPage . ' OFFSET ' . $offset . ' ', []);
        $viewData['articles'] = $articles;
        return view('pages.wiedza-list',$viewData);
    }
    
    public function showArticle(Request $request, $slug){
        $viewData = [];
        $article = DB::connection('mysql-esklep')->select('SELECT article.*, media__media.provider_reference as image_name, article_category.title as category, article_category.slug as categorySlug'
                . ' FROM article '
                . ' LEFT JOIN media__media ON media__media.id = article.media_id'
                . ' LEFT JOIN article_category ON article_category.id = article.article_category_id '
                . ' WHERE article.slug = ?', [$slug]);
        if (count($article) > 0){
            $viewData['article'] = $article[0];

            $viewData['breadCrumbsCategories'] = [];
            /*if ($article->category != null &&  $article->category !=''){
                $cat = new \stdClass();
                $cat->slug = $article->categorySlug;
                $cat->name = $article->category;
                $viewData['breadCrumbsCategories'][] = $cat;
            }*/
            $bread = new \stdClass();
            $bread->slug = '/wiedza-farmaceutyczna/';
            $bread->name = 'Wiedza Farmaceutyczna';
            $viewData['breadCrumbsCategories'][] = $bread;
            
            $bread = new \stdClass();
            $bread->slug = '/wiedza-farmaceutyczna/' . $article[0]->slug;
            $bread->name = $article[0]->title;
            $viewData['breadCrumbsCategories'][] = $bread;
            return view('pages.wiedza-article',$viewData);
        } else {
            abort(404);
        }
    }
    
    
    
    
    
}
