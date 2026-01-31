<?php
namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\ItemHistory;

class HistoryController extends Controller
{
    public function show(Item $item)
    {
        $item->load('receipts.receiver','issues.issuer','issues.receiver');
        // compute running balance: we can compute in view or here
        $receipts = $item->receipts()->orderBy('created_at')->get();
        $issues = $item->issues()->orderBy('created_at')->get();

        // merge events chronologically
        $events = $receipts->map(function($r){ return [
            'type'=>'in','date'=>$r->date_received,'qty'=>$r->quantity,'by'=>$r->receiver->name ?? null,'remarks'=>$r->remarks
        ];})->merge($issues->map(function($i){ return [
            'type'=>'out','date'=>$i->date_issued,'qty'=>$i->quantity,'by'=>$i->receiver->name ?? null,'issued_by'=>$i->issuer->name ?? null,'remarks'=>$i->remarks
        ];}))->sortBy('date')->values();

        return view('items.history', compact('item','events'));
    }

    public function history(Item $item)
{
    // fetch histories for this item, latest first
    $histories = ItemHistory::where('item_id', $item->id)
                    ->with('user') // eager load user
                    ->orderBy('created_at','desc')
                    ->get();

    return view('items.history', compact('item','histories'));
}
}
