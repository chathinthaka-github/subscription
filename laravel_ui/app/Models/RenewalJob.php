<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RenewalJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'renewal_plan_id',
        'subscription_id',
        'msisdn',
        'status',
        'queued_at',
        'processed_at',
    ];

    protected function casts(): array
    {
        return [
            'queued_at' => 'datetime',
            'processed_at' => 'datetime',
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

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }
}

