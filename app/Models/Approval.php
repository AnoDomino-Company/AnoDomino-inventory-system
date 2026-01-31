<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;
    protected $fillable = ['request_id','supervisor_id','approved_by','status','remarks','approved_at'];
    public function request(){ return $this->belongsTo(RequestModel::class,'request_id'); }
    public function approver(){ return $this->belongsTo(User::class,'approved_by'); }
}
