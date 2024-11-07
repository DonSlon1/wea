{{-- resources/views/contacts/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Add New Contact')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Add New Contact</h2>
            <a href="{{ route('contacts.index') }}" class="btn btn-secondary btn-sm" title="Back to Contacts">
                <i class="bi bi-arrow-left-circle"></i> Back
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('contacts.store') }}" method="POST" id="contactForm">
                @csrf

                {{-- First Name --}}
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                    <input type="text"
                           name="first_name"
                           class="form-control @error('first_name') is-invalid @enderror"
                           id="first_name"
                           value="{{ old('first_name') }}"
                           required
                           placeholder="Enter first name">
                    @error('first_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Last Name --}}
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                    <input type="text"
                           name="last_name"
                           class="form-control @error('last_name') is-invalid @enderror"
                           id="last_name"
                           value="{{ old('last_name') }}"
                           required
                           placeholder="Enter last name">
                    @error('last_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email"
                           name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           id="email"
                           value="{{ old('email') }}"
                           required
                           placeholder="Enter email address">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Phone Number --}}
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <input type="text"
                           name="phone_number"
                           class="form-control @error('phone_number') is-invalid @enderror"
                           id="phone_number"
                           value="{{ old('phone_number') }}"
                           placeholder="Enter phone number">
                    @error('phone_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Address --}}
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text"
                           name="address"
                           class="form-control @error('address') is-invalid @enderror"
                           id="address"
                           value="{{ old('address') }}"
                           placeholder="Enter address">
                    @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- City --}}
                <div class="mb-3">
                    <label for="city" class="form-label">City</label>
                    <input type="text"
                           name="city"
                           class="form-control @error('city') is-invalid @enderror"
                           id="city"
                           value="{{ old('city') }}"
                           placeholder="Enter city">
                    @error('city')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- State --}}
                <div class="mb-3">
                    <label for="state" class="form-label">State</label>
                    <input type="text"
                           name="state"
                           class="form-control @error('state') is-invalid @enderror"
                           id="state"
                           value="{{ old('state') }}"
                           placeholder="Enter state">
                    @error('state')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Zip Code --}}
                <div class="mb-3">
                    <label for="zip_code" class="form-label">Zip Code</label>
                    <input type="text"
                           name="zip_code"
                           class="form-control @error('zip_code') is-invalid @enderror"
                           id="zip_code"
                           value="{{ old('zip_code') }}"
                           placeholder="Enter zip code">
                    @error('zip_code')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Company Name --}}
                <div class="mb-3">
                    <label for="company_name" class="form-label">Company Name</label>
                    <input type="text"
                           name="company_name"
                           class="form-control @error('company_name') is-invalid @enderror"
                           id="company_name"
                           value="{{ old('company_name') }}"
                           placeholder="Enter company name">
                    @error('company_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Website URL --}}
                <div class="mb-3">
                    <label for="website" class="form-label">Website URL</label>
                    <input type="url"
                           name="website"
                           class="form-control @error('website') is-invalid @enderror"
                           id="website"
                           value="{{ old('website') }}"
                           placeholder="Enter website URL">
                    @error('website')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Notes --}}
                <div class="mb-3">
                    <label for="notes" class="form-label">Notes (optional)</label>
                    <textarea name="notes"
                              class="form-control @error('notes') is-invalid @enderror"
                              id="notes"
                              rows="3"
                              placeholder="Enter any additional notes">{{ old('notes') }}</textarea>
                    @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Add Contact</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            // Initialize Select2 if any select elements exist (none in this form)
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });

            // Optional: Implement client-side form validation or enhancements
        });
    </script>
@endpush
