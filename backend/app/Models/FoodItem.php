<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_en',
        'emoji',
        'category',
        'mode',
        'level',
        'question_index',
    ];

    protected $casts = [
        'level' => 'integer',
        'question_index' => 'integer',
    ];
}
