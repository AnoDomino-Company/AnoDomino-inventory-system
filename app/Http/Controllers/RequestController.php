<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RequestModel;
use App\Models\RequestItem;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequestCreated;

class RequestController extends Controller
{
    
    public function index()
    {
        // Get all requests with related users
        $requests = RequestModel::with('requester', 'supervisor')->get();

        return view('requests.index', compact('requests'));
    }

    public function create()
    {
        $supervisors = User::where('role', 'supervisor')->get();
        $items = Item::all();
        return view('requests.create', compact('supervisors','items'));
    }

public function store(Request $request)
{
    $data = $request->validate([
        'supervisor_id' => 'required|exists:users,id',
        'items' => 'required|array|min:1',
        'items.*.item_id' => 'required|exists:items,id',
        'items.*.quantity' => 'required|integer|min:1',
    ]);

    DB::transaction(function () use ($data) {
        // Create the request itself
        $req = RequestModel::create([
            'requested_by' => auth()->id(), // always logged in user
            'supervisor_id' => $data['supervisor_id'],
            'status' => 'pending',
        ]);

        // Attach requested items
        foreach ($data['items'] as $ri) {
            RequestItem::create([
                'request_id' => $req->id,
                'item_id' => $ri['item_id'],
                'quantity_requested' => $ri['quantity'],
            ]);
        }

        // 🔑 Get supervisor
        $supervisor = User::find($data['supervisor_id']);

        // 🔑 Send mail to supervisor
        if ($supervisor && $supervisor->email) {
            Mail::to($supervisor->email)->send(new RequestCreated($req));
        }
    });

    return redirect()
        ->route('requests.index')
        ->with('success', 'Request submitted successfully!');
}


    public function show($id)
    {
        $request = \App\Models\RequestModel::with('items.item')->findOrFail($id);

        return view('requests.show', compact('request'));
    }

}
