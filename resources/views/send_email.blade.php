@extends('layouts.app')

@section('content')
    <h1>Send Email</h1>

    <form action="{{ route('mail.send') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @if($invoice)
            <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
            <div class="mb-3">
                <label class="form-label">Invoice:</label>
                <p><strong>{{ $invoice->invoice_number }}</strong> - {{ $invoice->description }}</p>
            </div>
        @endif

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

        <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" name="subject" class="form-control" id="subject" value="{{ old('subject') }}" required>
            @error('subject')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="body" class="form-label">Body</label>
            <textarea name="body" class="form-control summernote" id="body" required>{{ old('body') }}</textarea>
            @error('body')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="alt_body" class="form-label">Alt Body (optional)</label>
            <textarea name="alt_body" class="form-control" id="alt_body">{{ old('alt_body') }}</textarea>
            @error('alt_body')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        @if(!$invoice)
            <div class="mb-3">
                <label for="attachments" class="form-label">Attachments</label>
                <input type="file" name="attachments[]" class="form-control" id="attachments" multiple>
                @error('attachments.*')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="existing_attachments" class="form-label">Existing Attachments</label>
                <select name="existing_attachments[]" id="existing_attachments" class="form-control select2" multiple>
                    @foreach($uploadedFiles as $file)
                        <option value="{{ $file->path }}">{{ $file->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <button type="submit" class="btn btn-primary">Send Email</button>
    </form>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Inicializace Select2 pro příjemce
            $('#recipients').select2({
                placeholder: "Vyberte příjemce",
                allowClear: true
            });

            // Inicializace Select2 pro existující přílohy
            $('#existing_attachments').select2({
                placeholder: "Vyberte přílohy z nahraných souborů",
                allowClear: true
            });

            // Inicializace Summernote pro pole 'body'
            $('#body').summernote({
                height: 300,
                placeholder: 'Napište zde svůj text...',
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>
@endpush
