@extends('layouts.app')

@section('content')
    <h1>Odeslat Email</h1>

    <form action="{{ route('mail.send') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Výběr příjemců --}}
        <div class="mb-3">
            <label for="recipients" class="form-label">Příjemci:</label>
            <select name="recipients[]" id="recipients" class="form-select" multiple="multiple" style="width: 100%;">
                @foreach($contacts as $contact)
                    <option value="{{ $contact->email }}">{{ $contact->first_name }} {{ $contact->last_name }} ({{ $contact->email }})</option>
                @endforeach
            </select>
            @error('recipients')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Předmět --}}
        <div class="mb-3">
            <label for="subject" class="form-label">Předmět:</label>
            <input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject') }}" required>
            @error('subject')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tělo zprávy --}}
        <div class="mb-3">
            <label for="body" class="form-label">Text zprávy:</label>
            <textarea name="body" id="body" class="form-control" rows="10">{{ old('body') }}</textarea>
            @error('body')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Alternativní text --}}
        <div class="mb-3">
            <label for="alt_body" class="form-label">Alternativní text (nepovinné):</label>
            <textarea name="alt_body" id="alt_body" class="form-control" rows="5">{{ old('alt_body') }}</textarea>
            @error('alt_body')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Přílohy nahrané z počítače --}}
        <div class="mb-3">
            <label for="attachments" class="form-label">Přílohy (nepovinné):</label>
            <input type="file" name="attachments[]" id="attachments" class="form-control" multiple>
            @error('attachments')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Výběr z existujících příloh --}}
        <div class="mb-3">
            <label for="existing_attachments" class="form-label">Vybrat z již nahraných příloh (nepovinné):</label>
            <select name="existing_attachments[]" id="existing_attachments" class="form-select" multiple="multiple" style="width: 100%;">
                @foreach($uploadedFiles as $file)
                    <option value="{{ $file->path }}">{{ $file->name }}</option>
                @endforeach
            </select>
            @error('existing_attachments')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Odeslat</button>
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
