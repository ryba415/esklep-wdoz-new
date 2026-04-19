<?php

namespace App\Models;

use App\Services\Cms\AdminArticlesCategorySaveService;
use Illuminate\Http\Request;

class AdminArticlesCategory extends CmsObject
{
    public $objectName = 'AdminArticlesCategory';
    public $dbTableName = 'article_category';
    public $listName = 'Lista kategorii artykułów';
    public $editItemUrl = 'panel/articlesCategory/article';
    public $addNewItemButtonName = 'Dodaj kategorię artykułu';

    public $breadCrub1 = [
        'url' => '/panel/articlesCategory/',
        'name' => 'kategorie artykułów'
    ];

    public $breadCrub2 = [
        'url' => '/panel/articlesCategory/article-new',
        'name' => 'kategoria artykułu'
    ];

    public $areas = [
        [
            'name' => 'Nazwa kategorii',
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
            'name' => 'Kolejność wyświetlania',
            'type' => 'number',
            'field' => 'position',
            'editable' => true,
            'onList' => true,
            'onFilter' => true,
            'validations' => [
                'require' => false,
                'maxLength' => 11,
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
    ];

    public function ownSaveAction(Request $request, $postData = [])
    {
        return app(AdminArticlesCategorySaveService::class)->save($request, $this);
    }
}
