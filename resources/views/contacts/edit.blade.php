@extends('layouts.app')

@section('content')
    <h1>Edit Contact</h1>

    <form action="{{ route('contacts.update', $contact) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- First Name -->
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name*</label>
            <input type="text" name="first_name" class="form-control" id="first_name" value="{{ old('first_name', $contact->first_name) }}" required>
            @error('first_name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Last Name -->
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name*</label>
            <input type="text" name="last_name" class="form-control" id="last_name" value="{{ old('last_name', $contact->last_name) }}" required>
            @error('last_name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email*</label>
            <input type="email" name="email" class="form-control" id="email" value="{{ old('email', $contact->email) }}" required>
            @error('email')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Phone Number -->
        <div class="mb-3">
            <label for="phone_number" class="form-label">Phone Number</label>
            <input type="text" name="phone_number" class="form-control" id="phone_number" value="{{ old('phone_number', $contact->phone_number) }}">
            @error('phone_number')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Address -->
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" class="form-control" id="address" value="{{ old('address', $contact->address) }}">
            @error('address')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- City -->
        <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <input type="text" name="city" class="form-control" id="city" value="{{ old('city', $contact->city) }}">
            @error('city')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- State -->
        <div class="mb-3">
            <label for="state" class="form-label">State</label>
            <input type="text" name="state" class="form-control" id="state" value="{{ old('state', $contact->state) }}">
            @error('state')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Zip Code -->
        <div class="mb-3">
            <label for="zip_code" class="form-label">Zip Code</label>
            <input type="text" name="zip_code" class="form-control" id="zip_code" value="{{ old('zip_code', $contact->zip_code) }}">
            @error('zip_code')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Company Name -->
        <div class="mb-3">
            <label for="company_name" class="form-label">Company Name</label>
            <input type="text" name="company_name" class="form-control" id="company_name" value="{{ old('company_name', $contact->company_name) }}">
            @error('company_name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Website URL -->
        <div class="mb-3">
            <label for="website" class="form-label">Website URL</label>
            <input type="url" name="website" class="form-control" id="website" value="{{ old('website', $contact->website) }}">
            @error('website')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Notes -->
        <div class="mb-3">
            <label for="notes" class="form-label">Notes (optional)</label>
            <textarea name="notes" class="form-control" id="notes" rows="3">{{ old('notes', $contact->notes) }}</textarea>
            @error('notes')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Update Contact</button>
    </form>
@endsection
