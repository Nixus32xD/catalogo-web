<?php

namespace App\Models\Concerns;

trait BuildsWhatsappLinks
{
    protected function buildWhatsappLink(?string $phone, ?string $message = null): ?string
    {
        $sanitizedPhone = preg_replace('/\D+/', '', $phone ?? '');

        if ($sanitizedPhone === '') {
            return null;
        }

        $url = "https://wa.me/{$sanitizedPhone}";

        if (filled($message)) {
            $url .= '?text='.rawurlencode($message);
        }

        return $url;
    }
}
