<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateServiceMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()?->can('service_message.update') ?? false;
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
            'keyword' => ['required', 'string', 'max:120'],
            'message_type' => ['required', 'in:FPMT,RENEWAL'],
            'status' => ['required', 'in:active,inactive'],
            'message' => ['required', 'string', 'max:260'],
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $serviceMessage = $this->route('service_message');
            $serviceMessageId = $serviceMessage instanceof \App\Models\ServiceMessage ? $serviceMessage->id : $serviceMessage;
            
            // Validate keyword exists for the shortcode
            $service = \App\Models\Service::where('shortcode_id', $this->shortcode_id)
                ->where('keyword', $this->keyword)
                ->where('status', 'active')
                ->first();

            if (!$service) {
                $validator->errors()->add('keyword', 'The selected keyword does not exist for this shortcode.');
                return;
            }

            // Validate unique combination of shortcode_id + keyword + message_type (excluding current record)
            $exists = \App\Models\ServiceMessage::where('service_id', $service->id)
                ->where('message_type', $this->message_type)
                ->where('id', '!=', $serviceMessageId)
                ->exists();

            if ($exists) {
                $validator->errors()->add('message_type', 'A message of this type already exists for this shortcode and keyword combination.');
            }
        });
    }
}

