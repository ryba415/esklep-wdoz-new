<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Controllers\globalHelper\globalHelper;

class LegalTasksController extends Controller
{
    public function __construct()
    {
        if(!Auth::check() && ! \Route::is('dashboard'))
        {
            return redirect()->route('login');
        } else {

        }
    }
    
    public function dashboard(){
        if(Auth::check()){
            $user = Auth::user();

            $userId = Auth::id();

            $globalHelper = new globalHelper();

            if ($userId != null && $userId!= 0){

                /*$answersTasksHistory = DB::select('select legal_tasks_answers_history.*, IF (legal_tasks_answers_history.task_type = 1, task.category_id , test.category_id) AS category_id '
                        . ' FROM legal_tasks_answers_history '
                        . 'LEFT JOIN legal_tasks as task ON (legal_tasks_answers_history.task_type = 1 AND task.id = legal_tasks_answers_history.legal_task_id) '
                        . 'LEFT JOIN legal_test_questions as test ON (legal_tasks_answers_history.task_type = 2 AND test.id = legal_tasks_answers_history.legal_task_id) '
                        . ' WHERE legal_tasks_answers_history.user_id = ?', [$userId]);*/

                $answersTasksHistory = DB::select('select legal_tasks_answers_history.*, task.category_id as category_id, category.parent_id as parent_id '
                        . ' FROM legal_tasks_answers_history '
                        . ' LEFT JOIN legal_tasks as task ON (task.id = legal_tasks_answers_history.legal_task_id) '
                        . ' LEFT JOIN legal_tasks_categories as category ON (category.category_id = task.category_id) '
                        . ' WHERE legal_tasks_answers_history.user_id = ? AND legal_tasks_answers_history.task_type = 1', [$userId]);

                $answersTestHistory = DB::select('select legal_tasks_answers_history.*, test.category_id as category_id, category.parent_id as parent_id '
                        . ' FROM legal_tasks_answers_history '
                        . ' LEFT JOIN legal_test_questions as test ON (test.id = legal_tasks_answers_history.legal_task_id) '
                        . ' LEFT JOIN legal_tasks_categories as category ON (category.category_id = test.category_id) '
                        . ' WHERE legal_tasks_answers_history.user_id = ? AND legal_tasks_answers_history.task_type = 2', [$userId]);


                //echo '<pre>';
                //var_dump($answersTasksHistory);
                //echo '</pre>';die();

                $categoriesTasksStatistics = [];
                $mainCategoriesTasksStatistics = [];
                foreach ($answersTasksHistory as $answer){
                    if (!isset($categoriesTasksStatistics[$answer->category_id])){
                        $categoriesTasksStatistics[$answer->category_id] = [
                            'correct' => 0,
                            'fail' => 1
                        ];
                    }
                    if ($answer->parent_id == null){
                        if (!isset($mainCategoriesTasksStatistics[$answer->category_id])){
                            $mainCategoriesTasksStatistics[$answer->category_id] = [
                                'correct' => 0,
                                'fail' => 0
                            ];
                        }
                        if ($answer->correctness == 1){
                            $mainCategoriesTasksStatistics[$answer->category_id]['correct'] = $mainCategoriesTasksStatistics[$answer->category_id]['correct'] + 1;
                        } else {
                            $mainCategoriesTasksStatistics[$answer->category_id]['fail'] = $mainCategoriesTasksStatistics[$answer->category_id]['fail'] + 1;
                        }
                    } else {
                        if (!isset($mainCategoriesTasksStatistics[$answer->parent_id])){
                            $mainCategoriesTasksStatistics[$answer->parent_id] = [
                                'correct' => 0,
                                'fail' => 0
                            ];
                        }
                        if ($answer->correctness == 1){
                            $mainCategoriesTasksStatistics[$answer->parent_id]['correct'] = $mainCategoriesTasksStatistics[$answer->parent_id]['correct'] + 1;
                        } else {
                            $mainCategoriesTasksStatistics[$answer->parent_id]['fail'] = $mainCategoriesTasksStatistics[$answer->parent_id]['fail'] + 1;
                        }
                    }

                    if ($answer->correctness == 1){
                        $categoriesTasksStatistics[$answer->category_id]['correct'] = $categoriesTasksStatistics[$answer->category_id]['correct'] + 1;
                    } else {
                        $categoriesTasksStatistics[$answer->category_id]['fail'] = $categoriesTasksStatistics[$answer->category_id]['fail'] + 1;
                    }
                }

                $viewData['categoriesTasksStatistics'] = $categoriesTasksStatistics;
                $viewData['mainCategoriesTasksStatistics'] = $mainCategoriesTasksStatistics;

                $viewData['tasksCategories'] = $globalHelper->prepareCategoriesTree(1);


                $categoriesTestsStatistics = [];
                $mainCategoriesTestsStatistics = [];
                foreach ($answersTestHistory as $answer){
                    if (!isset($categoriesTestsStatistics[$answer->category_id])){
                        $categoriesTestsStatistics[$answer->category_id] = [
                            'correct' => 0,
                            'fail' => 1
                        ];
                    }
                    if ($answer->parent_id == null){
                        if (!isset($mainCategoriesTestsStatistics[$answer->category_id])){
                            $mainCategoriesTestsStatistics[$answer->category_id] = [
                                'correct' => 0,
                                'fail' => 0
                            ];
                        }
                        if ($answer->correctness == 1){
                            $mainCategoriesTestsStatistics[$answer->category_id]['correct'] = $mainCategoriesTestsStatistics[$answer->category_id]['correct'] + 1;
                        } else {
                            $mainCategoriesTestsStatistics[$answer->category_id]['fail'] = $mainCategoriesTestsStatistics[$answer->category_id]['fail'] + 1;
                        }
                    } else {
                        if (!isset($mainCategoriesTestsStatistics[$answer->parent_id])){
                            $mainCategoriesTestsStatistics[$answer->parent_id] = [
                                'correct' => 0,
                                'fail' => 0
                            ];
                        }
                        if ($answer->correctness == 1){
                            $mainCategoriesTestsStatistics[$answer->parent_id]['correct'] = $mainCategoriesTestsStatistics[$answer->parent_id]['correct'] + 1;
                        } else {
                            $mainCategoriesTestsStatistics[$answer->parent_id]['fail'] = $mainCategoriesTestsStatistics[$answer->parent_id]['fail'] + 1;
                        }
                    }

                    if ($answer->correctness == 1){
                        $categoriesTestsStatistics[$answer->category_id]['correct'] = $categoriesTestsStatistics[$answer->category_id]['correct'] + 1;
                    } else {
                        $categoriesTestsStatistics[$answer->category_id]['fail'] = $categoriesTestsStatistics[$answer->category_id]['fail'] + 1;
                    }
                }
                $viewData['categoriesTestsStatistics'] = $categoriesTestsStatistics;
                $viewData['mainCategoriesTestsStatistics'] = $mainCategoriesTestsStatistics;

                $viewData['testsCategories'] = $globalHelper->prepareCategoriesTree(2);

                return view('legaltasks.dashboard',$viewData);
            }
        } else {
            return redirect()->route('login');
        }
    }
    
