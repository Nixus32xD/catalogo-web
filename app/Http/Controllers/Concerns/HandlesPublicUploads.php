<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

trait HandlesPublicUploads
{
    protected function storePublicFile(?UploadedFile $file, string $directory): ?string
    {
        if (! $file) {
            return null;
        }

        $path = $file->store($directory, $this->catalogMediaDisk());

        if ($path === false) {
            throw new RuntimeException('The uploaded file could not be stored.');
        }

        return $path;
    }

    protected function deletePublicFile(?string $path): void
    {
        if (blank($path) || Str::startsWith($path, ['http://', 'https://', '/'])) {
            return;
        }

        Storage::disk($this->catalogMediaDisk())->delete($path);
    }

    protected function catalogMediaDisk(): string
    {
        return config('filesystems.catalog_media_disk', 'public');
    }
}
