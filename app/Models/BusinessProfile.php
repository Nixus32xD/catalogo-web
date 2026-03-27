<?php

namespace App\Models;

use App\Models\Concerns\BuildsWhatsappLinks;
use App\Models\Concerns\ResolvesCatalogMediaUrls;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'business_name',
    'logo_path',
    'hero_image_path',
    'short_description',
    'address',
    'whatsapp',
    'phone',
    'email',
    'business_hours',
    'welcome_text',
    'whatsapp_message',
    'product_inquiry_message',
    'primary_color',
    'secondary_color',
])]
class BusinessProfile extends Model
{
    use HasFactory;
    use BuildsWhatsappLinks;
    use ResolvesCatalogMediaUrls;

    public static function current(): self
    {
        return static::query()->firstOrCreate(['id' => 1], static::defaultAttributes());
    }

    public function locations(): HasMany
    {
        return $this->hasMany(StoreLocation::class)->ordered();
    }

    public static function defaultAttributes(): array
    {
        return [
            'business_name' => 'Nombre del comercio',
            'short_description' => 'Descripcion breve del negocio para contar que ofrece, su propuesta de valor y el tipo de atencion que brinda.',
            'address' => 'Direccion del comercio',
            'whatsapp' => '+54 9 11 0000 0000',
            'phone' => '+54 11 0000 0000',
            'email' => 'hola@comercio-demo.com',
            'business_hours' => 'Lunes a sabado de 9:00 a 19:00',
            'welcome_text' => 'Texto de bienvenida para presentar el negocio, generar confianza y guiar al visitante hacia el catalogo o el contacto.',
            'whatsapp_message' => 'Hola, quiero hacer una consulta sobre {business_name}.',
            'product_inquiry_message' => 'Hola, quiero consultar por {product_name} de {business_name}.',
            'primary_color' => '#0f766e',
            'secondary_color' => '#f59e0b',
        ];
    }

    protected function logoUrl(): Attribute
    {
        return Attribute::get(fn () => $this->resolveMediaUrl($this->logo_path));
    }

    protected function heroImageUrl(): Attribute
    {
        return Attribute::get(fn () => $this->resolveMediaUrl($this->hero_image_path));
    }

    protected function whatsappUrl(): Attribute
    {
        return Attribute::get(fn (): ?string => $this->contactWhatsappUrl());
    }

    protected function phoneUrl(): Attribute
    {
        return Attribute::get(function (): ?string {
            $phone = preg_replace('/\D+/', '', $this->phone ?? '');

            return $phone !== '' ? "tel:+{$phone}" : null;
        });
    }

    protected function resolveMediaUrl(?string $path): ?string
    {
        return $this->resolveCatalogMediaUrl($path);
    }

    public function contactWhatsappUrl(?StoreLocation $location = null): ?string
    {
        $message = $this->renderWhatsappMessage($this->whatsapp_message, [
            '{location_name}' => $location?->name,
            '{location_address}' => $location?->address,
        ]);

        return $this->buildWhatsappLink($location?->whatsapp ?: $this->whatsapp, $message);
    }

    public function productInquiryWhatsappUrl(Product $product, ?StoreLocation $location = null): ?string
    {
        $message = $this->renderWhatsappMessage($this->product_inquiry_message, [
            '{product_name}' => $product->name,
            '{product_price}' => '$'.number_format((float) $product->price, 0, ',', '.'),
            '{category_name}' => $product->category?->name,
            '{location_name}' => $location?->name,
            '{location_address}' => $location?->address,
        ]);

        return $this->buildWhatsappLink($location?->whatsapp ?: $this->whatsapp, $message);
    }

    public function renderWhatsappMessage(?string $template, array $replacements = []): ?string
    {
        if (blank($template)) {
            return null;
        }

        $message = strtr($template, [
            '{business_name}' => $this->business_name,
            '{product_name}' => '',
            '{product_price}' => '',
            '{category_name}' => '',
            '{location_name}' => '',
            '{location_address}' => '',
            ...collect($replacements)
                ->map(fn ($value) => (string) ($value ?? ''))
                ->all(),
        ]);

        return trim(preg_replace('/\s+/', ' ', $message) ?? $message);
    }
}
