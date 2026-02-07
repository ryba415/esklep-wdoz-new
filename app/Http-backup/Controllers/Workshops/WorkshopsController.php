<?php

namespace App\Http\Controllers\Workshops;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Controllers\Cms\TableList;
use App\Http\Controllers\globalHelper\globalHelper;

class WorkshopsController extends Controller
{
    public function __construct()
    {
        if(!Auth::check() && ! \Route::is('dashboard'))
        {
            return redirect()->route('login');
        } else {

        }
    }
    
    public function importWorkshop(){
        if(Auth::check()){
            $user = Auth::user();

            $userId = Auth::id();

            $viewData = [];

            return view('workshop.import',$viewData);

        } else {
            return redirect()->route('login');
        }
    }
    
    public function saveImportedWorkshop(Request $request, $id){  
        $requestAll = $request->all();
        //var_dump($requestAll);
        $response = [
            'status' => true,
            'errors' => [],
            'errorsAreas' => [],
            'sucessSaveInfoText' => 'Zabudowa warsztatowa utworzona. <a href="/workshops">Kliknij tutaj aby przejść do listy zabudów</a>',
            'userUnloged' => false
        ];
        $userId = Auth::id();
        if ($userId != null){
            if ($request->hasFile('csvfile')){
                $request->file('csvfile')->get();
                $csvString = $request->file('csvfile')->get();
                if (str_contains($csvString,';')){

                    if ($requestAll['workshop-identity'] != null && $requestAll['workshop-identity'] != ''){
                        $name = preg_replace( '/[^A-Za-z0-9\- ]/i', '', $requestAll['workshop-identity']);
                        $description = preg_replace( '/[^A-Za-z0-9\- ]/i', '', $requestAll['description']);
                        
                        $duplicatedName = $tasks = DB::select('select name FROM workshops WHERE name=?', [$name]);
                        if (count($duplicatedName) == 0){
                            $insertWorkshop = DB::table('workshops')
                                    ->insert(
                                        [   'name' => $name,
                                            'user_id' => $userId,
                                            'created_date' => date('Y-m-d H:i:s'),
                                            'description' => $description
                                        ]
                                    );
                            $worksopId = DB::getPdo()->lastInsertId();

                            if ($insertWorkshop){
                                $row = 1;
                                if (($handle = fopen($request->file('csvfile')->path(), "r")) !== FALSE) {

                                    while (($data = fgetcsv($handle, 30000, ";")) !== FALSE) {
                                        $num = count($data);
                                        $row++;
                                        if (count($data) >= 4){
                                            $insertWorkshop = DB::table('workshops_items')
                                                ->insert(
                                                    ['workshop_id' => $worksopId,
                                                        'symbol' => $data[0],
                                                        'name' => $data[1],
                                                        'count' => floatval($data[2]),
                                                        'unit' => $data[3],
                                                    ]
                                                );
                                        }
                                    }
                                    fclose($handle);
                                }
                            } else {
                                $response['errorsAreas'][] = 'workshop-identity';
                                $response['errors'][] = 'Wystąpił wewnątrzny błąd podczas zapisu zabudowy - spróbój ponownie lub skontaktuj się z administratorem';
                                $response['status'] = false; 
                            }
                        } else {
                            $response['errorsAreas'][] = 'workshop-identity';
                            $response['errors'][] = 'Zabudowa warsztatowa z tym identyfikatorem już istnieje - podaj inny identyfikator';
                            $response['status'] = false; 
                        }
                    } else {
                        $response['errorsAreas'][] = 'workshop-identity';
                        $response['errors'][] = 'Identyfikator zabudowy jest polem obowiązkowym';
                        $response['status'] = false; 
                    }
                } else {
                    $response['errorsAreas'][] = 'workshop-file';
                    $response['errors'][] = 'plik csv musi być rozdzielony średnikami';
                    $response['status'] = false; 
                }
            } else {
                $response['errorsAreas'][] = 'workshop-file';
                $response['errors'][] = 'Załącz plik csv z informacją o zabudowie';
                $response['status'] = false;
            }
        } else {
            $response['userUnloged'] = true;
            $response['errors'][] = 'Sesja wygasła - użytkownik wylogowany';
            $response['status'] = false;
        }
        
        return response()->json($response);
    }
    
    public function Workshops(){
        $list = new TableList('Workshops');

        return $list->render();
    }
    
