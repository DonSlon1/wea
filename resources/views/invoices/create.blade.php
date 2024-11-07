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

        <h3>Invoice Items</h3>
        <table class="table table-bordered" id="items_table">
            <thead>
            <tr>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit Price ($)</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @if(old('items'))
                @foreach(old('items') as $index => $item)
                    <tr>
                        <td>
                            <input type="text" name="items[{{ $index }}][description]" class="form-control" value="{{ $item['description'] }}" required>
                        </td>
                        <td>
                            <input type="number" name="items[{{ $index }}][quantity]" class="form-control quantity" min="1" value="{{ $item['quantity'] }}" required>
                        </td>
                        <td>
                            <input type="number" step="0.01" name="items[{{ $index }}][unit_price]" class="form-control unit_price" min="0" value="{{ $item['unit_price'] }}" required>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-item">Remove</button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td>
                        <input type="text" name="items[0][description]" class="form-control" required>
                    </td>
                    <td>
                        <input type="number" name="items[0][quantity]" class="form-control quantity" min="1" value="1" required>
                    </td>
                    <td>
                        <input type="number" step="0.01" name="items[0][unit_price]" class="form-control unit_price" min="0" value="0.00" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-item">Remove</button>
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
        <button type="button" class="btn btn-secondary" id="add_item">Add Item</button>

        <button type="submit" class="btn btn-primary mt-3">Create Invoice</button>
    </form>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            let itemIndex = {{ old('items') ? count(old('items')) : 1 }};

            $('#add_item').click(function(){
                let newRow = `
                <tr>
                    <td>
                        <input type="text" name="items[${itemIndex}][description]" class="form-control" required>
                    </td>
                    <td>
                        <input type="number" name="items[${itemIndex}][quantity]" class="form-control quantity" min="1" value="1" required>
                    </td>
                    <td>
                        <input type="number" step="0.01" name="items[${itemIndex}][unit_price]" class="form-control unit_price" min="0" value="0.00" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-item">Remove</button>
                    </td>
                </tr>
            `;
                $('#items_table tbody').append(newRow);
                itemIndex++;
            });

            $(document).on('click', '.remove-item', function(){
                $(this).closest('tr').remove();
            });
        });
    </script>
@endpush
