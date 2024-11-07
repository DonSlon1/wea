@extends('layouts.app')

@section('content')
    <h1>Invoice: {{ $invoice->invoice_number }}</h1>

    <div class="mb-3">
        <!-- Download PDF Button -->
        <a href="{{ route('invoices.download', $invoice) }}" class="btn btn-success">Download PDF</a>

        <!-- Send via Email Button (Triggers Modal) -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sendEmailModal">
            Send via Email
        </button>

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
        <iframe src="{{ route('invoices.showPdf', $invoice) }}" width="100%" height="100%" style="border: none;">
            This browser does not support PDFs. Please download the PDF to view it: <a href="{{ route('invoices.showPdf', $invoice) }}">Download PDF</a>.
        </iframe>
    </div>

    <!-- Send Email Modal -->
    <div class="modal fade" id="sendEmailModal" tabindex="-1" aria-labelledby="sendEmailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('mail.send') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- If sending from the invoice page, pass the invoice_id -->
                <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="sendEmailModalLabel">Send Invoice via Email</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Recipients -->
                        <div class="mb-3">
                            <label for="recipients" class="form-label">Recipients</label>
                            <select name="recipients[]" id="recipients" class="form-control select2" multiple required>
                                @foreach($contacts as $contact)
                                    <option value="{{ $contact->email }}" {{ (collect(old('recipients'))->contains($contact->email)) ? 'selected' : '' }}>
                                        {{ $contact->first_name }} {{ $contact->last_name }} ({{ $contact->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('recipients')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Subject -->
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-control" id="subject" value="{{ old('subject', 'Your Invoice ' . $invoice->invoice_number) }}" required>
                            @error('subject')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Body -->
                        <div class="mb-3">
                            <label for="body" class="form-label">Body</label>
                            <textarea name="body" class="form-control summernote" id="body" required>{{ old('body', 'Please find attached your invoice.') }}</textarea>
                            @error('body')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Alt Body -->
                        <div class="mb-3">
                            <label for="alt_body" class="form-label">Alt Body (optional)</label>
                            <textarea name="alt_body" class="form-control" id="alt_body">{{ old('alt_body', 'Please find attached your invoice.' ) }}</textarea>
                            @error('alt_body')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Attachments (Optional) -->
                        <div class="mb-3">
                            <label for="attachments" class="form-label">Additional Attachments (optional)</label>
                            <input type="file" name="attachments[]" class="form-control" id="attachments" multiple>
                            @error('attachments.*')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Existing Attachments -->
                        <div class="mb-3">
                            <label for="existing_attachments" class="form-label">Existing Attachments</label>
                            <select name="existing_attachments[]" id="existing_attachments" class="form-control select2" multiple>
                                @foreach($uploadedFiles as $file)
                                    <option value="{{ $file->path }}">{{ $file->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Option to Remove Invoice After Sending -->
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remove_after_send" name="remove_after_send" value="1">
                            <label class="form-check-label" for="remove_after_send">Remove this invoice after sending</label>
                        </div>

                        <!-- Error Display -->
                        @if ($errors->any())
                            <div class="alert alert-danger mt-3">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Send Email</button>
                    </div>
                </div>
            </form>
        </div>
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