    public function workshopDetgails($workshopId){
        $userId = Auth::id();
        $viewData = [];
        
        $viewData['breadCrub1'] = [
            'url' => '/workshops',
            'name' => 'zabudowy'
        ];

        $workshop = DB::select('select * FROM workshops WHERE id=?', [$workshopId]);
        $viewData['workshop'] = $workshop[0];
        
        $viewData['breadCrub2'] = [
            'url' => null,
            'name' => 'zabudowa: ' . $workshop[0]->name
        ];
        
        $items = DB::select('select * FROM workshops_items WHERE workshop_id=?', [$workshopId]);
        $viewData['items'] = $items;
        
        $idsString = '';
        foreach ($items as $item){
            if ($idsString != ''){
                $idsString = $idsString . ',';
            }
            $idsString = $idsString . $item->id;
        }
        
        
        $history = DB::select('select history.*, users.name, users.surname FROM workshops_items_status_history as history '
                . ' LEFT JOIN users ON (history.user_id = users.id)'
                . ' WHERE history.workshops_item_id IN ('.$idsString.')', []);
        $historyArray = [];
        foreach ($history as $historyItem){
            if (!isset($historyArray[$historyItem->workshops_item_id])){
                $historyArray[$historyItem->workshops_item_id] = [];
            }
            if (!isset($historyArray[$historyItem->workshops_item_id][$historyItem->status_area])){
                $historyArray[$historyItem->workshops_item_id][$historyItem->status_area] = '';
            }
            $historyArray[$historyItem->workshops_item_id][$historyItem->status_area] = 
                    $historyArray[$historyItem->workshops_item_id][$historyItem->status_area] . $historyItem->date . ' ' . $historyItem->name . ' ' . $historyItem->surname . ' zmienił status na: ' . $historyItem->status . ' | ';
            
        }
       // echo '<pre>';
        //var_dump($historyArray);die();
        $viewData['history'] = $historyArray;

        return view('workshop.details',$viewData);
    }
    
    public function changeWorshopItemStatus(Request $request, $type){
        $requestAll = $request->all();
        $response = [
            'status' => true,
            'errors' => [],
            'errorsAreas' => [],
            'sucessSaveInfoText' => 'zmieniono status poprawnie',
            'userUnloged' => false,
            'date' => '',
            'ids' => [],
        ];
        $userId = Auth::id();
        if ($userId != null){
            $checkedIds = json_decode($requestAll['checkedIds'],true);
            $action = $requestAll['action']; 
            if ($action != '' && $action != null){
                if (in_array($action,['delivered','marked','complete','sent','arranged'])){
                    if (count($checkedIds)>0){
                        foreach($checkedIds as $itemId){
                            $items = DB::select('select * FROM workshops_items WHERE id=?', [$itemId]);
                            if ($type == 1){
                                if (count($items) > 0 && $items[0]->{$action} == null){
                                    $dbUserUpdate = DB::update('UPDATE workshops_items SET '.$action.'=? WHERE id=?', 
                                        [date('Y-m-d H:i:s'),$itemId]);

                                    DB::table('workshops_items_status_history')
                                        ->insert(
                                            [
                                                'user_id' => $userId,
                                                'workshops_item_id' => $itemId,
                                                'date' => date('Y-m-d H:i:s'),
                                                'status' => 1,
                                                'status_area' => $action,
                                            ]
                                        );
                                    $response['ids'] = $checkedIds;
                                    $response['date'] = date('Y-m-d H:i:s');
                                }
                            } else {
                                if (count($items) > 0 && $items[0]->{$action} != null){
                                    $dbUserUpdate = DB::update('UPDATE workshops_items SET '.$action.'=? WHERE id=?', 
                                        [null,$itemId]);

                                    DB::table('workshops_items_status_history')
                                        ->insert(
                                            [
                                                'user_id' => $userId,
                                                'workshops_item_id' => $itemId,
                                                'date' => date('Y-m-d H:i:s'),
                                                'status' => 0,
                                                'status_area' => $action,
                                            ]
                                        );
                                    $response['ids'] = $checkedIds;
                                    $response['date'] = date('Y-m-d H:i:s');
                                } 
                            }
                        }
                    } else {
                        $response['errors'][] = 'nie wybrano żadnych pozycji do zmiany statusu';
                        $response['status'] = false;
                    }
                } else {
                    $response['errors'][] = 'nieprawisłowy status';
                    $response['status'] = false; 
                }
            } else {
                $response['errors'][] = 'wybierz status z listy';
                $response['status'] = false;  
            }
        } else {
            $response['userUnloged'] = true;
            $response['errors'][] = 'Sesja wygasła - użytkownik wylogowany';
            $response['status'] = false;
        }
        
        return response()->json($response);
    }
}
