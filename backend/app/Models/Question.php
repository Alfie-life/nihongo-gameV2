<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'mode',
        'level',
        'sentence',
        'correct_answer',
        'wrong_answer',
        'explanation',
    ];

    protected $casts = [
        'level' => 'integer',
    ];
}
