{{-- resources/views/contacts/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Contacts')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Contacts</h2>
        <a href="{{ route('contacts.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Add New Contact</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <div>
                {{ session('success') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($contacts->count())
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Company Name</th>
                            <th>Website</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($contacts as $contact)
                            <tr>
                                <td>{{ $contact->first_name }} {{ $contact->last_name }}</td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ $contact->phone_number }}</td>
                                <td>{{ $contact->company_name }}</td>
                                <td>
                                    @if($contact->website)
                                        <a href="{{ $contact->website }}" target="_blank" rel="noopener noreferrer">{{ $contact->website }}</a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <x-contact-action-buttons :contact="$contact" />
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
            {{ $contacts->links() }}
        </div>
    @else
        <div class="alert alert-warning text-center" role="alert">
            No contacts found. <a href="{{ route('contacts.create') }}" class="alert-link">Add a new contact now!</a>
        </div>
    @endif
@endsection
