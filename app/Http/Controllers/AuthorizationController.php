<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestModel;
use App\Models\Authorization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequestAuthorized;

class AuthorizationController extends Controller
{
    // show all pending requests for authorization
    public function pending()
    {
        $requests = RequestModel::where('status', 'approved') // only supervisor-approved
                                ->with('requester', 'items.item')
                                ->get();
        return view('authorizations.pending', compact('requests'));
    }

    // authorize or reject a request
    public function authorize(Request $request, RequestModel $requestModel)
    {
        $request->validate([
            'status' => 'required|in:authorized,rejected',
            'remarks' => 'nullable|string'
        ]);

        // make sure the request is supervisor-approved
        if (!(auth()->user()->role === 'authoriser' && $requestModel->status === 'approved')) {
            abort(403, 'Request must be approved by supervisor first.');
        }

        $requestModel->status = $request->status;
        $requestModel->save();

        Authorization::create([
            'request_id' => $requestModel->id,
            'authoriser_id' => auth()->id(),
            'status' => $request->status,
            'remarks' => $request->remarks,
            'authorized_at' => now(),
        ]);

        // Send email to storekeepers if authorized
        if ($request->status === 'authorized') {
            $storekeepers = \App\Models\User::where('role', 'storekeeper')->pluck('email');
            foreach ($storekeepers as $email) {
                Mail::to($email)->send(new RequestAuthorized($requestModel));
            }
        }

        return redirect()->route('authorizations.pending')->with('success', 'Request authorized');
    }
}
