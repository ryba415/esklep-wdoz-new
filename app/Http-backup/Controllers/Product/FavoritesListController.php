<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Product\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Email;
use App\Models\Products;
use App\Http\Controllers\globalHelper\globalHelper;
use Config;
use \stdClass;

class FavoritesListController extends Controller
{
    public function showList(Request $request){
        
        $sortBy = 'best-sort';
        $sortOrder = '';
        $requestData = $request->all();

        $searchSortBy = null;
        if (isset($requestData['sort-by'])){
            $sortBy = preg_replace("/[^a-zA-Z0-9\-]+/", "", $requestData['sort-by']);
            switch ($sortBy) {
                case 'best-sort':
                    $searchSortBy = null;
                    break;
                case 'price-asc':
                    $searchSortBy = ' ORDER BY p.price ASC ';
                    break;
                case 'price-desc':
                    $searchSortBy = ' ORDER BY p.price DESC ';
                    break;
                case 'alphabetically-asc':
                    $searchSortBy = ' ORDER BY p.name ASC ';
                    break;
                case 'alphabetically-desc':
                    $searchSortBy = ' ORDER BY p.name DESC ';
                    break;
            }
            
        }
        

        $viewData['sortBy'] = $sortBy;
        
        $pageNumber = 1;
        $productsPerPage = 240;
        
        $offset = ($pageNumber - 1) * $productsPerPage;
        
        
        $columnNames = ['name','active_substance','search_tags'];
        
        $favoritesIds = null;
        if (isset($_COOKIE['favorites-items']) && is_string($_COOKIE['favorites-items'])){
            $favoritesIds = json_decode($_COOKIE['favorites-items']);
        }

        if ($favoritesIds != null){
            $products = DB::connection('mysql-esklep')->select("SELECT p.*, image.image_name as image_name FROM  ecommerce_products as p " 
                    . ' LEFT JOIN ecommerce_product_images ON ecommerce_product_images.product_id = p.id'
                    . ' LEFT JOIN ecommerce_product_image as image ON ecommerce_product_images.product_image_id = image.id'
                    . ' WHERE p.id IN ( ' . implode(", ",$favoritesIds) . ' ) '
                    . $searchSortBy . ' LIMIT '.$productsPerPage.' OFFSET '.$offset.' ');
        } else {
            $products = [];
        }

        $viewData['products'] = $products;

        $viewData['allProductsInCategoryCount'] = count($products);    
        $viewData['productsStartFor'] = ($pageNumber - 1) * $productsPerPage + 1;
        if ($viewData['allProductsInCategoryCount'] < ($pageNumber) * $productsPerPage){
            $viewData['productsEndFor'] = $viewData['allProductsInCategoryCount'];    
        } else {
            $viewData['productsEndFor'] = ($pageNumber) * $productsPerPage;    
        }
        
        $allPagesCount = ceil($viewData['allProductsInCategoryCount'] / $productsPerPage);
        $viewData['allPagesCount'] = $allPagesCount;
        $viewData['currentPage'] = $pageNumber;   
            
        
        
        $breadCrumb = new \stdClass();
        $breadCrumb->slug = '/favorites-list';

        
        $breadCrumb->name = ' Lista ulubionych ';
        $viewData['breadCrumbsCategories'] = [$breadCrumb];
        
        
        
        $searchcategory = new \stdClass();
        $searchcategory->lvl = 0;
        $searchcategory->id = 0;
        $searchcategory->name = ' Lista ulubionych ';
        $viewData['category'] = $searchcategory;
        $viewData['isSearch'] = true;
        
        return view('product.category-page',$viewData);
    }
    
   
}
