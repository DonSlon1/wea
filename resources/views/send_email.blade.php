{{-- resources/views/mail/send.blade.php --}}
@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
@endphp
@extends('layouts.app')


@section('title', 'Send Email')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0">Send Email</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('mail.send') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- If an invoice is provided, associate it with the email --}}
                @if($invoice)
                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                    <div class="mb-4">
                        <label class="form-label">Invoice:</label>
                        <p><strong>{{ $invoice->invoice_number }}</strong> - {{ $invoice->description }}</p>
                    </div>
                @else
                    {{-- Option to Select Invoice (from Email Tab) --}}
                    <div class="mb-4">
                        <label for="invoice_id" class="form-label">Select Invoice (optional)</label>
                        <select name="invoice_id" id="invoice_id" class="form-select select2">
                            <option value="">-- Select Invoice --</option>
                            @foreach($invoices as $inv)
                                <option value="{{ $inv->id }}" {{ old('invoice_id') == $inv->id ? 'selected' : '' }}>
                                    {{ $inv->invoice_number }} - {{ Str::limit($inv->description, 50) }}
                                </option>
                            @endforeach
                        </select>
                        @error('invoice_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                @endif

                {{-- Recipients --}}
                <div class="mb-4">
                    <label for="recipients" class="form-label">Recipients <span class="text-danger">*</span></label>
                    <select name="recipients[]" id="recipients" class="form-select select2" multiple required>
                        @foreach($contacts as $contact)
                            <option value="{{ $contact->email }}" {{ (collect(old('recipients'))->contains($contact->email) || ($invoice && $contact->id == $invoice->contact_id)) ? 'selected' : '' }}>
                                {{ $contact->first_name }} {{ $contact->last_name }} ({{ $contact->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('recipients')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Subject --}}
                <div class="mb-4">
                    <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                    <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" id="subject" value="{{ old('subject', $invoice ? 'Your Invoice ' . $invoice->invoice_number : '') }}" required placeholder="Enter email subject">
                    @error('subject')
                    <div class="invalid-feedback">{{ $message }}</div>
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

                {{-- Alt Body --}}
                <div class="mb-4">
                    <label for="alt_body" class="form-label">Alt Body (optional)</label>
                    <textarea name="alt_body" class="form-control @error('alt_body') is-invalid @enderror" id="alt_body" rows="3" placeholder="Enter alternative email body">{{ old('alt_body', $invoice ? 'Please find attached your invoice.' : '' ) }}</textarea>
                    @error('alt_body')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">
                        This is the plain-text version of the email body.
                    </div>
                </div>

                {{-- Attachments (Optional) --}}
                <div class="mb-4">
                    <label for="attachments" class="form-label">Additional Attachments (optional)</label>
                    <input type="file" name="attachments[]" class="form-control @error('attachments.*') is-invalid @enderror" id="attachments" multiple>
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

                {{-- Option to Remove Invoice After Sending --}}
                @if($invoice)
                    <div class="form-check mb-4">
                        <input type="checkbox" class="form-check-input" id="remove_after_send" name="remove_after_send" value="1">
                        <label class="form-check-label" for="remove_after_send">Remove this invoice after sending</label>
                    </div>
                @endif

                {{-- Submit Button --}}
                <button type="submit" class="btn btn-primary"><i class="bi bi-envelope-fill me-2"></i> Send Email</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
            $('.summernote').summernote({
                height: 300,
                placeholder: "Write your email content here...",
                toolbar: [
                    // Customized toolbar for better user experience
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['codeview', 'help']]
                ]
            });
        });
    </script>
@endpush
