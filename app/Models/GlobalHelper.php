<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use \stdClass;

class GlobalHelper
{
    
    public static function getMenuTree(){
        
        $cacheKey = 'menu_tree_array';
        
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
            
        } else {
            $categoriesArray = [];

            $categories = DB::connection('mysql-esklep')->select('SELECT id,parent_id,name,lft,lvl,rgt,root,position,is_active,show_in_menu,slug,icon,color '
                    . ' '
                    . ' FROM ecommerce_categories '
                    . ' WHERE show_in_menu = 1 AND is_active = 1 AND parent_id is null ORDER BY position', []); //AND show_in_menu_lvl_0 = 1 


            foreach ($categories as $category){
                $categoriesArray[0][$category->id] = $category;
                            if (file_exists(public_path('/images/category-icons'). '/'. $category->icon) && $category->icon != '' && $category->icon != null){
                                    $categoriesArray[0][$category->id]->icon = file_get_contents(public_path('/images/category-icons'). '/'. $category->icon);
                            }
                            if($category->color != '' && $category->color != null){
                                    $categoriesArray[0][$category->id]->color = $category->color;
                            } else {
                                    $categoriesArray[0][$category->id]->color = '#d8f0e0';
                            }
            }
            for ($lv=1;$lv<6;$lv++){
                $categoriesLv = DB::connection('mysql-esklep')->select('SELECT id,parent_id,name,lft,lvl,rgt,root,position,is_active,show_in_menu,slug '
                        . ' '
                        . ' FROM ecommerce_categories '
                        . ' WHERE show_in_menu = 1 AND is_active = 1 AND lvl = ?', [$lv]);

                foreach ($categoriesLv as $category){
                    $categoriesArray[$lv][$category->id] = $category;
                }
            }

            $extraCategory = new \stdClass();
            $extraCategory->name = 'Wiedza';
            $extraCategory->id = 9999991;
            $extraCategory->slug = 'wiedza-farmaceutyczna/';
            $categoriesArray[0][9999991] = $extraCategory;
                    $categoriesArray[0][9999991]->color = '#e2efd0';
                    if (file_exists(public_path('/images/category-icons'). '/wiedza.svg')){
                            $categoriesArray[0][9999991]->icon = file_get_contents(public_path('/images/category-icons'). '/wiedza.svg');//'<svg xmlns="http://www.w3.org/2000/svg" class="aspect-[1] object-contain w-[52px] self-stretch my-auto" viewBox="0 0 52 52"><path d="M24.07 12.364c3.636-.528 7.029 1.149 8.012 4.813 1.068 3.977-2.183 5.956-2.825 9.069-.22 1.07.062 2.438-.05 3.555-.502 5.033-6.912 5.033-7.416 0-.113-1.119.169-2.48-.05-3.554-.41-1.998-3.036-4.88-3.114-7.277-.096-2.935 2.496-6.178 5.443-6.606Zm3.02 13.728 1.168-.209c1.323-3.707 4.886-6.885 1.584-10.707-3.475-4.02-10.785-1.08-10.09 4.135.133 1 1.928 4.458 2.491 5.584.392.785.557 1.562 1.668 1.09l-.845-3.914.637-.125c.812.52.902 4.15 1.795 4.15.435 0 .403-.24.527-.538.299-.719.67-3.338 1.27-3.612l.637.125-.841 4.02Zm1.06 1.061h-5.302c.026.457-.182 1.28.348 1.455l4.861-.169.093-1.286Zm-4.984 2.333c-.899.7.503 2.518 1.221 2.808 1.184.479 2.513.16 3.223-.91.23-.348.884-1.898.222-1.898h-4.666ZM20.469 8.751c.19.25 1.182 2.954.574 3.132-.874.256-1.602-2.53-1.583-3.173.282-.085.806-.224 1.009.041ZM31.538 8.71c.018.645-.71 3.43-1.583 3.173-.608-.178.384-2.882.575-3.132.203-.265.727-.126 1.008-.04ZM25.29 7.433c1.165-.37.853 3.252.42 3.39-1.167.37-.855-3.252-.42-3.39Z"/><path d="m27.346 49.925-3.688-2.752-3.688 2.752v-9.24h7.376v9.24z" style="fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:1.2px"/><path d="M19.706 44.727h-5.748a4.396 4.396 0 0 1-4.397-4.396V7.266a4.596 4.596 0 0 1 4.596-4.596H41.32c.618 0 1.12.502 1.12 1.12v39.817a1.12 1.12 0 0 1-1.12 1.12H27.346" style="fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:1.2px"/><path d="M9.614 4.073h32.772c.668 0 1.21.543 1.21 1.211v26.913a4.756 4.756 0 0 1-4.753 4.753h-25.47a4.972 4.972 0 0 1-4.97-4.969V5.284c0-.668.543-1.21 1.211-1.21Z" data-name="krotkie_daty" style="fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:1.2px" transform="rotate(90 26 20.512)"/><path d="M42.439 40.685H15.891" style="fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:1.2px"/></svg>';
            }

            Cache::put($cacheKey, $categoriesArray, 60 * 60 * 24 );
            return $categoriesArray;
        }
        
        
    }
    
    public static function diplayPrice($price){
        return number_format(floatval($price), 2,',',' ');
    }
    
}
