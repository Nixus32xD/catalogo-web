<?php

namespace App\Models;

use App\Models\Concerns\ResolvesCatalogMediaUrls;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

#[Fillable([
    'category_id',
    'name',
    'slug',
    'short_description',
    'price',
    'image_path',
    'is_active',
    'is_featured',
    'sort_order',
])]
class Product extends Model
{
    use HasFactory;
    use ResolvesCatalogMediaUrls;

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (self $product): void {
            if ($product->isDirty('name') || blank($product->slug)) {
                $product->slug = static::generateUniqueSlug($product->name, $product->getKey());
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->withDefault([
            'name' => 'Sin categoria',
        ]);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderByDesc('is_featured')->orderBy('name');
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => $this->resolveMediaUrl($this->image_path));
    }

    public static function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $baseSlug = $baseSlug !== '' ? $baseSlug : 'producto';
        $slug = $baseSlug;
        $counter = 1;

        while (
            static::query()
                ->when($ignoreId, fn (Builder $query) => $query->whereKeyNot($ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    protected function resolveMediaUrl(?string $path): ?string
    {
        return $this->resolveCatalogMediaUrl($path);
    }
}
