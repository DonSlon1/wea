{{-- resources/views/contacts/show.blade.php --}}
@extends('layouts.app')

@section('title', 'View Contact')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Contact: {{ $contact->first_name }} {{ $contact->last_name }}</h2>
            <div>
                <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-warning btn-sm me-2" title="Edit Contact">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>
                <a href="{{ route('contacts.index') }}" class="btn btn-secondary btn-sm me-2" title="Back to Contacts">
                    <i class="bi bi-arrow-left-circle"></i> Back
                </a>
                <a href="{{ route('mail.create', ['contact_id' => $contact->id]) }}" class="btn btn-primary btn-sm me-2" title="Send Email">
                    <i class="bi bi-envelope-fill"></i> Send Email
                </a>
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $contact->id }}" title="Delete Contact">
                    <i class="bi bi-trash-fill"></i> Delete
                </button>
            </div>
        </div>
        <div class="card-body">
            {{-- Contact Overview --}}
            <div class="row mb-4">
                {{-- Contact Information --}}
                <div class="col-md-6">
                    <h5>Contact Information</h5>
                    <p>
                        <strong>Name:</strong> {{ $contact->first_name }} {{ $contact->last_name }}<br>
                        <strong>Email:</strong> {{ $contact->email }}<br>
                        @if($contact->phone_number)
                            <strong>Phone:</strong> {{ $contact->phone_number }}<br>
                        @endif
                        @if($contact->address)
                            <strong>Address:</strong> {{ $contact->address }}<br>
                        @endif
                        @if($contact->city || $contact->state || $contact->zip_code)
                            <strong>City/State/Zip:</strong> {{ $contact->city }}, {{ $contact->state }} {{ $contact->zip_code }}<br>
                        @endif
                        @if($contact->company_name)
                            <strong>Company:</strong> {{ $contact->company_name }}<br>
                        @endif
                        @if($contact->website)
                            <strong>Website:</strong> <a href="{{ $contact->website }}" target="_blank" rel="noopener noreferrer">{{ $contact->website }}</a><br>
                        @endif
                    </p>
                </div>

                {{-- Notes --}}
                <div class="col-md-6">
                    <h5>Notes</h5>
                    <p>
                        {{ $contact->notes ?? 'No additional notes.' }}
                    </p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="d-flex justify-content-end">
                <x-contact-action-buttons :contact="$contact" />
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div class="modal fade" id="deleteModal{{ $contact->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $contact->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="deleteModalLabel{{ $contact->id }}">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the contact "<strong>{{ $contact->first_name }} {{ $contact->last_name }}</strong>"?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('contacts.destroy', $contact) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Contact</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
