<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroStat extends Model
{
    protected $fillable = [
        'label',
        'value',
        'display_order',
    ];

    protected $casts = [
        'value' => 'integer',
        'display_order' => 'integer',
    ];
}
