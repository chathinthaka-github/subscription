<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreServiceRequest extends FormRequest
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
            'shortcode_id' => ['required', 'exists:shortcodes,id'],
            'keyword' => [
                'required',
                'string',
                'max:120',
                Rule::unique('services', 'keyword')->where(function ($query) {
                    return $query->where('shortcode_id', $this->shortcode_id);
                }),
            ],
            'status' => ['required', 'in:active,inactive'],
            'fpmt_enabled' => ['boolean'],
        ];
    }
}

