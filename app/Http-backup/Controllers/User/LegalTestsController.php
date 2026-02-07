<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\globalHelper\globalHelper;

class LegalTestsController extends Controller
{
    public function __construct()
    {
        if(!Auth::check())
        {
            return redirect()->route('login');
        } else {

        }
    }
    
    public function legalTests(Request $request, $categoryId=null){
        $viewData = [];
        
        $viewData['breadCrub1'] = [
            'url' => null,
            'name' => 'Zadania testowe'
        ];
        
        
        if ($categoryId != null){
            $currentCategory = $tasks = DB::select('select legal_tasks_categories.* from legal_tasks_categories WHERE category_id=?', [$categoryId]);
            $viewData['currentCategory'] = $currentCategory;
        }
        
        $onlyFreeTestCOndition = '';
        $onlyFreeTestCOndition2 = '';
        if(!Auth::user()->isPro()) {
            $onlyFreeTestCOndition = ' AND legal_test_questions.is_free ';
            $onlyFreeTestCOndition2 = ' WHERE legal_test_questions.is_free ';
        }
        
        
        $globalHelper = new globalHelper();
        $categories = $globalHelper->prepareCategoriesTree(2,$categoryId);
        $viewData['categories'] = $categories;
        $viewData['categoriesType'] = 2;
        $viewData['currentCategoryId'] = $categoryId;
        
        if ($categoryId != null){
            $viewData['breadCrub1']['url'] = '/legal-tests';
            $categoriesIdsToDisplay = '';
            foreach ($categories as $category){
                if ($category['category']->category_id == $categoryId){
                    $viewData['breadCrub2'] = [
                        'url' => null,
                        'name' => '' . $category['category']->name
                    ];
                    $categoriesIdsToDisplay = '' . $category['category']->category_id;
                    foreach ($category['childCategories'] as $subcategory){
                        $categoriesIdsToDisplay = $categoriesIdsToDisplay . ',' . $subcategory->category_id;
                    }
                    
                } else {
                    foreach ($category['childCategories'] as $subcategory){
                        if ($subcategory->category_id == $categoryId){
                            $viewData['breadCrub2'] = [
                                'url' => '/legal-tests/category-' . $category['category']->category_id,
                                'name' => '' . $category['category']->name
                            ];
                            $viewData['breadCrub3'] = [
                                'url' => null,
                                'name' => '' . $subcategory->name
                            ];
                            $categoriesIdsToDisplay = $subcategory->category_id;
                            break;
                        }
                    }
                }
            }
            $tasks = DB::select('select legal_test_questions.*, category.name as categoryName FROM legal_test_questions '
                    . 'LEFT JOIN legal_tasks_categories as category ON (legal_test_questions.category_id = category.category_id) '
                    . 'LEFT JOIN legal_tasks_categories as rootcategory ON (rootcategory.category_id = category.parent_id) '
                    . 'WHERE legal_test_questions.category_id IN ('.$categoriesIdsToDisplay.') ' . $onlyFreeTestCOndition
                    . ' LIMIT 1', []); //ORDER BY rootcategory.category_id, category.category_id
            
            $randomTask = DB::select('select legal_test_questions.*, category.name as categoryName FROM legal_test_questions '
                    . 'LEFT JOIN legal_tasks_categories as category ON (legal_test_questions.category_id = category.category_id) '
                    . 'LEFT JOIN legal_tasks_categories as rootcategory ON (rootcategory.category_id = category.parent_id) '
                    . 'WHERE legal_test_questions.category_id IN ('.$categoriesIdsToDisplay.') ' . $onlyFreeTestCOndition
                    . ' ORDER BY RAND() LIMIT 20', []);
            
        } else {
            $tasks = DB::select('select legal_test_questions.* FROM legal_test_questions '
                    . $onlyFreeTestCOndition2
                    //. 'LEFT JOIN legal_tasks_categories as category ON (legal_test_questions.category_id = category.category_id) '  , category.name as categoryName
                    //. 'LEFT JOIN legal_tasks_categories as rootcategory ON (rootcategory.category_id = category.parent_id) '
                    . ' LIMIT 1', []); //ORDER BY rootcategory.category_id, category.category_id
            
            $randomTask = DB::select('select legal_test_questions.* FROM legal_test_questions '
                    . $onlyFreeTestCOndition2
                    . ' ORDER BY RAND() LIMIT 20', []);
        }
        
        $viewData['tasks'] = $tasks;
        $viewData['randomTask'] = $randomTask;
        
        $viewData['isPro'] = Auth::user()->isPro();
        
        return view('legaltests.tests',$viewData);
    }
    
    public function legalTest($taskid){
        $viewData = [];
        
        $viewData['taskid'] = $taskid;
        
        $viewData['breadCrub1'] = [
            'url' => '/legal-tests',
            'name' => 'Zadania testowe'
        ];
        
        $viewData['breadCrub2'] = [
            'url' => null,
            'name' => 'Zadanie'
        ];
        
        $onlyFreeTestCOndition = '';
        if(!Auth::user()->isPro()) {
            $onlyFreeTestCOndition = ' AND legal_test_questions.is_free ';
        }
        
        /*$task = DB::select('select legal_test_questions.*, legal_tasks_categories.name as categoryName FROM legal_test_questions '
                . 'LEFT JOIN legal_tasks_categories ON (legal_test_questions.category_id = legal_tasks_categories.category_id) '
                . 'LEFT JOIN legal_test_answers ON (legal_test_answers) '
                . 'WHERE legal_test_questions.id = ?', [$taskid]);*/
        
        $nextTask = null;
        $next = DB::select('select * from legal_test_questions where id = (select min(id) from legal_test_questions where id > ?'. $onlyFreeTestCOndition.') ',[$taskid]);
        if (count($next) > 0){
            $nextTask = $next[0];
        }
        $viewData['nextTask'] = $nextTask;
        
        $prevTask = null;
        $prev = DB::select('select * from legal_test_questions where id = (select max(id) from legal_test_questions where id < ? '. $onlyFreeTestCOndition.')' ,[$taskid]);
        if (count($prev) > 0){
            $prevTask = $prev[0];
        }
        $viewData['prevTask'] = $prevTask;
        
        
        $answers = DB::select('SELECT legal_test_answers.*, legal_tasks_categories.name as category_name, legal_test_questions.is_free as is_free, legal_test_questions.answer_explanation as answer_explanation, legal_test_questions.id as question_id, legal_test_questions.question, legal_test_questions.type as question_type, legal_test_questions.difficulty_scale as difficulty_scale FROM legal_test_answers '
                . 'INNER JOIN legal_test_questions ON (legal_test_questions.id = legal_test_answers.question_id) '
                . 'LEFT JOIN legal_tasks_categories ON (legal_tasks_categories.category_id = legal_test_questions.category_id) '
                . 'WHERE question_id = ?', [$taskid]);
        
        if (count($answers) > 0){
            $viewData['answers'] = $answers;
        } else {
            $viewData['answers'] = null;
        }
        
        $viewData['isPro'] = Auth::user()->isPro();
        
        
        return view('legaltests.test',$viewData);
    }
}
