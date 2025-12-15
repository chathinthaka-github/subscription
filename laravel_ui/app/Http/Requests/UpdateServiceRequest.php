<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()?->can('service.update') ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $serviceId = $this->route('service');

        return [
            'shortcode_id' => ['required', 'exists:shortcodes,id'],
            'keyword' => [
                'required',
                'string',
                'max:120',
                Rule::unique('services', 'keyword')
                    ->where(function ($query) {
                        return $query->where('shortcode_id', $this->shortcode_id);
                    })
                    ->ignore($serviceId),
            ],
            'status' => ['required', 'in:active,inactive'],
            'fpmt_enabled' => ['boolean'],
        ];
    }
}

