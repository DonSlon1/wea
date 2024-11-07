@extends('layouts.app')

@section('content')
    <h1>Invoice: {{ $invoice->invoice_number }}</h1>

    <div class="mb-3">
        <a href="{{ route('invoices.download', $invoice) }}" class="btn btn-success">Download PDF</a>
        <a href="{{ route('invoices.preview', $invoice) }}" target="_blank" class="btn btn-info">Open Preview</a>
        <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Back to Invoices</a>
        <a href="{{ route('mail.create', ['invoice_id' => $invoice->id]) }}" class="btn btn-primary">Send via Email</a>
    </div>

    <!-- Invoice Details -->
    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
            <p><strong>Date:</strong> {{ $invoice->invoice_date }}</p>
            <p><strong>Amount:</strong> ${{ number_format($invoice->amount, 2) }}</p>
            <p><strong>Description:</strong> {{ $invoice->description }}</p>
            <p><strong>PDF Template:</strong> {{ $invoice->pdfTemplate->name }}</p>
        </div>
    </div>

    <!-- Invoice Items -->
    <h3>Items</h3>
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
                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                <td><strong>${{ number_format($invoice->amount, 2) }}</strong></td>
            </tr>
            </tbody>
        </table>
    @else
        <p>No items found for this invoice.</p>
    @endif

    <!-- PDF Preview Section -->
    <h3 class="mt-5">PDF Preview</h3>
    <iframe src="{{ route('invoices.preview', $invoice) }}" width="100%" height="700px">
        Your browser does not support iframes.
    </iframe>
@endsection
