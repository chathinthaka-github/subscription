<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()?->can('reports.view') ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $reportType = $this->report_type;

        $statusRules = match ($reportType) {
            'renewal_job' => ['nullable', 'in:queued,processing,done,failed'],
            'subscription' => ['nullable', 'in:pending,active,suspended,cancelled'],
            'mt' => ['nullable', 'in:queued,success,fail'],
            default => ['nullable'],
        };

        return [
            'report_type' => ['required', 'in:renewal_job,subscription,mt'],
            'date_from' => ['nullable', 'date', 'before_or_equal:date_to'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
            'service_id' => ['nullable', 'exists:services,id'],
            'msisdn' => ['nullable', 'string', 'regex:/^\+?[1-9]\d{1,14}$/'],
            'status' => $statusRules,
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $hasFilter = $this->filled('date_from') || $this->filled('date_to') || $this->filled('service_id') || $this->filled('msisdn') || $this->filled('status');

            if (! $hasFilter) {
                $validator->errors()->add('report_type', 'At least one filter must be provided.');
            }
        });
    }
}

