<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovementEvent extends Model
{
    protected $table = 'movement_events';
    protected $fillable = ['epc', 'seen_at', 'source', 'raw', 'antenna_id', 'antenna', 'rssi'];

    public $timestamps = true;

    protected $casts = [
        'seen_at' => 'datetime',
        'raw' => 'array',
        'rssi' => 'integer',
    ];

    public function antenna()
    {
        return $this->belongsTo(\App\Models\Antenna::class);
    }

    /**
     * Scope events by EPC list and optional date range.
     */
    public function scopeForEpcs($query, array $epcs, ?string $from = null, ?string $to = null)
    {
        $query->whereIn('epc', $epcs);
        if ($from) {
            $query->where('seen_at', '>=', $from);
        }
        if ($to) {
            $query->where('seen_at', '<=', $to);
        }
        return $query->orderBy('seen_at');
    }
}