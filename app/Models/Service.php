<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title',
        'description',
        'icon_svg',
        'features',
        'display_order',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'display_order' => 'integer',
    ];

    public function getFeaturesAttribute($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return $decoded !== null ? $decoded : [];
        }
        return $value ?? [];
    }

    public function setFeaturesAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['features'] = json_encode($value);
        } else {
            $this->attributes['features'] = $value;
        }
    }
}
