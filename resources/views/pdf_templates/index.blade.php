@extends('layouts.app')

@section('content')
    <h1>PDF Templates</h1>
    <a href="{{ route('pdf-templates.create') }}" class="btn btn-primary mb-3">Add New Template</a>

    @if($templates->count())
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($templates as $template)
                <tr>
                    <td>{{ $template->name }}</td>
                    <td>{{ $template->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('pdf-templates.show', $template) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('pdf-templates.edit', $template) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('pdf-templates.destroy', $template) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $templates->links() }}
    @else
        <p>No PDF Templates found.</p>
    @endif
@endsection
