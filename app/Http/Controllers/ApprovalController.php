<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestModel;
use App\Models\Approval;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequestApproved;

class ApprovalController extends Controller
{
    // Supervisor sees pending requests assigned to them
    public function pending()
    {
        $requests = RequestModel::where('supervisor_id', auth()->id())
            ->where('status', 'pending')
            ->with(['requestedBy', 'items.item']) // eager load requester and items
            ->get();

        return view('approvals.pending', compact('requests'));
    }

    // Approve or reject a request
    public function approve(Request $request, RequestModel $requestModel)
    {
        // Only the assigned supervisor can approve/reject
        if ($requestModel->supervisor_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validate([
            'status' => 'required|in:approved,rejected',
            'remarks' => 'nullable|string'
        ]);

        // Update the request's status and remarks
        $requestModel->status = $data['status'];
        $requestModel->remarks = $data['remarks'] ?? null;
        $requestModel->save();

        // Record the approval
        Approval::create([
            'request_id' => $requestModel->id,
            'supervisor_id' => auth()->id(),
            'approved_by' => auth()->id(),
            'status' => $data['status'],
            'remarks' => $data['remarks'] ?? null,
            'approved_at' => now(),
        ]);

        // Send email to authorisers if approved
        if ($data['status'] === 'approved') {
            $authorisers = \App\Models\User::where('role', 'authoriser')->pluck('email');
            foreach ($authorisers as $email) {
                Mail::to($email)->send(new RequestApproved($requestModel));
            }
        }

        return redirect()->back()->with('success', 'Decision saved successfully!');
    }
}
