<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Portfolio extends Model
{
    protected $fillable = [
        'title',
        'category',
        'description',
        'image_path',
        'url',
        'display_order',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * Get the image URL based on the storage disk
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image_path) {
            return null;
        }

        $disk = env('FILESYSTEM_DISK', 'public');
        
        // For R2 or S3, use Storage::url()
        if ($disk === 'r2' || $disk === 's3') {
            return Storage::disk($disk)->url($this->image_path);
        }
        
        // For local/public disk, use asset()
        return asset('storage/' . $this->image_path);
    }
}
