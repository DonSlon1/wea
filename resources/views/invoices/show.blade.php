{{-- resources/views/invoices/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Invoice Details')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Invoice: {{ $invoice->invoice_number }}</h2>
            <div>
                <a href="{{ route('invoices.download', $invoice) }}" class="btn btn-success btn-sm me-2" title="Download PDF"><i class="bi bi-download"></i> Download PDF</a>
                <a href="{{ route('invoices.preview', $invoice) }}" target="_blank" class="btn btn-info btn-sm me-2" title="Open Preview"><i class="bi bi-eye-fill"></i> Preview</a>
                <a href="{{ route('mail.create', ['invoice_id' => $invoice->id]) }}" class="btn btn-primary btn-sm me-2" title="Send via Email"><i class="bi bi-envelope-fill"></i> Send Email</a>
                <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this invoice?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" title="Delete Invoice"><i class="bi bi-trash-fill"></i> Delete</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            {{-- Invoice Overview --}}
            <div class="row mb-4">
                {{-- Billing Information --}}
                <div class="col-md-6">
                    <h5>Bill To:</h5>
                    <p>
                        <strong>{{ $invoice->contact->first_name }} {{ $invoice->contact->last_name }}</strong><br>
                        @if($invoice->contact->company_name)
                            {{ $invoice->contact->company_name }}<br>
                        @endif
                        @if($invoice->contact->address)
                            {{ $invoice->contact->address }}<br>
                        @endif
                        @if($invoice->contact->city || $invoice->contact->state || $invoice->contact->zip_code)
                            {{ $invoice->contact->city }}, {{ $invoice->contact->state }} {{ $invoice->contact->zip_code }}<br>
                        @endif
                        @if($invoice->contact->phone_number)
                            Phone: {{ $invoice->contact->phone_number }}<br>
                        @endif
                        @if($invoice->contact->website)
                            Website: {{ $invoice->contact->website }}<br>
                        @endif
                        Email: {{ $invoice->contact->email }}
                    </p>
                </div>

                {{-- Company Information --}}
                <div class="col-md-6 text-md-end">
                    <h5>Your Company:</h5>
                    <p>
                        <strong>Your Company Name</strong><br>
                        1234 Street Address<br>
                        City, State, ZIP<br>
                        Phone: (555) 123-4567<br>
                        Email: info@yourcompany.com<br>
                        Website: www.yourcompany.com
                    </p>
                </div>
            </div>

            {{-- Invoice Details --}}
            <h5>Invoice Details</h5>
            <p>
                <strong>Invoice Number:</strong> {{ $invoice->invoice_number }}<br>
                <strong>Date:</strong> {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d.m.Y') }}<br>
                <strong>Amount:</strong> ${{ number_format($invoice->amount, 2) }}<br>
                <strong>Description:</strong> {{ $invoice->description ?? 'N/A' }}<br>
                <strong>PDF Template:</strong> {{ $invoice->pdfTemplate->name }}
            </p>

            {{-- Invoice Items --}}
            <h5 class="mt-4">Items</h5>
            @if($invoice->items->count())
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Unit Price ($)</th>
                        <th>Total ($)</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invoice->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->unit_price, 2) }}</td>
                            <td>{{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="table-secondary">
                        <td colspan="4" class="text-end"><strong>Total:</strong></td>
                        <td><strong>${{ number_format($invoice->amount, 2) }}</strong></td>
                    </tr>
                    </tbody>
                </table>
            @else
                <p>No items found for this invoice.</p>
            @endif

            {{-- PDF Preview --}}
            <h5 class="mt-5">PDF Preview</h5>
            <div class="ratio ratio-16x9">
                <iframe src="{{ route('invoices.preview', $invoice) }}" title="Invoice PDF Preview" allowfullscreen></iframe>
            </div>
        </div>
    </div>
@endsection
