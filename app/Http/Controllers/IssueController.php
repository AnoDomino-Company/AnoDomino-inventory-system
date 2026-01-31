<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestModel;
use App\Models\Item;
use App\Models\ItemIssue;
use App\Models\ItemHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequestIssued;

class IssueController extends Controller
{
    // list approved requests waiting issuance
    public function index()
    {
        // Only show requests that are authorized for storekeepers
        $requests = RequestModel::where('status','authorized')
                    ->with('requester','items.item')
                    ->get();

        return view('issues.index', compact('requests'));
    }

    public function issue(Request $request, RequestModel $requestModel)
    {
        $request->validate(['remarks' => 'nullable|string']);

        // Make sure only authorized requests can be issued
        if ($requestModel->status !== 'authorized') {
            return back()->withErrors('Request not authorized or already issued.');
        }

        DB::transaction(function() use ($requestModel, $request) {
            foreach ($requestModel->items as $ri) {
                $item = Item::lockForUpdate()->find($ri->item_id);
                if ($item->quantity < $ri->quantity_requested) {
                    throw new \Exception("Insufficient stock for {$item->name}");
                }

                // Decrement item quantity
                $item->decrement('quantity', $ri->quantity_requested);

                // Log issued item
                ItemIssue::create([
                    'item_id' => $item->id,
                    'date_issued' => now()->toDateString(),
                    'quantity' => $ri->quantity_requested,
                    'issued_by' => auth()->id(),
                    'issued_to' => $requestModel->requested_by,
                    'request_id' => $requestModel->id,
                ]);

                // Log history
                ItemHistory::create([
                    'item_id' => $item->id,
                    'type' => 'issue',
                    'quantity' => $ri->quantity_requested,
                    'balance' => $item->quantity, // balance after issue
                    'price' => $item->price,
                    'done_by' => auth()->id(),
                    'remarks' => $request->remarks ?? null,
                ]);
            }

            // Update request status
            $requestModel->status = 'issued';
            $requestModel->save();
        });

        // Send email to requester
        Mail::to($requestModel->requester->email)->send(new RequestIssued($requestModel));

        return redirect()->route('issues.index')->with('success','Items issued');
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
