<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class PageVisit extends Model
{
    protected $fillable = [
        'page',
        'client_timestamp',
        'ip_address',
        'user_agent',
        'fingerprint',
    ];

    protected $casts = [
        'client_timestamp' => 'datetime',
    ];
}
