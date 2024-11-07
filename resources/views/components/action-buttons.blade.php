{{-- resources/views/components/action-buttons.blade.php --}}
<div class="btn-group" role="group" aria-label="Action Buttons">
    {{-- View Button --}}
    <a href="{{ route('pdf-templates.show', $template) }}" class="btn btn-info btn-sm me-1" title="View">
        <i class="bi bi-eye-fill"></i>
    </a>

    {{-- Edit Button --}}
    <a href="{{ route('pdf-templates.edit', $template) }}" class="btn btn-warning btn-sm me-1" title="Edit">
        <i class="bi bi-pencil-square"></i>
    </a>

    {{-- Delete Button with Modal --}}
    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $template->id }}" title="Delete">
        <i class="bi bi-trash-fill"></i>
    </button>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteModal{{ $template->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $template->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $template->id }}">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete the template "<strong>{{ $template->name }}</strong>"?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('pdf-templates.destroy', $template) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
