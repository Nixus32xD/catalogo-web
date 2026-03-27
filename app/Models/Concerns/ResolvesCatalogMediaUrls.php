<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

trait ResolvesCatalogMediaUrls
{
    protected function resolveCatalogMediaUrl(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://', '/'])) {
            return $path;
        }

        $diskName = config('filesystems.catalog_media_disk', 'public');
        $disk = Storage::disk($diskName);
        $diskConfig = config("filesystems.disks.{$diskName}", []);

        if ($this->shouldUseTemporaryUrl($diskName, $diskConfig)) {
            try {
                return $disk->temporaryUrl($path, now()->addMinutes(60));
            } catch (Throwable) {
                // Fall back to the regular URL when the disk does not support signed URLs.
            }
        }

        return $disk->url($path);
    }

    protected function shouldUseTemporaryUrl(string $diskName, array $diskConfig): bool
    {
        if ($diskName === 'public') {
            return false;
        }

        return ($diskConfig['visibility'] ?? null) !== 'public';
    }
}
