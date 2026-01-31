<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['name','quantity','price','notes'];

    public function receipts()
    {
        return $this->hasMany(ItemReceipt::class);
    }

    public function issues()
    {
        return $this->hasMany(ItemIssue::class);
    }

    public function requestItems()
    {
        return $this->hasMany(RequestItem::class, 'item_id');
    }

    public function histories()
    {
        return $this->hasMany(ItemHistory::class);
    }


}
