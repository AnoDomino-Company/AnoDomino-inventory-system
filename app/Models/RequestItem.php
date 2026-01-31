<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'item_id',
        'quantity_requested',
    ];

    public function request()
    {
        return $this->belongsTo(RequestModel::class, 'request_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
