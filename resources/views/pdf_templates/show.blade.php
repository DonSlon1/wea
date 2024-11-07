{{-- resources/views/pdf-templates/show.blade.php --}}
@extends('layouts.app')

@section('title', 'View PDF Template')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">PDF Template: {{ $pdfTemplate->name }}</h2>
            <div>
                <a href="{{ route('pdf-templates.edit', $pdfTemplate) }}" class="btn btn-warning btn-sm me-2" title="Edit Template"><i class="bi bi-pencil-square"></i> Edit</a>
                <a href="{{ route('pdf-templates.index') }}" class="btn btn-secondary btn-sm me-2" title="Back to Templates"><i class="bi bi-arrow-left-circle"></i> Back</a>
            </div>
        </div>
        <div class="card-body">
            {{-- Blade Template Content --}}
            <h5>Blade Template Content</h5>
            <pre><code class="language-php">{{ htmlspecialchars($pdfTemplate->blade_template) }}</code></pre>
            <div class="form-text">
                This template uses Blade syntax. Variables you can use: <code>$invoice</code>.
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Initialize Prism.js for syntax highlighting --}}
    {{-- Assuming Prism.js is included in the layout as per previous recommendation --}}
    @if($pdfTemplate->blade_template)
        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
                Prism.highlightAll();
            });
        </script>
    @endif
@endpush
