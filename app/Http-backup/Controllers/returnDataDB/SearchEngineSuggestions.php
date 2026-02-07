<?php

namespace App\Http\Controllers\returnDataDB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\DatabaseManager;
use Config;

class SearchEngineSuggestions extends Controller
{
    private $ids = [];
    public function __construct(
        private DatabaseManager $databaseManager,
    ) {
    }

    public function returnSuggestions(Request $request, $search)
    {

        try {
            //suggestions
            $sql1 = $this->databaseManager->connection('symfonyDatabase')->table('ecommerce_products')
                ->where('name', 'like', $search . '%')
                ->where('availability', '>', 0)
                ->where('is_active', 1)
                ->get(['id', 'name AS sugegstion'])->toArray();

            $sql2 = $this->databaseManager->connection('symfonyDatabase')->table('ecommerce_products')
                ->where('active_substance', 'like', $search . '%')
                ->where('availability', '>', 0)
                ->where('is_active', 1)
                ->get(['id', 'active_substance AS sugegstion'])->toArray();
            $data = $this->deleteDuplicates([$sql1, $sql2]);

            if ((count($data[0]) + count($data[1])) < 8) {
                $sql3 = $this->databaseManager->connection('symfonyDatabase')->table('ecommerce_products')
                    ->where('action', 'like', $search . '%')
                    ->where('availability', '>', 0)
                    ->where('is_active', 1)
                    ->get(['id', 'action AS sugegstion'])->toArray();
                array_push($data, $sql3);
            } else {
                $data[2] = [];
            }
            $data = $this->deleteDuplicates($data);

            if ((count($data[0]) + count($data[1]) + count($data[2])) < 8) {
                $sql4 = $this->databaseManager->connection('symfonyDatabase')->table('ecommerce_products')
                    ->where('composition', 'like', $search . '%')
                    ->where('availability', '>', 0)
                    ->where('is_active', 1)
                    ->get(['id', 'composition AS sugegstion'])->toArray();
                array_push($data, $sql4);
            } else {
                $data[3] = [];
            }


            $sql5 = $this->databaseManager->connection('symfonyDatabase')->table('ecommerce_categories')
                ->where('name', 'like', $search . '%')
                ->get(['id', 'name AS sugegstion'])->toArray();
            array_push($data, $sql5);
            $data = $this->deleteDuplicates($data);
            $suggestions = array_merge(array_slice($data[0], 0, 4), array_slice($data[1], 0, 4), array_slice($data[2], 0, 3), array_slice($data[3], 0, 3), array_slice($data[4], 0, 3));


            //products
            $sqlProducts1 = $this->databaseManager->connection('symfonyDatabase')->table('ecommerce_products')
                ->where('name', 'like', $search . '%')
                ->where('availability', '>', 0)
                ->where('is_active', 1)
                ->get(['id', 'slug AS linkProduct', 'name', 'brand AS description', 'content AS capacity', 'price_gross AS price', 'availability AS quantity'])->toArray();

            $sqlProducts2 = $this->databaseManager->connection('symfonyDatabase')->table('ecommerce_products')
                ->where('active_substance', 'like', $search . '%')
                ->where('availability', '>', 0)
                ->where('is_active', 1)
                ->get(['id', 'slug AS linkProduct', 'name', 'brand AS description', 'content AS capacity', 'price_gross AS price', 'availability AS quantity'])->toArray();
            $products = $this->deleteDuplicates([$sqlProducts1, $sqlProducts2]);

            if ((count($products[0]) + count($products[1])) < 8) {
                $sqlProducts3 = $this->databaseManager->connection('symfonyDatabase')->table('ecommerce_products')
                    ->where('action', 'like', $search . '%')
                    ->where('availability', '>', 0)
                    ->where('is_active', 1)
                    ->get(['id', 'slug AS linkProduct', 'name', 'brand AS description', 'content AS capacity', 'price_gross AS price', 'availability AS quantity'])->toArray();
                array_push($products, $sqlProducts3);
            } else {
                $products[2] = [];
            }
            $products = $this->deleteDuplicates($products);

            if ((count($products[0]) + count($products[1]) + count($products[2])) < 8) {
                $sqlProducts4 = $this->databaseManager->connection('symfonyDatabase')->table('ecommerce_products')
                    ->where('composition', 'like', $search . '%')
                    ->where('availability', '>', 0)
                    ->where('is_active', 1)
                    ->get(['id', 'slug AS linkProduct', 'name', 'brand AS description', 'content AS capacity', 'price_gross AS price', 'availability AS quantity'])->toArray();
                array_push($products, $sqlProducts4);
            } else {
                $products[3] = [];
            }
            $sqlProductsCategories = $this->databaseManager->connection('symfonyDatabase')->table('ecommerce_categories')
                ->where('name', 'like', $search . '%')
                ->get(['id'])->toArray();

            $prodcutsFromCategoryArray = [];
            foreach ($sqlProductsCategories as $key => $value) {
                $sqlFromCategory1 = $this->databaseManager->connection('symfonyDatabase')->table('ecommerce_products_categories')
                    ->where('category_id', $value->id)
                    ->LIMIT(1)
                    ->get(['product_id'])->toArray();
                $sqlFromCategory2 = $this->databaseManager->connection('symfonyDatabase')->table('ecommerce_products')
                    ->where('id', $sqlFromCategory1[0]->product_id)
                    ->LIMIT(1)
                    ->get(['id', 'slug AS linkProduct', 'name', 'brand AS description', 'content AS capacity', 'price_gross AS price', 'availability AS quantity'])->toArray();
                array_push($prodcutsFromCategoryArray, $sqlFromCategory2[0]);
            }
            array_push($products, $prodcutsFromCategoryArray);
            $products = $this->deleteDuplicates($products);


            $products = $this->deleteDuplicates($products);
            $productsArray = array_merge(array_slice($products[0], 0, 4), array_slice($products[1], 0, 4), array_slice($products[2], 0, 3), array_slice($products[3], 0, 3), array_slice($products[4], 0, 3));

            foreach ($productsArray as $key => $value) {
                $imageId = $this->databaseManager->connection('symfonyDatabase')->table('ecommerce_product_images')
                    ->where('product_id', $value->id)
                    ->LIMIT(1)
                    ->get(['product_image_id'])->toArray();
                if (isset($imageId[0])) {
                    $imageLink = $this->databaseManager->connection('symfonyDatabase')->table('ecommerce_product_image')
                        ->where('id', $imageId[0]->product_image_id)
                        ->LIMIT(1)
                        ->get(['image_name'])->toArray();

                    if ($imageLink[0]) {
                        $value->linkImage = "https://esklep.wdoz.pl/uploads/images/product/" . $imageLink[0]->image_name;
                    } else {
                        $value->linkImage = "https://esklep.wdoz.pl/uploads/images/product/no-image.jpg";
                    }
                } else {
                    $value->linkImage = "https://esklep.wdoz.pl/uploads/images/product/no-image.jpg";
                }

                $value->oldPrice = 0;
                $value->activePromo = 0;
                $value->linkProduct = "https://esklep.wdoz.pl/produkty/" . $value->linkProduct;
            }
        } catch (Exception $e) {
            dd($e);
        }

        $returnData = [
            "popular-phrases-number" => count($suggestions),
            "products-number" => count($productsArray),
            "popular-phrases" => $suggestions,
            "products" => $productsArray,
        ];
        return \Response::json($returnData, 200);
    }

    public function deleteDuplicates($array)
    {
        $this->ids = [];
        foreach ($array as $key => $value) {
            foreach ($value as $key2 => $value2) {

                if (in_array($value2->id, $this->ids)) {
                    unset($array[$key][$key2]);
                }
                array_push($this->ids, $value2->id);
            }
        }
        return $array;
    }
}
