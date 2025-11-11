<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'page',
        'filters',
        'is_export',
        'is_print',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}