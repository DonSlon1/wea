{{-- resources/views/mail/sent-emails.blade.php --}}

@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
@endphp
@extends('layouts.app')

@section('title', 'Sent Emails')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Sent Emails</h2>
            {{-- Future enhancements: Add filters or search functionality here --}}
        </div>
        <div class="card-body">
            @if($sentEmails->count())
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Recipients</th>
                            <th>Subject</th>
                            <th>Sent At</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sentEmails as $email)
                            <tr>
                                <td>{{ $email->id }}</td>
                                <td>
                                    @foreach($email->recipients as $recipient)
                                        {{ $recipient }}@if (!$loop->last), @endif
                                    @endforeach
                                </td>
                                <td>{{ Str::limit($email->subject, 50) }}</td>
                                <td>{{ $email->created_at->format('d.m.Y H:i') }}</td>
                                <td class="text-center">
                                    <!-- View Button triggers the email-detail-modal component -->
                                    <x-email-detail-modal :email="$email" />
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center mt-3">
                    {{ $sentEmails->links() }}
                </div>
            @else
                <div class="alert alert-warning text-center" role="alert">
                    No sent emails found.
                </div>
            @endif
        </div>
    </div>
@endsection
