<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestModel;
use App\Models\Approval;
use App\Models\Authorization;
use DB;

class AdminRequestController extends Controller
{

    // Show all requests
    public function index()
    {
        $requests = RequestModel::with('requester','supervisor','authoriser','items.item')->get();
        return view('admin.requests.index', compact('requests'));
    }

    // Show single request details
    public function show(RequestModel $requestModel)
    {
        $requestModel->load('requester','supervisor','authoriser','items.item');
        return view('admin.requests.show', compact('requestModel'));
    }

    // Admin approve/authorize (override)
    public function decide(Request $request, RequestModel $requestModel)
    {
        $request->validate([
            'status'=>'required|in:pending,approved,authorized,rejected,issued',
            'remarks'=>'nullable|string'
        ]);

        DB::transaction(function() use ($request, $requestModel){
            $requestModel->status = $request->status;
            $requestModel->save();

            // Optional: log in approvals or authorizations
            if (in_array($request->status, ['approved','rejected'])){
                Approval::updateOrCreate(
                    ['request_id'=>$requestModel->id],
                    [
                        'approved_by'=>auth()->id(),
                        'status'=>$request->status,
                        'remarks'=>$request->remarks,
                        'approved_at'=>now(),
                    ]
                );
            }

            if (in_array($request->status, ['authorized','rejected'])){
                Authorization::updateOrCreate(
                    ['request_id'=>$requestModel->id],
                    [
                        'authorized_by'=>auth()->id(),
                        'status'=>$request->status,
                        'remarks'=>$request->remarks,
                        'authorized_at'=>now(),
                    ]
                );
            }
        });

        return back()->with('success','Request updated successfully');
    }

        // Delete a user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success','User deleted');
    }
}

