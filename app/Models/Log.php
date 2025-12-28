<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Log extends Model
{
    protected $fillable = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    static public function event($actionType,$model,$description)
    {
        if(Auth::check()){$user_id=Auth::id();}else{$user_id='';}

        Log::create([
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_id' => $user_id,
            'actionType' => $actionType,
            'model' => $model,
            'description' => $description
        ]);

        return true;
    }
    

}
