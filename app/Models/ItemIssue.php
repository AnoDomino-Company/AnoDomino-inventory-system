<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemIssue extends Model
{
    use HasFactory;

    protected $fillable = ['item_id','date_issued','quantity','issued_by','issued_to','request_id','remarks'];

    public function item(){ return $this->belongsTo(Item::class); }
    public function issuer(){ return $this->belongsTo(User::class,'issued_by'); }
    public function receiver(){ return $this->belongsTo(User::class,'issued_to'); }
    public function request(){ return $this->belongsTo(RequestModel::class,'request_id'); }
}
