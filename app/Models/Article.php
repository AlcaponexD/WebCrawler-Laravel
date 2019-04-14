<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'id_user',
        'title',
        'link'
    ];
    protected $casts = [
    ];
}
