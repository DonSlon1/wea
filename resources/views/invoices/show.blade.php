@extends('layouts.app')

@section('content')
    <h1>Invoice: {{ $invoice->invoice_number }}</h1>

    <div class="mb-3">
        <!-- Download PDF Button -->
        <a href="{{ route('invoices.download', $invoice) }}" class="btn btn-success">Download PDF</a>
        <a href="{{ route('invoices.preview', $invoice) }}" target="_blank" class="btn btn-info">Open Preview</a>
        <a href="{{ route('mail.create', ['invoice_id' => $invoice->id]) }}" class="btn btn-primary">Send via Email</a>

        <!-- Delete Invoice Button -->
        <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this invoice?')">
                Delete Invoice
            </button>
        </form>

        <!-- Back to Invoices Button -->
        <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Back to Invoices</a>
    </div>

    <!-- Invoice Details -->
    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
            <p><strong>Date:</strong> {{ $invoice->invoice_date }}</p>
            <p><strong>Amount:</strong> ${{ number_format($invoice->amount, 2) }}</p>
            <p><strong>Description:</strong> {{ $invoice->description }}</p>
            <p><strong>Contact:</strong> {{ $invoice->contact->first_name }} {{ $invoice->contact->last_name }} ({{ $invoice->contact->email }})</p>
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
                <td><strong>{{ number_format($invoice->amount, 2) }}</strong></td>
            </tr>
            </tbody>
        </table>
    @else
        <p>No items found for this invoice.</p>
    @endif

    <!-- PDF Preview -->
    <h3 class="mt-5">PDF Preview</h3>
    <div class="iframe-container" style="width: 100%; height: 800px; border: 1px solid #ddd;">
        <iframe src="{{ route('invoices.preview', $invoice) }}" width="100%" height="100%" style="border: none;">
            This browser does not support PDFs. Please download the PDF to view it: <a href="{{ route('invoices.preview', $invoice) }}">Download PDF</a>.
        </iframe>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
            $('.summernote').summernote({
                height: 200
            });
        });
    </script>
@endpush
