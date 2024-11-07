@extends('layouts.app')

@section('content')
    <h1>Invoice: {{ $invoice->invoice_number }}</h1>

    <a href="{{ route('invoices.download', $invoice) }}" class="btn btn-success mb-3">Download PDF</a>
    <a href="{{ route('invoices.index') }}" class="btn btn-secondary mb-3">Back to Invoices</a>
    <a href="{{ route('mail.create', ['invoice_id' => $invoice->id]) }}" class="btn btn-primary mb-3">Send Invoice via Email</a>

    <div class="card">
        <div class="card-body">
            <p><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
            <p><strong>Date:</strong> {{ $invoice->invoice_date }}</p>
            <p><strong>Amount:</strong> ${{ number_format($invoice->amount, 2) }}</p>
            <p><strong>Description:</strong> {{ $invoice->description }}</p>
            <p><strong>PDF Template:</strong> {{ $invoice->pdfTemplate->name }}</p>
        </div>
    </div>

    <h3 class="mt-4">Items</h3>
    @if($invoice->items->count())
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit Price ($)</th>
                <th>Total ($)</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price, 2) }}</td>
                    <td>{{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                <td><strong>{{ number_format($invoice->amount, 2) }}</strong></td>
            </tr>
            </tbody>
        </table>
    @else
        <p>No items found for this invoice.</p>
    @endif
@endsection
