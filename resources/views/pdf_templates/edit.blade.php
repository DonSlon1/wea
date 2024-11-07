@extends('layouts.app')

@section('content')
    <h1>Edit PDF Template: {{ $pdfTemplate->name }}</h1>

    <form action="{{ route('pdf-templates.update', $pdfTemplate) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Template Name</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $pdfTemplate->name) }}" required>
        </div>
        <div class="mb-3">
            <label for="blade_template" class="form-label">Blade Template Content</label>
            <textarea name="blade_template" class="form-control" id="blade_template" rows="10" required>{{ old('blade_template', $pdfTemplate->blade_template) }}</textarea>
            <small class="form-text text-muted">Use Blade syntax. Variables you can use: <code>$invoice</code>.</small>
        </div>
        <button type="submit" class="btn btn-primary">Update Template</button>
    </form>
@endsection
