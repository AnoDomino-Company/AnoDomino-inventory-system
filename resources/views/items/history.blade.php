@extends('layouts.app')
@section('title', 'History of '.$item->name)

@section('content')
<div class="card shadow-sm mb-4">
    <div class="card-header bg-black text-white">
        <h3 class="mb-0">History of {{ $item->name }}</h3>
    </div>
    <div class="card-body">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Balance</th>
                    <th>Price</th>
                    <th>User</th>
                </tr>
            </thead>
            <tbody>
                @foreach($histories as $h)
                    <tr>
                        <td>{{ $h->date }}</td>
                        <td>
                            @if($h->type === 'restock')
                                <span class="badge bg-orange">{{ ucfirst($h->type) }}</span>
                            @elseif($h->type === 'issue')
                                <span class="badge bg-danger">{{ ucfirst($h->type) }}</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($h->type) }}</span>
                            @endif
                        </td>
                        <td>{{ $h->quantity }}</td>
                        <td>{{ $h->balance }}</td>
                        <td>{{ number_format($h->price, 2) }}</td>
                        <td>{{ $h->user }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('items.index') }}" class="btn btn-outline-dark mt-3">Back to Items</a>
    </div>
</div>
@endsection
