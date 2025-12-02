<?php

namespace App\Models;

use morilog;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $fillable = ['user_id','expired_at','otp'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