    public function legalTasks($categoryId=null){
        $viewData = [];
        
        $viewData['breadCrub1'] = [
            'url' => null,
            'name' => 'Kazusy prawnicze'
        ];
        
        if ($categoryId != null){
            $currentCategory = $tasks = DB::select('select legal_tasks_categories.* from legal_tasks_categories WHERE category_id=?', [$categoryId]);
            $viewData['currentCategory'] = $currentCategory;
        }
        
        $globalHelper = new globalHelper();
        $categories = $globalHelper->prepareCategoriesTree(1,$categoryId);
        $viewData['categories'] = $categories;
        $viewData['categoriesType'] = 1;
        $viewData['currentCategoryId'] = $categoryId;
        
        $forceOrder = '';
        if (!Auth::user()->isPro()){
            $forceOrder = ' legal_tasks.is_free DESC, ';
        }
        
        if ($categoryId != null){
            $viewData['breadCrub1']['url'] = '/legal-tasks';
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
                                'url' => '/legal-tasks/category-' . $category['category']->category_id,
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

            $tasks = DB::select('select legal_tasks.*, category.name as categoryName from legal_tasks '
                    . 'LEFT JOIN legal_tasks_categories as category ON (category.category_id = legal_tasks.category_id) '
                    . 'LEFT JOIN legal_tasks_categories as rootcategory ON (rootcategory.category_id = category.parent_id) '
                    . 'WHERE legal_tasks.category_id IN ('.$categoriesIdsToDisplay.')'
                    . 'ORDER BY ' . $forceOrder . ' rootcategory.category_id, category.category_id', []);
        } else {
            $tasks = DB::select('select legal_tasks.*, category.name as categoryName from legal_tasks '
                    . 'LEFT JOIN legal_tasks_categories as category ON (category.category_id = legal_tasks.category_id)'
                    . 'LEFT JOIN legal_tasks_categories as rootcategory ON (rootcategory.category_id = category.parent_id) '
                    . 'ORDER BY ' . $forceOrder . 'rootcategory.category_id, category.category_id', []);
        }
        $viewData['tasks'] = $tasks;
        $viewData['isPro'] = Auth::user()->isPro();
        
        return view('legaltasks.tasks',$viewData);
    }
    
