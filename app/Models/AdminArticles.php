<?php

namespace App\Models;

use App\Services\Cms\AdminArticlesSaveService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminArticles extends CmsObject
{
    public $objectName = 'AdminArticles';
    public $dbTableName = 'article';
    public $listName = 'Lista artykułów';
    public $editItemUrl = 'panel/articles/article';
    public $addNewItemButtonName = 'Dodaj artykuł';

    public $breadCrub1 = [
        'url' => '/panel/articles/',
        'name' => 'artykuły'
    ];

    public $breadCrub2 = [
        'url' => '/panel/articles/article-new',
        'name' => 'artykuł'
    ];

    public $areas = [];

    public function __construct()
    {
        parent::__construct();
        $this->areas = $this->buildAreas([], false);
    }

    public function renderList($objectName, $request = [], $extraView = '')
    {
        $this->areas = $this->buildAreas([], false);
        return parent::renderList($objectName, $request, $extraView);
    }

    public function renderEdit($id)
    {
        $selectedProductIds = [];

        if ($id !== 'new') {
            $selectedProductIds = DB::connection('mysql-esklep')
                ->table('article_products')
                ->where('article_id', $id)
                ->pluck('product_id')
                ->map(function ($id) {
                    return (int)$id;
                })
                ->toArray();
        }

        $this->areas = $this->buildAreas($selectedProductIds, true);

        return parent::renderEdit($id);
    }

    public function ownSaveAction(Request $request, $postData = [])
    {
        return app(AdminArticlesSaveService::class)->save($request, $this);
    }

    public function ownDeleteAction($itemId): void
    {
        DB::connection('mysql-esklep')
            ->table('article_products')
            ->where('article_id', $itemId)
            ->delete();
    }

    private function buildAreas(array $selectedProductIds = [], bool $includeProducts = true): array
    {
        $categoryOptions = ['' => 'Wybierz kategorię'];

        $categories = DB::connection('mysql-esklep')
            ->table('article_category')
            ->orderBy('position', 'asc')
            ->orderBy('title', 'asc')
            ->get(['id', 'title']);

        foreach ($categories as $category) {
            $categoryOptions[$category->id] = $category->title;
        }

        $productOptions = [];
        if ($includeProducts) {
            $products = DB::connection('mysql-esklep')
                ->table('ecommerce_products')
                ->orderBy('name', 'asc')
                ->get(['id', 'name']);

            foreach ($products as $product) {
                $productOptions[$product->id] = $product->name;
            }
        }

        return [
            [
                'name' => 'Tytuł',
                'type' => 'text',
                'field' => 'title',
                'editable' => true,
                'onList' => true,
                'onFilter' => true,
                'validations' => [
                    'require' => true,
                    'nimLength' => 2,
                    'maxLength' => 255,
                ]
            ],
            [
                'name' => 'Adres URL',
                'type' => 'seoUrl',
                'field' => 'seo_url',
                'editable' => true,
                'onList' => true,
                'onFilter' => true,
                'validations' => [
                    'require' => true,
                    'maxLength' => 255,
                ],
            ],
            [
                'name' => 'SEO title',
                'type' => 'text',
                'field' => 'seo_title',
                'editable' => true,
                'onList' => false,
                'onFilter' => false,
                'validations' => [
                    'require' => false,
                    'maxLength' => 255,
                ]
            ],
            [
                'name' => 'SEO description',
                'type' => 'text',
                'field' => 'seo_description',
                'editable' => true,
                'onList' => false,
                'onFilter' => false,
                'validations' => [
                    'require' => false,
                    'maxLength' => 255,
                ]
            ],
            [
                'name' => 'Obrazek',
                'type' => 'image',
                'field' => 'img_name',
                'editable' => true,
                'onList' => true,
                'onFilter' => false,
                'multiple' => false,
                'uploadPath' => '/uploads/media/articles/',
                'allowedExtensions' => ['jpg', 'jpeg', 'png', 'webp'],
                'maxSizeMb' => 10,
                'validations' => [
                    'require' => false,
                ],
                'info' => 'Dozwolone formaty: jpg, jpeg, png, webp'
            ],
            [
                'name' => 'Wprowadzenie',
                'type' => 'textarea',
                'field' => 'lead',
                'editable' => true,
                'onList' => false,
                'onFilter' => false,
                'validations' => [
                    'require' => false,
                ]
            ],
            [
                'name' => 'Opis',
                'type' => 'textarea',
                'field' => 'content',
                'editable' => true,
                'onList' => false,
                'onFilter' => false,
                'validations' => [
                    'require' => false,
                ]
            ],
            [
                'name' => 'Data publikacji',
                'type' => 'date',
                'field' => 'publish_date',
                'editable' => true,
                'onList' => true,
                'onFilter' => false,
                'validations' => [
                    'require' => true,
                ]
            ],
            [
                'name' => 'Kolejność wyświetlania',
                'type' => 'number',
                'field' => 'position',
                'editable' => true,
                'onList' => true,
                'onFilter' => false,
                'validations' => [
                    'require' => false,
                    'maxLength' => 11,
                ]
            ],
            [
                'name' => 'Kategoria',
                'type' => 'select',
                'field' => 'article_category_id',
                'editable' => true,
                'onList' => false,
                'onFilter' => false,
                'options' => $categoryOptions,
                'validations' => [
                    'require' => true,
                ]
            ],
            [
                'name' => 'Czy aktywny',
                'type' => 'select',
                'field' => 'isActive',
                'editable' => true,
                'onList' => true,
                'onFilter' => false,
                'options' => [
                    '' => 'Wybierz',
                    '1' => 'Tak',
                    '0' => 'Nie',
                ],
                'validations' => [
                    'require' => true,
                ]
            ],
            [
                'name' => 'Produkty powiązane z artykułem',
                'type' => 'selectWithSearchMultiple',
                'field' => 'article_products',
                'editable' => true,
                'onList' => false,
                'onFilter' => false,
                'saveToMainTable' => false,
                'options' => $productOptions,
                'selectedOptions' => $selectedProductIds,
                'validations' => [
                    'require' => false,
                ]
            ],
        ];
    }
}
