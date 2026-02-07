<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function isPro(){
        $userId = Auth::id();
        
        $dbUser = DB::select('select pro_user_for FROM users where id=?', [$userId]);
        
        if (count($dbUser) > 0 && $dbUser[0]->pro_user_for != null  && $dbUser[0]->pro_user_for >= date('Y-m-d')){
            return true;
        } else {
            return false;
        }
    }
    
    public function isActive(){
        $userId = Auth::id();
        
        $dbUser = DB::select('select is_active FROM users where id=?', [$userId]);
        
        if (count($dbUser) > 0 && $dbUser[0]->is_active != null  && $dbUser[0]->is_active == 1){
            return true;
        } else {
            return false;
        }
    }
}
