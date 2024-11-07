@extends('layouts.app')

@section('content')
    <h1>Send Email</h1>

    <form action="{{ route('mail.send') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- If an invoice is provided, associate it with the email -->
        @if($invoice)
            <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
            <div class="mb-3">
                <label class="form-label">Invoice:</label>
                <p><strong>{{ $invoice->invoice_number }}</strong> - {{ $invoice->description }}</p>
            </div>
        @else
            <!-- Option to Select Invoice (from Email Tab) -->
            <div class="mb-3">
                <label for="invoice_id" class="form-label">Select Invoice (optional)</label>
                <select name="invoice_id" id="invoice_id" class="form-control select2">
                    <option value="">-- Select Invoice --</option>
                    @foreach($invoices as $inv)
                        <option value="{{ $inv->id }}" {{ old('invoice_id') == $inv->id ? 'selected' : '' }}>
                            {{ $inv->invoice_number }} - {{ $inv->description }}
                        </option>
                    @endforeach
                </select>
                @error('invoice_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        @endif

        <!-- Recipients -->
        <div class="mb-3">
            <label for="recipients" class="form-label">Recipients</label>
            <select name="recipients[]" id="recipients" class="form-control select2" multiple required>
                @foreach($contacts as $contact)
                    <option value="{{ $contact->email }}" {{ ((collect(old('recipients'))->contains($contact->email)) || $contact->id == $invoice?->contact_id) ? 'selected' : '' }}>
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
            <input type="text" name="subject" class="form-control" id="subject" value="{{ old('subject', $invoice ? 'Your Invoice ' . $invoice->invoice_number : '') }}" required>
            @error('subject')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Body -->
        <div class="mb-3">
            <label for="body" class="form-label">Body</label>
            <textarea name="body" class="form-control summernote" id="body" required>{{ old('body', $invoice ? 'Please find attached your invoice.' : 'Please find attached your invoice.') }}</textarea>
            @error('body')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Alt Body -->
        <div class="mb-3">
            <label for="alt_body" class="form-label">Alt Body (optional)</label>
            <textarea name="alt_body" class="form-control" id="alt_body">{{ old('alt_body', $invoice ? 'Please find attached your invoice.' : 'Please find attached your invoice.' ) }}</textarea>
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

        <button type="submit" class="btn btn-primary mt-3">Send Email</button>
    </form>
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
