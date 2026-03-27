<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BusinessProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'business_name' => ['required', 'string', 'max:255'],
            'short_description' => ['required', 'string', 'max:500'],
            'address' => ['required', 'string', 'max:255'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'business_hours' => ['required', 'string', 'max:255'],
            'welcome_text' => ['required', 'string', 'max:1000'],
            'whatsapp_message' => ['nullable', 'string', 'max:1000'],
            'product_inquiry_message' => ['nullable', 'string', 'max:1000'],
            'primary_color' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'secondary_color' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'hero_image' => ['nullable', 'image', 'max:4096'],
            'remove_logo' => ['nullable', 'boolean'],
            'remove_hero_image' => ['nullable', 'boolean'],
        ];
    }
}
