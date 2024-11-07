@extends('layouts.app')

@section('content')
    <h1>Invoice: {{ $invoice->invoice_number }}</h1>

    <a href="{{ route('invoices.download', $invoice) }}" class="btn btn-success mb-3">Download PDF</a>
    <a href="{{ route('invoices.index') }}" class="btn btn-secondary mb-3">Back to Invoices</a>

    <div class="card">
        <div class="card-body">
            <p><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
            <p><strong>Date:</strong> {{ $invoice->invoice_date }}</p>
            <p><strong>Amount:</strong> ${{ number_format($invoice->amount, 2) }}</p>
            <p><strong>Description:</strong> {{ $invoice->description }}</p>
            <p><strong>PDF Template:</strong> {{ $invoice->pdfTemplate->name }}</p>
        </div>
    </div>
@endsection