    public function legalTask($taskid){
        $viewData = [];
        
        $viewData['breadCrub1'] = [
            'url' => '/legal-tasks',
            'name' => 'Kazusy prawnicze'
        ];
        
        $viewData['breadCrub2'] = [
            'url' => null,
            'name' => 'Kazus'
        ];
        
        $taskid = intval($taskid);
        
        $task = DB::select('select legal_tasks.*, category.name as category_name, rootcategory.name as rootcategory_name, rootcategory.category_id as rootcategory_id from legal_tasks '
                . 'LEFT JOIN legal_tasks_categories as category ON (category.category_id = legal_tasks.category_id) '
                . 'LEFT JOIN legal_tasks_categories as rootcategory ON (rootcategory.category_id = category.parent_id) '
                . 'WHERE id = ?', [$taskid]);
        
        if (count($task) > 0){
            $viewData['task'] = $task[0];
            
            if ($task[0]->rootcategory_id != null && $task[0]->rootcategory_id != ''){
                
                $viewData['breadCrub2'] = [
                    'url' => '/legal-tasks/category-' . $task[0]->rootcategory_id,
                    'name' => $task[0]->rootcategory_name
                ];
            
                $viewData['breadCrub3'] = [
                    'url' => '/legal-tasks/category-' . $task[0]->category_id,
                    'name' => $task[0]->category_name
                ];

                $viewData['breadCrub4'] = [
                    'url' => null,
                    'name' => 'Kazus'
                ];
            } else {
                $viewData['breadCrub2'] = [
                    'url' => '/legal-tasks/category-' . $task[0]->category_id,
                    'name' => $task[0]->category_name
                ];

                $viewData['breadCrub3'] = [
                    'url' => null,
                    'name' => 'Kazus'
                ];
            }
        } else {
            $viewData['task'] = null;
        }
        
        $viewData['isPro'] = Auth::user()->isPro();
        
        
        $forceFree = '';
        if (!Auth::user()->isPro()){
            $forceFree = ' AND legal_tasks.is_free = 1 ';
        }
        
        $nextTask = null;
        $next = DB::select('select legal_tasks.* from legal_tasks '
                
                . 'where id = (select min(id) from legal_tasks where id > ? '. $forceFree . ') ' ,[$taskid]);
        if (count($next) > 0){
            $nextTask = $next[0];
        }
        $viewData['nextTask'] = $nextTask;
        
        $prevTask = null;
        $prev = DB::select('select * from legal_tasks where id = (select max(id) from legal_tasks where id < ? '. $forceFree . ')',[$taskid]);
        if (count($prev) > 0){
            $prevTask = $prev[0];
        }
        $viewData['prevTask'] = $prevTask;
        
        return view('legaltasks.task',$viewData);
    }
    
    public function setLegalTaskAnswer($taskId, $correctness, $type){
        $response = [
            'status' => false,
            'id' => 0,
            'unloged' => false
        ];
        
        $user = Auth::user();
        
        $userId = Auth::id();
        
        if ($userId != null && $userId!= 0){
            $response['status'] = true;

            DB::insert('insert into legal_tasks_answers_history (legal_task_id,task_type,user_id,date,correctness) values (?, ?, ?, ?, ?)', [$taskId,$type,$userId,date('Y-m-d H:i:s'), $correctness]);
        } else {
            $response['unloged'] = true;
        }
        
        return response()->json($response);
        
    }
}
