<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Models\RequestModel;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:admin']);
    }

    public function index()
    {
        $users = User::all();
        $items = Item::all();
        $requests = RequestModel::all();

        return view('admin.dashboard', compact('users','items','requests'));
    }

    public function dashboard()
{
    $totalUsers = \App\Models\User::count();
    $totalItems = \App\Models\Item::count();
    $pendingRequests = \App\Models\RequestModel::where('status', 'pending')->count(); // or whatever your status column is

    return view('admin.dashboard', compact('totalUsers', 'totalItems', 'pendingRequests'));
}

}
