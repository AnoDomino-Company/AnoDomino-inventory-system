<?php
namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemReceipt;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
use App\Models\ItemHistory;   // make sure this line is at the top


class ItemController extends Controller
{


    public function index()
    {
        $items = Item::orderBy('name')->paginate(25);
        return view('items.index', compact('items'));
    }

    // AJAX from modal
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'quantity' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
    ]);

    $item = Item::create($request->only('name', 'quantity', 'price'));



    return redirect()->back()->with('success', 'Item added successfully!');
}

    public function update(Request $request, Item $item)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
        ]);
        $item->update($data);
        return back()->with('success','Item updated');
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return back()->with('success','Item deleted');
    }

    public function restockForm($id)
{
    $item = Item::findOrFail($id);
    return view('items.restock', compact('item'));
}

public function restock(Request $request, Item $item)
{
    $validated = $request->validate([
        'quantity' => 'required|integer|min:1',
        'price' => 'required|numeric|min:0',
    ]);

    $item->increment('quantity', $validated['quantity']);
    $item->price = $validated['price']; // update price to new stock price
    $item->save();

    \App\Models\ItemHistory::create([
        'item_id' => $item->id,
        'type' => 'restock',
        'quantity' => $validated['quantity'],
        'balance' => $item->quantity,
        'price' => $validated['price'],
        'done_by' => auth()->id(),
    ]);

    return redirect()->route('items.index')->with('success','Item restocked successfully.');
}

public function history(Item $item)
{
    // Restock history
    $restocks = $item->histories()->where('type', 'restock')->get();

    // Issued history from requests
    $issues = $item->issues()->with('request')->get()->map(function($issue){
        return (object)[
            'type' => 'issue',
            'quantity' => $issue->quantity,
            'balance' => $issue->item->quantity, // current balance after issue
            'price' => $issue->item->price,
            'user' => $issue->receiver->name ?? 'N/A',
            'date' => $issue->date_issued,
        ];
    });

    // Combine restocks and issues
    $histories = $restocks->map(function($r){
        return (object)[
            'type' => 'restock',
            'quantity' => $r->quantity,
            'balance' => $r->balance,
            'price' => $r->price,
            'user' => $r->user->name ?? 'N/A',
            'date' => $r->created_at,
            'remarks' => $r->remarks,
        ];
    })->merge($issues)->sortByDesc('date');

    return view('items.history', compact('item', 'histories'));
}






}
