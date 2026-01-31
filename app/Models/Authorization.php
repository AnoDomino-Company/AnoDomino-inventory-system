<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Authorization extends Model
{
    protected $fillable = [
        'request_id',
        'requested_by',
        'authoriser_id',
        'status',
        'remarks',
        'authorized_at',
    ];

    // relationship to request
    public function request()
    {
        return $this->belongsTo(RequestModel::class);
    }

    // relationship to authoriser (user)
    public function authoriser()
    {
        return $this->belongsTo(User::class, 'authoriser_id');
    }
}
