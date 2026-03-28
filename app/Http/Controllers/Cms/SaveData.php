<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\ListCrud;
use App\Http\Controllers\globalHelper\globalHelper;

class SaveData extends Controller
{
    protected $modelsEnabledToSave = ['WorkoutDefinitions','Workshops',"Users","Orders","AdminSliders"];
    protected $modelObject = null;
    protected $status = true;
    protected $errors = [];
    protected $errorsAreas = [];
    protected $postData = [];
    protected $editElemId = null;
    protected $sucessSaveInfoText = '';
    
    public function universalSave(Request $request, $objectName){
        $userUnloged = false;
        if (in_array($objectName,$this->modelsEnabledToSave)){
            
            $this->postData = $request->all();
            $this->editElemId = $this->postData['id']["value"];
            $fullObjectUrl = "\App\Models" . "\\" . $objectName;
            $this->modelObject = new $fullObjectUrl();
            $userId = Auth::id();
            if ($userId != null){
                if (is_object($this->modelObject)){
                    
                    if (method_exists($this->modelObject, 'ownSaveAction')){
                        return response()->json($this->modelObject->ownSaveAction($request, $this->postData));
                    }
                    $this->validateData();
                    if ($this->status){
                        foreach ($this->postData  as $area => $value){
                            foreach ($this->modelObject->areas  as $madelArea){
                                if ($madelArea['field'] == $area){
                                    if (isset($madelArea['editable']) && $madelArea['editable']){
                                        $updateTable[$area] = $value["value"];
                                    }
                                    break;
                                }
                            }
                        }
                        if ($this->editElemId == null || $this->editElemId == ''){
                            $saveStatus = DB::table($this->modelObject->dbTableName)
                                ->insert(
                                    $updateTable
                                );
                            $this->editElemId = DB::getPdo()->lastInsertId();
                            
                            if ($saveStatus === 0){
                                $this->status = false;
                                $this->errors[] = 'Wystąpił wewnętrzny błąd podczas próbu zapisu1';
                            }

                        } else {
                            $updateStatus = DB::table($this->modelObject->dbTableName)
                                ->where(['id'=>$this->editElemId, 'user_id' => $userId])
                                    ->update($updateTable);
                            
                            /*if ($updateStatus === 0){
                                $this->status = false;
                                $this->errors[] = 'Wystąpił wewnętrzny błąd podczas próbu zapisu2';
                            }*/
                        }
                        $this->sucessSaveInfoText = $this->modelObject->sucessSaveInfoText;
                    }       
                } else {
                    $this->errors[] = 'Błędny objekt modelu';
                    $this->status = false;
                }
            } else {
                $userUnloged = true;
                $this->errors[] = 'Sesja wygasła - użytkownik wylogowany';
                $this->status = false;
            }
        } else {
            $this->errors[] = 'Brak uprawnień do zapisu tego objektu';
            $this->status = false;
        }
        
        return response()->json([
            'status' => $this->status,
            'errors' => $this->errors,
            'errorsAreas' => $this->errorsAreas,
            'editElemId' => $this->editElemId,
            'sucessSaveInfoText' => $this->sucessSaveInfoText,
            'userUnloged' => $userUnloged
        ]);
    }
    
    private function validateData(){
        foreach ($this->modelObject->areas as $area){
            if ($area['editable']){
                if (isset($area['validations'])){
                    foreach ($area['validations'] as $validation => $validationRestict){
                        switch ($validation) {
                            case 'require':
                                $this->requireValidation($area['field'], $area['name']);
                                break;
                            case 'nimLength':
                                $this->nimLengthValidation($area['field'], $area['name'], $validationRestict);
                                break;
                            case 'maxLength':
                                $this->maxLengthValidation($area['field'], $area['name'], $validationRestict);
                                break;
                        }
                    }
                }
            }
        }
    }
    
    private function requireValidation($field, $fieldName, $showErrors = true){
        if (isset($this->postData[$field]) && isset($this->postData[$field]['value']) ){
            if ($this->postData[$field]['value'] !== '' || $this->postData[$field]['value'] !== null){
                return true;
            } else {
                $this->status = false;
                if ($showErrors){
                    $this->errors[] = 'Pole: ' . $fieldName . ' nie może pozostać puste ';
                    $this->errorsAreas[] = $field;
                }
                return false;
            }
        } else {
            $this->status = false;
            if ($showErrors){
                $this->errors[] = 'Pole: ' . $fieldName . ' nie może pozostać puste ';
                $this->errorsAreas[] = $field;
            }
            return false;
        }
    }
    
    private function nimLengthValidation($field, $fieldName, $restict, $showErrors = true){
        if ($this->requireValidation($field, $fieldName, false)){
            if (strlen($this->postData[$field]['value']) >= $restict){
                return true;
            } else {
                $this->status = false;
                if ($showErrors){
                    $this->errors[] = 'Pole: ' . $fieldName . ' musi mieć minimalnie ' . $restict . ' znaków';
                    $this->errorsAreas[] = $field;
                }
                return false;
            }
        }
    }
    
    private function maxLengthValidation($field, $fieldName, $restict, $showErrors = true){
        if ($this->requireValidation($field, $fieldName, false)){
            if (strlen($this->postData[$field]['value']) <= $restict){
                return true;
            } else {
                $this->status = false;
                if ($showErrors){
                    $this->errors[] = 'Pole: ' . $fieldName . ' może mieć maksymalnie ' . $restict . ' znaków';
                    $this->errorsAreas[] = $field;
                }
                return false;
            }
        }
    }
    
    public function universalDeleteOnList($itemId, $objectName){
        $status = false;
        if (in_array($objectName,$this->modelsEnabledToSave)){
            $fullObjectUrl = "\App\Models" . "\\" . $objectName;
            $modelObject = new $fullObjectUrl();
            DB::table($modelObject->dbTableName)->where('id', $itemId)->delete();
            $status = true;
        }
        
        return response()->json([
            'status' => $status,
        ]);
    }

}
