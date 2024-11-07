@extends('layouts.app')

@section('content')
    <h1>Add New PDF Template</h1>

    <form action="{{ route('pdf-templates.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Template Name</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label for="blade_template" class="form-label">Blade Template Content</label>
            <textarea name="blade_template" class="form-control" id="blade_template" rows="10" required>{{ old('blade_template') }}</textarea>
            <small class="form-text text-muted">Use Blade syntax. Variables you can use: <code>$invoice</code>.</small>
        </div>
        <button type="submit" class="btn btn-primary">Create Template</button>
    </form>
@endsection
