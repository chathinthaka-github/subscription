<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'msisdn',
        'service_id',
        'renewal_plan_id',
        'status',
        'subscribed_at',
        'last_renewal_at',
        'next_renewal_at',
    ];

    protected function casts(): array
    {
        return [
            'subscribed_at' => 'datetime',
            'last_renewal_at' => 'datetime',
            'next_renewal_at' => 'datetime',
        ];
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function renewalPlan(): BelongsTo
    {
        return $this->belongsTo(RenewalPlan::class);
    }

    public function renewalJobs(): HasMany
    {
        return $this->hasMany(RenewalJob::class);
    }

    public function mts(): HasMany
    {
        return $this->hasMany(Mt::class);
    }
}

