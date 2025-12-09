<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRenewalPlanRequest extends StoreRenewalPlanRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('renewal_plan.update') ?? false;
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $renewalPlanId = $this->route('renewal_plan');
            
            // Validate keyword exists for the shortcode
            $service = \App\Models\Service::where('shortcode_id', $this->shortcode_id)
                ->where('keyword', $this->keyword)
                ->where('status', 'active')
                ->first();

            if (!$service) {
                $validator->errors()->add('keyword', 'The selected keyword does not exist for this shortcode.');
                return;
            }

            // Validate unique combination of shortcode_id + keyword + name (excluding current record)
            $exists = \App\Models\RenewalPlan::where('service_id', $service->id)
                ->where('name', $this->name)
                ->where('id', '!=', $renewalPlanId)
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

