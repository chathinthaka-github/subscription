<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShortcodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()?->can('service.create') ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'shortcode' => ['required', 'string', 'max:20', 'regex:/^[A-Z0-9]+$/', 'unique:shortcodes,shortcode'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'shortcode.regex' => 'The shortcode must contain only uppercase letters and numbers.',
        ];
    }
}

