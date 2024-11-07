@extends('layouts.app')

@section('content')
    <h1>Create Invoice</h1>

    <form action="{{ route('invoices.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="invoice_number" class="form-label">Invoice Number</label>
            <input type="text" name="invoice_number" class="form-control" id="invoice_number" value="{{ old('invoice_number') }}" required>
        </div>
        <div class="mb-3">
            <label for="invoice_date" class="form-label">Invoice Date</label>
            <input type="date" name="invoice_date" class="form-control" id="invoice_date" value="{{ old('invoice_date') }}" required>
        </div>
        <div class="mb-3">
            <label for="amount" class="form-label">Amount ($)</label>
            <input type="number" step="0.01" name="amount" class="form-control" id="amount" value="{{ old('amount') }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description (optional)</label>
            <textarea name="description" class="form-control" id="description">{{ old('description') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="pdf_template_id" class="form-label">PDF Template</label>
            <select name="pdf_template_id" id="pdf_template_id" class="form-control select2" required>
                <option value="">Select Template</option>
                @foreach($pdfTemplates as $template)
                    <option value="{{ $template->id }}" {{ old('pdf_template_id') == $template->id ? 'selected' : '' }}>{{ $template->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create Invoice</button>
    </form>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush
