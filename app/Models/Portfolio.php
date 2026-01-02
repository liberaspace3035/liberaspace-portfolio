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

        // R2またはS3を使用する場合は直接指定
        $filesystemDisk = env('FILESYSTEM_DISK', 'public');
        $disk = in_array($filesystemDisk, ['r2', 's3']) ? $filesystemDisk : 'public';
        
        // For S3/R2, use Storage::url()
        if (in_array($disk, ['r2', 's3'])) {
            return Storage::disk($disk)->url($this->image_path);
        }
        
        // For local/public disk, use asset()
        return asset('storage/' . $this->image_path);
    }
}
