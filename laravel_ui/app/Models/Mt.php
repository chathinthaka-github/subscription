<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mt extends Model
{
    use HasFactory;

    protected $table = 'mt';

    protected $fillable = [
        'service_id',
        'subscription_id',
        'msisdn',
        'message_type',
        'status',
        'dn_status',
        'dn_details',
        'price_code',
        'mt_ref_id',
        'message',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }
}

