<?php

namespace App\Http\Controllers\Product;

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

class ProductController extends Controller
{
    public function __construct()
    {

    }
    

    
    public function showProductPage(Request $request, $slug, $a, $b, $bloz){
        $viewData = [];
        
        $bloz = preg_replace("/[^a-zA-Z0-9]+/", "", $bloz);

        $product = DB::connection('mysql-esklep')->select('SELECT ecommerce_products.*, image.image_name as image_name FROM ecommerce_products '
                . ' LEFT JOIN ecommerce_product_images ON ecommerce_product_images.product_id = ecommerce_products.id '
                . ' LEFT JOIN ecommerce_product_image as image ON ecommerce_product_images.product_image_id = image.id'
                . ' WHERE bloz7 = ?', [$bloz]);

        //var_dump($this->getCategiesTreesFromProductId($product[0]->id,true));die();
        if (count($product) > 0){
            
            $viewData['breadCrumbsCategories'] = $this->getCategiesTreesFromProductId($product[0]->id,true);
            $viewData['product'] = $product[0];
            $viewData['isProductPage'] = true;
            
            return view('product.product-page',$viewData);
        } else {
            return abort(404);
        }
        
        
    }
    
    public function getCategiesTreesFromProductId($id, $getOnlyOneLongest = false){
        /*$categories = DB::connection('mysql-esklep')->select('WITH RECURSIVE category_tree (id, parent_id, name, slug) AS (
                SELECT c.id, c.parent_id, c.name, c.slug
                FROM ecommerce_products_categories pc
                JOIN ecommerce_categories c ON pc.category_id = c.id
                WHERE pc.product_id = ?   
                
                UNION ALL

                SELECT c.id, c.parent_id, c.name, c.slug
                FROM ecommerce_categories c
                JOIN category_tree ct ON c.id = ct.parent_id
            )
            SELECT DISTINCT id, parent_id, name, slug FROM category_tree',[$id]);
echo '<pre>';
        var_dump($categories);die();*/
        //echo '<pre>';
        $categories = [];
        $firsts = DB::connection('mysql-esklep')->select('SELECT * FROM ecommerce_products_categories WHERE product_id = ? ',[$id]);

        foreach ($firsts as $first){
            $firstCat = DB::connection('mysql-esklep')->select('SELECT * FROM ecommerce_categories WHERE id = ? ',[$first->category_id]);
            $categories[] = $firstCat[0];
            
            while (count($firstCat) > 0 && $firstCat[0]->parent_id != null){
                $firstCat = DB::connection('mysql-esklep')->select('SELECT * FROM ecommerce_categories WHERE id = ? ',[$firstCat[0]->parent_id]);
                if (count($firstCat) > 0){
                    $categories[] = $firstCat[0];
                }
            }
        }
        
        //var_dump($categories);die();
        
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
                    $toReturnFlatArray[] = $iterateCat["childs"]["category"];
                    $iterateCat = $iterateCat["childs"];
                } while(count($iterateCat["childs"]) > 0);
            }
            return $toReturnFlatArray;
        }
        return $categoriesArray;
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
