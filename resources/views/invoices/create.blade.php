{{-- resources/views/invoices/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Create Invoice')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0">Create New Invoice</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('invoices.store') }}" method="POST">
                @csrf
                {{-- Invoice Number --}}
                <div class="mb-3">
                    <label for="invoice_number" class="form-label">Invoice Number <span class="text-danger">*</span></label>
                    <input type="text" name="invoice_number" class="form-control @error('invoice_number') is-invalid @enderror" id="invoice_number" value="{{ old('invoice_number') }}" required>
                    @error('invoice_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Invoice Date --}}
                <div class="mb-3">
                    <label for="invoice_date" class="form-label">Invoice Date <span class="text-danger">*</span></label>
                    <input type="date" name="invoice_date" class="form-control @error('invoice_date') is-invalid @enderror" id="invoice_date" value="{{ old('invoice_date') }}" required>
                    @error('invoice_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label for="description" class="form-label">Description (optional)</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Contact Selection --}}
                <div class="mb-3">
                    <label for="contact_id" class="form-label">Contact <span class="text-danger">*</span></label>
                    <select name="contact_id" id="contact_id" class="form-select select2 @error('contact_id') is-invalid @enderror" required>
                        <option value="">Select Contact</option>
                        @foreach($contacts as $contact)
                            <option value="{{ $contact->id }}" {{ old('contact_id') == $contact->id ? 'selected' : '' }}>
                                {{ $contact->first_name }} {{ $contact->last_name }} ({{ $contact->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('contact_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- PDF Template Selection --}}
                <div class="mb-3">
                    <label for="pdf_template_id" class="form-label">PDF Template <span class="text-danger">*</span></label>
                    <select name="pdf_template_id" id="pdf_template_id" class="form-select select2 @error('pdf_template_id') is-invalid @enderror" required>
                        <option value="">Select Template</option>
                        @foreach($pdfTemplates as $template)
                            <option value="{{ $template->id }}" {{ old('pdf_template_id') == $template->id ? 'selected' : '' }}>{{ $template->name }}</option>
                        @endforeach
                    </select>
                    @error('pdf_template_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Invoice Items --}}
                <h3 class="mt-4">Invoice Items</h3>
                <table class="table table-bordered" id="items_table">
                    <thead class="table-dark">
                    <tr>
                        <th>Description <span class="text-danger">*</span></th>
                        <th>Quantity <span class="text-danger">*</span></th>
                        <th>Unit Price ($) <span class="text-danger">*</span></th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(old('items'))
                        @foreach(old('items') as $index => $item)
                            <tr>
                                <td>
                                    <input type="text" name="items[{{ $index }}][description]" class="form-control @error('items.'.$index.'.description') is-invalid @enderror" value="{{ $item['description'] }}" required>
                                    @error('items.'.$index.'.description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" name="items[{{ $index }}][quantity]" class="form-control @error('items.'.$index.'.quantity') is-invalid @enderror" min="1" value="{{ $item['quantity'] }}" required>
                                    @error('items.'.$index.'.quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" step="0.01" name="items[{{ $index }}][unit_price]" class="form-control @error('items.'.$index.'.unit_price') is-invalid @enderror" min="0" value="{{ $item['unit_price'] }}" required>
                                    @error('items.'.$index.'.unit_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm remove-item"><i class="bi bi-x-circle"></i> Remove</button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>
                                <input type="text" name="items[0][description]" class="form-control" required>
                            </td>
                            <td>
                                <input type="number" name="items[0][quantity]" class="form-control" min="1" value="1" required>
                            </td>
                            <td>
                                <input type="number" step="0.01" name="items[0][unit_price]" class="form-control" min="0" value="0.00" required>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-item"><i class="bi bi-x-circle"></i> Remove</button>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                <button type="button" class="btn btn-secondary" id="add_item"><i class="bi bi-plus-circle"></i> Add Item</button>

                {{-- Submit Button --}}
                <button type="submit" class="btn btn-primary mt-3"><i class="bi bi-save"></i> Create Invoice</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });

            // Initialize itemIndex based on existing items
            let itemIndex = {{ old('items') ? count(old('items')) : 1 }};

            // Add new invoice item row
            $('#add_item').click(function(){
                let newRow = `
                    <tr>
                        <td>
                            <input type="text" name="items[${itemIndex}][description]" class="form-control" required>
                        </td>
                        <td>
                            <input type="number" name="items[${itemIndex}][quantity]" class="form-control" min="1" value="1" required>
                        </td>
                        <td>
                            <input type="number" step="0.01" name="items[${itemIndex}][unit_price]" class="form-control" min="0" value="0.00" required>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-item"><i class="bi bi-x-circle"></i> Remove</button>
                        </td>
                    </tr>
                `;
                $('#items_table tbody').append(newRow);
                itemIndex++;
            });

            // Remove invoice item row
            $(document).on('click', '.remove-item', function(){
                $(this).closest('tr').remove();
            });
        });
    </script>
@endpush
