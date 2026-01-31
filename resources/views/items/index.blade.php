@extends('layouts.app')

@section('title', 'Inventory Items')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 text-black">Inventory Items</h1>

    @if(auth()->user()->role === 'storekeeper' || auth()->user()->role === 'admin') 
        <button id="open-form" class="btn btn-orange">+ Add Item</button>
    @endif
</div>

<!-- Flash messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif  

<!-- Add/Edit Item Popup -->
@if(auth()->user()->role === 'storekeeper' || auth()->user()->role === 'admin') 
<div id="popup-form" class="card p-3 mb-3" style="display:none;">
    <form method="POST" action="{{ route('items.store') }}">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" placeholder="Item Name" required>
        </div>
        <div class="mb-3">
            <label>Quantity</label>
            <input type="number" name="quantity" class="form-control" placeholder="Quantity" min="0" required>
        </div>
        <div class="mb-3">
            <label>Price</label>
            <input type="number" step="0.01" name="price" class="form-control" placeholder="Price" min="0" required>
        </div>
        <button type="submit" class="btn btn-black">Save Item</button>
        <button type="button" id="close-form" class="btn btn-outline-dark">Close</button>
    </form>
</div>
@endif

<!-- Items Table -->
<table class="table table-striped table-bordered align-middle">
    <thead class="table-dark">
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ number_format($item->price,2) }}</td>
            <td>
                <a href="{{ route('items.history', $item) }}" class="btn btn-sm btn-outline-dark">History</a>
                @if(in_array(auth()->user()->role, ['storekeeper','admin']))
                    <button class="btn btn-sm btn-secondary" onclick="openEdit({{ $item->id }},'{{ $item->name }}','{{ $item->price }}')">Edit</button>
                    <form method="POST" action="{{ route('items.destroy',$item) }}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Restock Form -->
@if(auth()->user()->role === 'storekeeper' || auth()->user()->role === 'admin')     
<div class="card p-3 mt-4">
    <h3>Restock Item</h3>
    <form method="POST" action="{{ route('items.restock', ['item' => 0]) }}" id="restockForm">
        @csrf
        <div class="mb-3">
            <label for="item_id">Select Item</label>
            <select name="item_id" id="item_id" class="form-control" required>
                <option value="">-- Choose Item --</option>
                @foreach($items as $item)
                    <option value="{{ $item->id }}">{{ $item->name }} (Current: {{ $item->quantity }}, Price: {{ number_format($item->price,2) }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Quantity to Add</label>
            <input name="quantity" type="number" class="form-control" required min="1">
        </div>

        <div class="mb-3">
            <label>New Price (per unit)</label>
            <input name="price" type="number" step="0.01" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-black">Save</button>
    </form>
</div>
@endif
@endsection

@section('scripts')
<script>
document.getElementById('restockForm').addEventListener('submit', function(e){
    e.preventDefault();
    const itemId = document.getElementById('item_id').value;
    if(!itemId) {
        alert('Please choose an item.');
        return;
    }
    this.action = '/items/' + itemId + '/restock';
    this.submit();
});

// Popup toggle
document.getElementById('open-form').addEventListener('click', function() {
    document.getElementById('popup-form').style.display = 'block';
});
document.getElementById('close-form').addEventListener('click', function() {
    document.getElementById('popup-form').style.display = 'none';
});

// Edit function
function openEdit(id,name,price){
    document.getElementById('open-form').click();
    const form = document.querySelector('#popup-form form');
    form.action = '/items/' + id;
    if(!form.querySelector('input[name="_method"]')) {
        form.insertAdjacentHTML('beforeend','<input type="hidden" name="_method" value="PUT">');
    }
    form.querySelector('input[name="name"]').value = name;
    form.querySelector('input[name="price"]').value = price;
}
</script>
@endsection
