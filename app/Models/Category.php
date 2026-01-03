<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [];

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
