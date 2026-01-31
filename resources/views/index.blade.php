@extends('layouts.app')
@section('title','Items Received')
@section('content')
<div class="d-flex justify-content-between mb-3">
  <h3>Items Received</h3>
  @if(auth()->user()->role=='storekeeper' || auth()->user()->role=='admin')
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addItemModal">Add Item</button>
  @endif
</div>

<table class="table table-bordered">
  <thead><tr><th>Code</th><th>Name</th><th>Qty</th><th>Price</th><th>Actions</th></tr></thead>
  <tbody>
    @foreach($items as $item)
    <tr>
      <td>{{ $item->id }}</td>
      <td><a href="{{ route('items.history', $item) }}">{{ $item->name }}</a></td>
      <td>{{ $item->quantity }}</td>
      <td>{{ number_format($item->price,2) }}</td>
      <td>
        @if(in_array(auth()->user()->role, ['storekeeper','admin']))
        <button class="btn btn-sm btn-secondary" onclick="openEdit({{ $item->id }},'{{ $item->name }}', '{{ $item->price }}')">Edit</button>
        <form method="POST" action="{{ route('items.destroy',$item) }}" style="display:inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Delete</button></form>
        @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

{{ $items->links() }}

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="addItemForm" class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Add Item</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <div class="mb-3"><label>Code</label><input name="code" class="form-control" required></div>
        <div class="mb-3"><label>Name</label><input name="name" class="form-control" required></div>
        <div class="mb-3"><label>Quantity</label><input name="quantity" type="number" value="0" class="form-control" required></div>
        <div class="mb-3"><label>Price</label><input name="price" type="number" step="0.01" value="0" class="form-control" required></div>
      </div>
      <div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button class="btn btn-primary">Save</button></div>
    </form>
  </div>
</div>

<!-- Edit modal can reuse fields -->
<div class="modal fade" id="editItemModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="editItemForm" class="modal-content" method="POST">
      <div class="modal-header"><h5 class="modal-title">Edit Item</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        @csrf
        @method('PUT')
        <div class="mb-3"><label>Name</label><input name="name" class="form-control" required></div>
        <div class="mb-3"><label>Price</label><input name="price" type="number" step="0.01" class="form-control" required></div>
      </div>
      <div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button class="btn btn-primary">Save</button></div>
    </form>
  </div>
</div>

@endsection

@section('scripts')
<script>
document.getElementById('addItemForm').addEventListener('submit', async function(e){
  e.preventDefault();
  const form = e.target;
  const data = Object.fromEntries(new FormData(form));
  const token = document.querySelector('meta[name="csrf-token"]').content;
  const res = await fetch("{{ route('items.store') }}", {
    method:'POST',
    headers: {'Content-Type':'application/json','X-CSRF-TOKEN':token},
    body: JSON.stringify(data)
  });
  const json = await res.json();
  if(json.status=='ok') location.reload();
  else alert('Error');
});

function openEdit(id,name,price){
  const modal = new bootstrap.Modal(document.getElementById('editItemModal'));
  const form = document.getElementById('editItemForm');
  form.action = '/items/'+id;
  form.querySelector('[name=name]').value = name;
  form.querySelector('[name=price]').value = price;
  modal.show();
}
</script>
@endsection
