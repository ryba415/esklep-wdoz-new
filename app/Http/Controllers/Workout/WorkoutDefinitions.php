<?php

namespace App\Http\Controllers\Workout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Controllers\globalHelper\globalHelper;
use App\Http\Controllers\Cms\TableList;
use App\Http\Controllers\Cms\TableEdit;

class WorkoutDefinitions extends Controller
{
    public function __construct()
    {
        if(!Auth::check() && ! \Route::is('dashboard'))
        {
            return redirect()->route('login');
        } else {

        }
    }

    public function workouts(){
        
        $list = new TableList('WorkoutDefinitions');

        return $list->render();
    }
    
    public function workout($workoutId){
        
        $edit = new TableEdit('WorkoutDefinitions');

        return $edit->render($workoutId);
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
