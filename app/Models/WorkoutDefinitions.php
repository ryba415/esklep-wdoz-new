<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Mail;
//use App\Interfaces\CmsObjectInterface;
use App\Models\CmsObject;

class WorkoutDefinitions extends CmsObject
{
    public $objectName = 'WorkoutDefinitions';
    public $dbTableName = 'workout_definitions';
    public $listName = 'Lista zdefiniowanych ćwiczeń';
    public $editItemUrl = 'workouts/workout';
    public $breadCrub1 = [
        'url' => '/workouts',
        'name' => 'ćwiczenia'
    ];
    public $breadCrub2 = [
        'url' => '/workouts/workout-new',
        'name' => 'ćwiczenie'
    ];
    
    public $areas = [
        0 => [
            'name' => 'Nazwa ćwiczenia',
            'type' => 'varchar',
            'field' => 'name',
            'editable' => true,
            'onList' => true,
            'validations' => [
                'require' => true,
                'nimLength' => 2,
                'maxLength' => 399
            ]
        ],
        1 => [
            'name' => 'Opis ćwiczenia',
            'type' => 'text',
            'field' => 'description',
            'editable' => true
        ],
        3 => [
           'name' => 'Poziom trudności (w skali 1/6)',
            'type' => 'select',
            'field' => 'difficult_level',
            'editable' => true, 
            'options' => [
                '' => '',
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
            ]
        ],
        4 => [
            'name' => 'Link do filmiku',
            'type' => 'varchar',
            'field' => 'movie_url',
            'editable' => true, 
        ]
        
        
        
    ];

}

