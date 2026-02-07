<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Controllers\globalHelper\globalHelper;

class StatisticsController extends Controller
{
    public function __construct()
    {
        if(!Auth::check())
        {
            return redirect()->route('login');
        } else {

        }
    }

    
    public function mainStatistics(){
        $viewData = [];
        
        $viewData['breadCrub1'] = [
            'url' => null,
            'name' => 'Statystyki'
        ];
        
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

            return view('statistics.mainstatistics',$viewData);
        }
    }
    
    public function prints(){
        $viewData = [];
        
        $user = Auth::user();
        
        $userId = Auth::id();

        
        if ($userId == 1 || $userId == 2){
            $tasks = DB::select('select legal_tasks.*, category.name as categoryName from legal_tasks '
                    . 'LEFT JOIN legal_tasks_categories as category ON (category.category_id = legal_tasks.category_id)'
                    . 'LEFT JOIN legal_tasks_categories as rootcategory ON (rootcategory.category_id = category.parent_id) '
                    . 'ORDER BY rootcategory.category_id, category.category_id', []);

            $viewData['tasks'] = $tasks;
            return view('statistics.prints',$viewData);
        } else {
            echo 'access danied';
        }
        
    }
    
    public function statisticsGlobal(){
        $viewData = [];
        
        $user = Auth::user();
        
        $userId = Auth::id();

        
        if ($userId == 1 || $userId == 2){
            $users = DB::select('select users.name, count(legal_tasks_answers_history.answer_id) as answersCount FROM users '
                    . ' LEFT JOIN legal_tasks_answers_history ON users.id = legal_tasks_answers_history.user_id GROUP BY 1', []);
            $viewData['users'] = $users;
             
             
            $usersWithAnswersCount = 0;
            foreach ($users as $user){
                //var_dump($user->name . ' ' . $user->answersCount);
                if ($user->answersCount > 9){
                    $usersWithAnswersCount++;
                }
            }
            
            $viewData['usersWithAnswersCount'] = $usersWithAnswersCount;
           
            return view('statistics.statisticsGlobal',$viewData);
        } else {
            echo 'access danied';
        }
    }
    
}
