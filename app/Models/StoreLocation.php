<?php

namespace App\Models;

use App\Models\Concerns\BuildsWhatsappLinks;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'business_profile_id',
    'name',
    'address',
    'phone',
    'whatsapp',
    'email',
    'business_hours',
    'map_embed_url',
    'maps_url',
    'notes',
    'is_primary',
    'is_active',
    'sort_order',
])]
class StoreLocation extends Model
{
    use HasFactory;
    use BuildsWhatsappLinks;

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function businessProfile(): BelongsTo
    {
        return $this->belongsTo(BusinessProfile::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderByDesc('is_primary')->orderBy('sort_order')->orderBy('name');
    }

    public function getWhatsappUrlAttribute(): ?string
    {
        return $this->buildWhatsappUrl();
    }

    public function getPhoneUrlAttribute(): ?string
    {
        $phone = preg_replace('/\D+/', '', $this->phone ?? '');

        return $phone !== '' ? "tel:+{$phone}" : null;
    }

    public function buildWhatsappUrl(?string $message = null): ?string
    {
        return $this->buildWhatsappLink($this->whatsapp, $message);
    }
}
