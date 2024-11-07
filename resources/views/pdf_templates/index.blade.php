{{-- resources/views/pdf-templates/index.blade.php --}}
@extends('layouts.app')

@section('title', 'PDF Templates')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">PDF Templates</h2>
        <a href="{{ route('pdf-templates.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Add New Template</a>
    </div>

    @if($templates->count())
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Created At</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($templates as $template)
                            <tr>
                                <td>{{ $template->name }}</td>
                                <td>{{ $template->created_at->format('d.m.Y') }}</td>
                                <td class="text-center">
                                    <x-action-buttons :template="$template" />
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $templates->links() }}
        </div>
    @else
        <div class="alert alert-warning text-center" role="alert">
            No PDF Templates found. <a href="{{ route('pdf-templates.create') }}" class="alert-link">Create one now!</a>
        </div>
    @endif
@endsection
