<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestModel extends Model
{

    use HasFactory;

    protected $table = 'requests';

    protected $fillable = [
        'requested_by',
        'supervisor_id',
        'status',
        'remarks',
    ];

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

        public function items()
    {
        return $this->hasMany(\App\Models\RequestItem::class, 'request_id');
    }

}
