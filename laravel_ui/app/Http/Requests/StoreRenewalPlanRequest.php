<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRenewalPlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()?->can('renewal_plan.create') ?? false;
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
            'name' => ['required', 'string', 'max:100'],
            'price_code' => ['required', 'string', 'max:50'],
            'plan_type' => ['required', 'in:daily,weekly,monthly'],
            'skip_subscription_day' => ['boolean'],
            'is_fixed_time' => ['boolean'],
            'fixed_time' => ['required_if:is_fixed_time,true', 'date_format:H:i', 'nullable'],
            'start_from' => ['nullable', 'date'],
            'schedule_rules' => ['exclude_if:plan_type,daily', 'array'],
'schedule_rules.days' => ['required_if:plan_type,weekly,monthly', 'array', 'min:1'],
            'schedule_rules.days.*' => ['integer', 'min:1', 'max:31'],
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Validate keyword exists for the shortcode
            $service = \App\Models\Service::where('shortcode_id', $this->shortcode_id)
                ->where('keyword', $this->keyword)
                ->where('status', 'active')
                ->first();

            if (!$service) {
                $validator->errors()->add('keyword', 'The selected keyword does not exist for this shortcode.');
                return;
            }

            // Validate unique combination of shortcode_id + keyword + name
            $exists = \App\Models\RenewalPlan::where('service_id', $service->id)
                ->where('name', $this->name)
                ->exists();

            if ($exists) {
                $validator->errors()->add('name', 'A renewal plan with this name already exists for this shortcode and keyword combination.');
            }

            $planType = $this->plan_type;
            $scheduleRules = $this->schedule_rules ?? [];

            if ($planType === 'weekly') {
                $days = $scheduleRules['days'] ?? [];
                if (empty($days)) {
                    $validator->errors()->add('schedule_rules.days', 'At least one day must be selected for weekly plan.');
                }
                foreach ($days as $day) {
                    if ($day < 1 || $day > 7) {
                        $validator->errors()->add('schedule_rules.days', 'Weekly plan days must be between 1 (Monday) and 7 (Sunday).');
                    }
                }
            }

            if ($planType === 'monthly') {
                $days = $scheduleRules['days'] ?? [];
                if (empty($days)) {
                    $validator->errors()->add('schedule_rules.days', 'At least one day must be selected for monthly plan.');
                }
                foreach ($days as $day) {
                    if ($day < 1 || $day > 31) {
                        $validator->errors()->add('schedule_rules.days', 'Monthly plan days must be between 1 and 31.');
                    }
                }
            }
        });
    }
}

