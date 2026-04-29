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
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public function __construct()
    {

    }
    

    
    public function showCategoryPage(Request $request, $url){
        $viewData = [];
        $requestData = $request->all();
        
        $url = preg_replace("/[^a-zA-Z0-9\-]+/", "", $url);
        
        $sortBy = '';
        $sortyByGetParam = '';
        $searchSortBy = '';
        if (isset($requestData['sort-by'])){
            $sortBy = preg_replace("/[^a-zA-Z0-9\-]+/", "", $requestData['sort-by']);
            $sortyByGetParam = '&sort-by=' . $sortBy;
            switch ($sortBy) {
                case 'price-asc':
                    $searchSortBy = ' ORDER BY ecommerce_products.price ASC ';
                    break;
                case 'price-desc':
                    $searchSortBy = ' ORDER BY ecommerce_products.price DESC ';
                    break;
                case 'alphabetically-asc':
                    $searchSortBy = ' ORDER BY ecommerce_products.name ASC ';
                    break;
                case 'alphabetically-desc':
                    $searchSortBy = ' ORDER BY ecommerce_products.name DESC ';
                    break;
            }
            
        }
        
        $viewData['sortyByGetParam'] = $sortyByGetParam;
        $viewData['sortBy'] = $sortBy;

        $category = DB::connection('mysql-esklep')->select('SELECT ecommerce_categories.* FROM ecommerce_categories '
                . ' WHERE slug = ?', [$url]);

        $pageNumber = 1;
        if (isset($requestData['page'])){
            $pageNumber = intval( $requestData['page']);
        }
        $productsPerPage = 40;
        
        if (count($category) > 0){
            $offset = ($pageNumber - 1) * $productsPerPage;
            $viewData['category'] = $category[0];
            
            $products = DB::connection('mysql-esklep')->select('SELECT DISTINCT ecommerce_products.*, image.image_name as image_name FROM ecommerce_products '
                . ' LEFT JOIN (
                    SELECT 
                      ecommerce_product_images.product_id, 
                      MAX(ecommerce_product_image.image_name) AS image_name
                    FROM 
                      ecommerce_product_images
                    LEFT JOIN ecommerce_product_image 
                      ON ecommerce_product_images.product_image_id = ecommerce_product_image.id
                    GROUP BY 
                      ecommerce_product_images.product_id
                    ) AS image ON ecommerce_products.id = image.product_id
                    LEFT JOIN ecommerce_products_categories 
                      ON ecommerce_products_categories.product_id = ecommerce_products.id '
                . ' WHERE ecommerce_products_categories.category_id = ? '

                . $searchSortBy     
                . ' LIMIT '.$productsPerPage.' OFFSET '.$offset.' '  , [$category[0]->id]);
            
            $allProductsInCategoryCount = DB::connection('mysql-esklep')->select('SELECT DISTINCT COUNT(*) AS total_products_in_category
                FROM ecommerce_products_categories
                WHERE category_id = ?',[$category[0]->id]);
            
            $viewData['allProductsInCategoryCount'] = intval($allProductsInCategoryCount[0]->total_products_in_category);
            $viewData['productsStartFor'] = ($pageNumber - 1) * $productsPerPage + 1;
            $viewData['productsEndFor'] = ($pageNumber) * $productsPerPage;
            if ($viewData['productsEndFor'] > $viewData['allProductsInCategoryCount']){
                $viewData['productsEndFor'] = $viewData['allProductsInCategoryCount'];
            }
            
            $allPagesCount = ceil($viewData['allProductsInCategoryCount'] / $productsPerPage);
            $viewData['allPagesCount'] = $allPagesCount;
            $viewData['currentPage'] = $pageNumber;
            
            
            $startPaginationNumber = $pageNumber - 1;
            if ($startPaginationNumber < 1){
                $startPaginationNumber = 1;
            }
            $viewData['startPaginationNumber'] = $startPaginationNumber;
            
            $finishPaginationNumber = $pageNumber + 1;
            if ($finishPaginationNumber > $allPagesCount){
                $finishPaginationNumber = $allPagesCount;
            }
            $viewData['finishPaginationNumber'] = $finishPaginationNumber;
            
            
            $viewData['breadCrumbsCategories'] = $this->getCategiesTreesFromCategoryId($category[0]->id,true);
            
            
            
            $viewData['products'] = $products;
            
            return view('product.category-page',$viewData);
        } else {
            return abort(404);
        }
        
        
    }
    
    public function getCategiesTreesFromCategoryId($id, $getOnlyOneLongest = false){
        
        $cacheKey = 'categories_tree_form_' . $id;
        if ($getOnlyOneLongest){
            $cacheKey = $cacheKey . '_only_one';
        }
        
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
            
        } else {

            $categories = [];

                $firstCat = DB::connection('mysql-esklep')->select('SELECT * FROM ecommerce_categories WHERE id = ? ',[$id]);
                $categories[] = $firstCat[0];

                while (count($firstCat) > 0 && $firstCat[0]->parent_id != null){
                    $firstCat = DB::connection('mysql-esklep')->select('SELECT * FROM ecommerce_categories WHERE id = ? ',[$firstCat[0]->parent_id]);
                    if (count($firstCat) > 0){
                        $categories[] = $firstCat[0];
                    }
                }


            if (count($categories)<1){
                return [];
            }
            $categoriesArray = [];
            foreach ($categories as $category){
                if ($category->parent_id == null){
                    $categoriesArray[] = [
                        'category' => $category,
                        'depth' => 1,
                        'childs' => []
                    ];
                }
            }

            foreach ($categoriesArray as $i => $category){
                $parentId = $category['category']->id;
                $thiCat = & $categoriesArray[$i];
                do {
                    $child = $this->findChild($parentId, $categories);
                    if ($child != null){
                        $parentId = $child->id;
                        $categoriesArray[$i]['depth']++;
                        $thiCat['childs'] = [
                            'category' => $child,
                            'childs' => []
                        ];
                        $thiCat =& $thiCat['childs'];
                    } 
                } while ($child != null);
            }

            if ($getOnlyOneLongest){
                $toReturn = [];
                $longest = 0;
                foreach ($categoriesArray as $cat){
                    if ($cat["depth"] > $longest){
                        $toReturn = $cat;
                        $longest = $cat["depth"];
                    }
                }
                $toReturnFlatArray = [];
                if (count($toReturn) > 0){
                    $toReturnFlatArray[] = $toReturn["category"];
                    $iterateCat = $toReturn;
                    do{
                        if (isset($iterateCat["childs"]["category"])){
                            $toReturnFlatArray[] = $iterateCat["childs"]["category"];
                            $iterateCat = $iterateCat["childs"];
                        }
                    } while(count($iterateCat["childs"]) > 0);
                }
                Cache::put($cacheKey, $toReturnFlatArray, 60 * 60 * 24 * 3 );
                return $toReturnFlatArray;
            }
            Cache::put($cacheKey, $categoriesArray, 60 * 60 * 24 * 3 );
            return $categoriesArray;
        }
    }
    
    private function findChild($parentId, $categories){
        foreach ($categories as $category){
            if ($category->parent_id == $parentId){
                return $category;
            }
        }
        return null;
    }
    
    
    
}
