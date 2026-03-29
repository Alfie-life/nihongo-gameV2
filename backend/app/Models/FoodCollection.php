<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodCollection extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'food_item_id',
        'mode',
        'level',
        'obtained_at',
    ];

    protected $casts = [
        'level' => 'integer',
        'obtained_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function foodItem()
    {
        return $this->belongsTo(FoodItem::class);
    }
}
