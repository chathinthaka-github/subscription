<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RenewalPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'name',
        'price_code',
        'plan_type',
        'schedule_rules',
        'skip_subscription_day',
        'is_fixed_time',
        'fixed_time',
        'start_from',
    ];

    protected function casts(): array
    {
        return [
            'schedule_rules' => 'array',
            'skip_subscription_day' => 'boolean',
            'is_fixed_time' => 'boolean',
            'fixed_time' => 'datetime',
            'start_from' => 'datetime',
        ];
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function renewalJobs(): HasMany
    {
        return $this->hasMany(RenewalJob::class);
    }
}

