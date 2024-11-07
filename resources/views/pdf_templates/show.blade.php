@extends('layouts.app')

@section('content')
    <h1>PDF Template: {{ $pdfTemplate->name }}</h1>

    <a href="{{ route('pdf-templates.edit', $pdfTemplate) }}" class="btn btn-warning mb-3">Edit Template</a>
    <a href="{{ route('pdf-templates.index') }}" class="btn btn-secondary mb-3">Back to Templates</a>

    <div class="card">
        <div class="card-body">
            <pre>{{ $pdfTemplate->blade_template }}</pre>
        </div>
    </div>
@endsection
