<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageUploadService
{
    /**
     * Upload image and return path
     */
    public function upload(UploadedFile $file, string $directory = 'recipes'): ?string
    {
        if (!$file->isValid()) {
            return null;
        }

        return $file->store($directory, 'public');
    }

    /**
     * Delete image from storage
     */
    public function delete(?string $path): bool
    {
        if (!$path) {
            return false;
        }

        return Storage::disk('public')->delete($path);
    }

    /**
     * Update image: delete old and upload new
     */
    public function update(?string $oldPath, UploadedFile $newFile, string $directory = 'recipes'): ?string
    {
        // Delete old image if exists
        if ($oldPath) {
            $this->delete($oldPath);
        }

        // Upload new image
        return $this->upload($newFile, $directory);
    }
}
