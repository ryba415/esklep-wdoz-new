<?php

namespace App\Http\Controllers\globalHelper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mail;
use App\Mail\SendMail;

class globalHelper extends Controller
{

    public function mapPaymentStatus($status){
        $returnStatus = $status;
        switch ($status) {
            case 'NEW':
                $returnStatus = 'zamówienie nieopłacone';
                break;
            case 'CONFIRMED':
                $returnStatus = 'zamówienie opłacone';
                break;
            case 'EXPIRED':
                $returnStatus = 'płatność wygasła';
                break;
            case 'REJECTED':
                $returnStatus = 'płatność odrzucona';
                break;
            case 'PENDING':
                $returnStatus = 'zamówienie oczekuje na potwierdzenie płatność';
                break;
            case 'ERROR':
                $returnStatus = 'błąd podczas dokonywania płatności';
                break;
            case null:
                $returnStatus = 'zamówienie nieopłacone';
                break;
        }
        return $returnStatus;
    }
    
    public function mapOrderStatus($status){
        $returnStatus = $status;
        switch ($status) {
            case 'send':
                $returnStatus = 'zamówienie wysłane';
                break;
            case 'payed_failed':
                $returnStatus = 'zamówienie nieopłacone';
                break;
            case 'inprogress':
                $returnStatus = 'nowe zamówienie';
                break;
            case 'redy_to_send':
                $returnStatus = 'zamówienie gotowe dowysłania';
                break;
            case '':
            case null:
                $returnStatus = 'nowe zamówienie';
                break;
        }
        return $returnStatus;
    }
    
    
    public function saveDbText($text){
        $text = preg_replace( '/[^A-Za-z0-9@\-]/i', '', $text);
        
        return $text;
    }
    
    public function saveDbEmail($text){
        $text = preg_replace( '/[^A-Za-z0-9@\-\.]/i', '', $text);
        
        return $text;
    }
    
    public function sendEmail($email,$view,$title){
        $testMailData = [
            'title' => 'Test Email From AllPHPTricks.com',
            'body' => 'This is the body of test email.'
        ];

        Mail::to($email)->send(new SendMail($testMailData,$view));
    }
    
    public function prepareCategoriesTree($type = 1, $currentCategory = null){
        if ($type == 1){
            $categories = $tasks = DB::select('select category.category_id, category.parent_id, category.destination_type, category.name, category.description, count(distinct tasks.id) as taskscount '
                    . ' from legal_tasks_categories as category'
                    . ' LEFT JOIN legal_tasks tasks ON tasks.category_id = category.category_id'
                    . ' WHERE destination_type=?'
                    . ' GROUP BY category.category_id, category.parent_id, category.destination_type, category.name, category.description, tasks.category_id', [$type]);
        } else {
            $categories = $tasks = DB::select('select category.category_id, category.parent_id, category.destination_type, category.name, category.description, count(distinct tasks.id) as taskscount '
                    . ' from legal_tasks_categories as category'
                    . ' LEFT JOIN legal_test_questions tasks ON tasks.category_id = category.category_id'
                    . ' WHERE destination_type=?'
                    . ' GROUP BY category.category_id, category.parent_id, category.destination_type, category.name, category.description, tasks.category_id', [$type]);
        }
        $categoresTree = [];
        foreach ($categories as $category){
            if ($category->parent_id == NULL){
                $categoresTree[$category->category_id] = [];
                if ($category->category_id == $currentCategory){
                    $categoresTree[$category->category_id]['opened'] = true;
                } else {
                    $categoresTree[$category->category_id]['opened'] = false;
                }
                $categoresTree[$category->category_id]['category'] = $category;
                $categoresTree[$category->category_id]['childCategories'] = [];
                
                
            }
        }
        foreach ($categories as $category){
            if ($category->parent_id != NULL  && isset($categoresTree[$category->parent_id])){
                if ($category->category_id == $currentCategory){
                    $category->categorySelected = true;
                    $categoresTree[$category->parent_id]['opened'] = true;
                }
                $categoresTree[$category->parent_id]['childCategories'][] = $category;
                
            }
        }
        
        return $categoresTree;
    }
    
    public function rediredtToLogin(){
        header('Location: /login', true, 302);
    }
}
