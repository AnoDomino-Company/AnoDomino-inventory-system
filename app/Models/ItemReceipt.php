<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemReceipt extends Model
{
    use HasFactory;

    protected $fillable = ['item_id','date_received','quantity','price','received_by','remarks'];

    public function item(){ return $this->belongsTo(Item::class); }
    public function receiver(){ return $this->belongsTo(User::class,'received_by'); }
}
