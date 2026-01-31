@extends('layouts.app')
@section('title','New Request')
@section('content')
<div class="card shadow-sm mb-4">
    <div class="card-header bg-black text-white">
        <h3 class="mb-0">New Request</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('requests.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Supervisor</label>
                <select name="supervisor_id" class="form-select" required>
                    @foreach($supervisors as $s)
                        <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->email }})</option>
                    @endforeach
                </select>
            </div>

            <table class="table table-striped align-middle" id="itemsTable">
                <thead class="table-dark">
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>
                            <button type="button" class="btn btn-sm btn-orange" onclick="addRow()">+ Add Row</button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input list="itemsList" class="form-control item-input" oninput="onItemSelect(this)" placeholder="type or choose">
                            <datalist id="itemsList">
                                @foreach($items as $it)
                                    <option data-id="{{ $it->id }}" value="{{ $it->name }}"></option>
                                @endforeach
                            </datalist>
                            <input type="hidden" name="items[0][item_id]" class="item-id">
                        </td>
                        <td>
                            <input type="number" name="items[0][quantity]" class="form-control" min="1" value="1" required>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Remove</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <button type="submit" class="btn btn-orange">Submit Request</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
let rowIndex = 1;
function addRow(){
    const tbody = document.querySelector('#itemsTable tbody');
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td>
            <input list="itemsList" class="form-control item-input" oninput="onItemSelect(this)" placeholder="type or choose">
            <input type="hidden" name="items[${rowIndex}][item_id]" class="item-id">
        </td>
        <td>
            <input type="number" name="items[${rowIndex}][quantity]" class="form-control" min="1" value="1" required>
        </td>
        <td>
            <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Remove</button>
        </td>
    `;
    tbody.appendChild(tr);
    rowIndex++;
}

function removeRow(btn){
    btn.closest('tr').remove();
}

function onItemSelect(input){
    const list = document.getElementById('itemsList');
    const val = input.value;
    const opts = Array.from(list.options);
    const matched = opts.find(o => o.value === val);
    const hidden = input.closest('td').querySelector('.item-id');
    if(matched) {
        hidden.value = matched.dataset.id;
    } else {
        fetch('{{ route("api.items.search") }}?q=' + encodeURIComponent(val))
            .then(r => r.json())
            .then(data => {
                if(data.length && !hidden.value){
                    hidden.value = data[0].id;
                }
            });
    }
}
</script>
@endsection
