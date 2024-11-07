{{-- resources/views/pdf-templates/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Add New PDF Template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0">Add New PDF Template</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('pdf-templates.store') }}" method="POST">
                @csrf

                {{-- Template Name --}}
                <div class="mb-4">
                    <label for="name" class="form-label">Template Name <span class="text-danger">*</span></label>
                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           id="name"
                           value="{{ old('name') }}"
                           required
                           placeholder="Enter template name">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Blade Template Content --}}
                <div class="mb-4">
                    <label for="blade_template" class="form-label">Blade Template Content <span class="text-danger">*</span></label>
                    <textarea name="blade_template"
                              class="form-control @error('blade_template') is-invalid @enderror"
                              id="blade_template"
                              rows="12"
                              required
                              placeholder="Enter Blade template content">{{ old('blade_template') }}</textarea>
                    @error('blade_template')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">
                        Use Blade syntax. Variables you can use: <code>$invoice</code>.
                    </div>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Create Template</button>
            </form>
        </div>
    </div>
@endsection
n

@push('scripts')
    <script>
        $(document).ready(function(){
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });

            // Initialize CodeMirror for Blade Template
            var editor = CodeMirror.fromTextArea(document.getElementById("blade_template"), {
                mode: "htmlmixed",
                theme: "monokai",
                lineNumbers: true,
                lineWrapping: true
            });

            // Adjust the textarea's height based on CodeMirror's height
            editor.setSize("100%", "400px");
        });
    </script>
@endpush
