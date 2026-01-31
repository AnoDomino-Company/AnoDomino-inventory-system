<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorizationController;


route::middleware(['auth','role:storekeeper,admin'])->group(function(){
    Route::post('/items/{item}/restock', [ItemController::class,'restock'])->name('items.restock');
    Route::get('/items/{item}/history', [ItemController::class,'history'])->name('items.history');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/storekeeper/pending', [IssueController::class, 'index'])->name('storekeeper.pending');
    Route::post('/storekeeper/{id}/issue', [IssueController::class, 'issue'])->name('storekeeper.issue');
});


Route::middleware(['auth', 'role:authoriser,admin'])->group(function () {
    // Show pending authorizations
    Route::get('authorizations/pending', [AuthorizationController::class, 'pending'])
        ->name('authorizations.pending');

    // Authoriser approves or rejects
    Route::post('authorizations/{requestModel}/authorize', [AuthorizationController::class, 'authorize'])->name('authorizations.authorize');

});


// Redirect root to requests page
Route::get('/', function () {
    return redirect('/requests');
});

// -------------------- Auth Routes --------------------
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// -------------------- Routes for any logged-in user --------------------
Route::middleware(['auth'])->group(function () {

    // Requests
    Route::resource('requests', RequestController::class)->only(['index', 'create', 'store', 'show']);

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ajax item search
    Route::get('api/items/search', function (\Illuminate\Http\Request $r) {
        $q = $r->get('q', '');
        $items = \App\Models\Item::where('name', 'like', "%$q%")
            ->orWhere('code', 'like', "%$q%")
            ->limit(20)
            ->get(['id', 'code', 'name', 'quantity']);
        return response()->json($items);
    })->name('api.items.search');
});

Route::get('/requests', [RequestController::class, 'index'])->name('requests.index')->middleware('auth');


// Items
    Route::resource('items', ItemController::class)->only(['index', 'store', 'update', 'destroy']);
    //Route::get('items/{item}/history', [HistoryController::class, 'show'])->name('items.history');


// -------------------- Routes for supervisors --------------------
Route::middleware(['auth', 'role:supervisor,admin'])->group(function () {
    Route::get('approvals/pending', [ApprovalController::class, 'pending'])->name('approvals.pending');
    Route::post('approvals/{requestModel}/decide', [ApprovalController::class, 'approve'])->name('approvals.approve');
});

// -------------------- Routes for storekeepers --------------------
Route::middleware(['auth', 'role:storekeeper,supervisor,admin'])->group(function () {
    Route::get('issues', [IssueController::class, 'index'])->name('issues.index');
    Route::post('issues/{requestModel}/issue', [IssueController::class, 'issue'])->name('issues.issue');
});


// -------------------- Admin-only routes --------------------
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::get('users/{user}/reset-password', [\App\Http\Controllers\UserController::class, 'resetPasswordForm'])->name('users.reset-password-form');
    Route::post('users/{user}/reset-password', [\App\Http\Controllers\UserController::class, 'resetPassword'])->name('users.reset-password');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard'); // create this Blade view
    })->name('admin.dashboard');
});

Route::middleware(['auth','role:admin'])->group(function(){
    //Route::get('admin/dashboard', [\App\Http\Controllers\AdminRequestController::class,'index'])->name('admin.dashboard');
    Route::get('admin/requests/{requestModel}', [\App\Http\Controllers\AdminRequestController::class,'show'])->name('admin.requests.show');
    Route::post('admin/requests/{requestModel}/decide', [\App\Http\Controllers\AdminRequestController::class,'decide'])->name('admin.requests.decide');
});


