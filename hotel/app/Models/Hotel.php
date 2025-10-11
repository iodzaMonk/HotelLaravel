<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_name',
        'hotel_address',
        'image_path',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    /**
     * Resolve the public URL for the stored image.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image_path) {
            return null;
        }

        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('s3');

        return $disk->url($this->image_path);
    }

    /**
     * Resolve a temporary signed URL when available.
     */
    public function getTemporaryImageUrlAttribute(): ?string
    {
        if (!$this->image_path) {
            return null;
        }

        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('s3');

        if (method_exists($disk, 'temporaryUrl')) {
            return $disk->temporaryUrl(
                $this->image_path,
                now()->addMinutes(10)
            );
        }

        return $this->image_url;
    }

}