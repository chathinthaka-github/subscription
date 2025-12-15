<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'shortcode_id',
        'keyword',
        'status',
        'fpmt_enabled',
    ];

    protected function casts(): array
    {
        return [
            'fpmt_enabled' => 'boolean',
        ];
    }

    public function shortcode(): BelongsTo
    {
        return $this->belongsTo(Shortcode::class);
    }

    public function serviceMessages(): HasMany
    {
        return $this->hasMany(ServiceMessage::class);
    }

    public function renewalPlans(): HasMany
    {
        return $this->hasMany(RenewalPlan::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
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

