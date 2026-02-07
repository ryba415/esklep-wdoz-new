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

class SearchController extends Controller
{
    public function showSearchresults(Request $request){
        $viewData = [];
        $requestData = $request->all();
        
        $condition = preg_replace("/[^a-zA-Z0-9ęĘóÓąĄłŁżŻźŹćĆ\-\.\,\\ ]+/", "", $requestData['query']);
        $conditionRemember = $condition;
        
        $sortBy = 'best-sort';
        $sortOrder = '';

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
        $productsPerPage = 40;
        
        $offset = ($pageNumber - 1) * $productsPerPage;
        
        
        $columnNames = ['name','active_substance','search_tags'];
        
        $ordString = $this->getOrderConditions($condition,$columnNames);
        $conditionString = $this->getSearchConditions($condition,$columnNames);

        $products = $this->searchProducts($ordString,$conditionString,$productsPerPage,$offset,$searchSortBy);
        
        if (count($products) < 5){
            $columnNames = ['name','active_substance','action','indication','search_tags'];
            $ordString = $this->getOrderConditions($condition,$columnNames);
            $conditionString = $this->getSearchConditions($condition,$columnNames);
            $products = $this->searchProducts($ordString,$conditionString,$productsPerPage,$offset,$searchSortBy);
        }
        
        if (count($products) < 5){
            $columnNames = ['name','active_substance','action','indication','brand','search_tags'];
            $ordString = $this->getOrderConditions($condition,$columnNames);
            $conditionString = $this->getSearchConditions($condition,$columnNames);
            $products = $this->searchProducts($ordString,$conditionString,$productsPerPage,$offset,$searchSortBy);
        }
        
        if (count($products) < 5){
            $columnNames = ['name','active_substance','action','indication','brand','composition','search_tags'];
            $ordString = $this->getOrderConditions($condition,$columnNames);
            $conditionString = $this->getSearchConditions($condition,$columnNames);
            $products = $this->searchProducts($ordString,$conditionString,$productsPerPage,$offset,$searchSortBy);
        }

        $viewData['products'] = $products;

        $allProductsInCategoryCount = DB::connection('mysql-esklep')->select('SELECT
            COUNT(*) AS total_products_in_category
            
            FROM ( SELECT
            p.id FROM ecommerce_products p' .
            $conditionString . ') AS sub');   //$ordString .    MAX(ORD) AS example_priority
        $viewData['allProductsInCategoryCount'] = intval($allProductsInCategoryCount[0]->total_products_in_category);    
        $viewData['productsStartFor'] = ($pageNumber - 1) * $productsPerPage + 1;
        if ($viewData['allProductsInCategoryCount'] < ($pageNumber) * $productsPerPage){
            $viewData['productsEndFor'] = $viewData['allProductsInCategoryCount'];    
        } else {
            $viewData['productsEndFor'] = ($pageNumber) * $productsPerPage;    
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
            
        
        
        $breadCrumb = new \stdClass();
        $breadCrumb->slug = '/search?query=' . $condition;
        
        if ($condition == 'all-special-products1'){
            $condition = 'Oferta Specjalna';
        }
        if ($condition == 'all-bestseller-products1'){
            $condition = 'Bestsellery';
        }
        if ($condition == 'all-bestseller-products2'){
            $condition = 'Produkty z krótką datą';
        }
        
        $breadCrumb->name = ' Wyniki wyszukiwania: ' . $condition;
        $viewData['breadCrumbsCategories'] = [$breadCrumb];
        
        
        
        $searchcategory = new \stdClass();
        $searchcategory->slug = '/search?query=' . $conditionRemember;
        $searchcategory->lvl = 0;
        $searchcategory->id = 0;
        $searchcategory->name = 'Wyniki wyszukiwania: ' . $condition;
        $viewData['category'] = $searchcategory;
        $viewData['isSearch'] = true;
            
        return view('product.category-page',$viewData);
        
        
    }
    
    private function getOrderConditions($condition,$areasArray){
        $licz = 0;
        $ordString = " (CASE " ;
        foreach($areasArray  as $columnName){
            $licz++;
            $nuber = $licz * 20; 
            $numberSet = $nuber + 1;
            $ordString = $ordString . " WHEN (p.".$columnName." LIKE '".$condition." %' AND p.availability > 0 AND p.availability IS NOT NULL ) THEN ". $numberSet . ' ';
            $numberSet = $nuber + 2;
            $ordString = $ordString . " WHEN (p.".$columnName." LIKE '% ".$condition." %' AND p.availability > 0 AND p.availability IS NOT NULL ) THEN ". $numberSet . ' ';
            $numberSet = $nuber + 3;
            $ordString = $ordString . " WHEN (p.".$columnName." LIKE '% ".$condition."%' AND p.availability > 0 AND p.availability IS NOT NULL ) THEN ". $numberSet . ' ';
            $numberSet = $nuber + 3;
            $ordString = $ordString . " WHEN (p.".$columnName." LIKE '".$condition."%' AND p.availability > 0 AND p.availability IS NOT NULL ) THEN ". $numberSet . ' ';
            $numberSet = $nuber + 4;
            $ordString = $ordString . " WHEN (p.".$columnName." LIKE '%".$condition."' AND p.availability > 0 AND p.availability IS NOT NULL ) THEN ". $numberSet . ' ';
            $numberSet = $nuber + 6;
            $ordString = $ordString . " WHEN (p.".$columnName." LIKE '%".$condition." %' AND p.availability > 0 AND p.availability IS NOT NULL ) THEN ". $numberSet . ' ';

        }
        $ordString = $ordString . ' ELSE 99999 END  ) AS ORD';

        $ordString = $ordString . " FROM ecommerce_products as p ";
        
        
        return $ordString;
    }
    
    private function getSearchConditions($condition,$areasArray){
        $conditionString = '';
        $conditionString = $conditionString . " WHERE p.is_active = 1 AND (";
        
        $specjalSearch = false;
        if ($condition == 'all-special-products1'){
            $conditionString = $conditionString . ' is_special_offer = 1 ';
            $specjalSearch = true;
        }
        if ($condition == 'all-bestseller-products1'){
            $conditionString = $conditionString . ' is_bestseller = 1 ';
            $specjalSearch = true;
        }
        if ($condition == 'all-bestseller-products2'){
            $conditionString = $conditionString . ' is_bestseller2 = 1 ';
            $specjalSearch = true;
        }
        if (!$specjalSearch){
            foreach($areasArray  as $i => $columnName){
                if ($i > 0){
                    $conditionString = $conditionString . ' OR ';
                }
                $conditionString = $conditionString . " p." . $columnName . " LIKE '% ".$condition."%'";

                $conditionString = $conditionString . ' OR ';
                $conditionString = $conditionString . " p." . $columnName . " LIKE '%".$condition." %'";

                $conditionString = $conditionString . ' OR ';
                $conditionString = $conditionString . " p." . $columnName . " LIKE '% ".$condition." %'";

                $conditionString = $conditionString . ' OR ';
                $conditionString = $conditionString . " p." . $columnName . " LIKE '".$condition."'";

                $conditionString = $conditionString . ' OR ';
                $conditionString = $conditionString . " p." . $columnName . " LIKE '".$condition."%'";

                $conditionString = $conditionString . ' OR ';
                $conditionString = $conditionString . " p." . $columnName . " LIKE '%".$condition."'";

            }
        }
        $conditionString = $conditionString . " ) ";
        
        return $conditionString;
    }
    
    private function searchProducts($ordString,$conditionString,$productsPerPage,$offset,$order){
        
        if ($order == '' || $order == null){
            $order = ' ORDER BY ORD ';
        }
        $products = DB::connection('mysql-esklep')->select("SELECT p.*, image.image_name as image_name, " 
                . $ordString 
                . ' LEFT JOIN ecommerce_product_images ON ecommerce_product_images.product_id = p.id'
                . ' LEFT JOIN ecommerce_product_image as image ON ecommerce_product_images.product_image_id = image.id'
                . $conditionString
                . $order .' LIMIT '.$productsPerPage.' OFFSET '.$offset.' ');
        
        return $products;
    }
    
   
}
