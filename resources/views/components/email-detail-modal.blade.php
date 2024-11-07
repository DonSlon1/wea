@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
@endphp
{{-- resources/views/components/email-detail-modal.blade.php --}}
<button class="btn btn-info btn-sm me-1" data-bs-toggle="modal" data-bs-target="#emailModal{{ $email->id }}" title="View Email">
    <i class="bi bi-eye-fill"></i> View
</button>

{{-- Email Detail Modal --}}
<div class="modal fade" id="emailModal{{ $email->id }}" tabindex="-1" aria-labelledby="emailModalLabel{{ $email->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="emailModalLabel{{ $email->id }}">Email Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>ID:</strong> {{ $email->id }}</p>
                <p><strong>Recipients:</strong> {{ implode(', ', $email->recipients) }}</p>
                <p><strong>Subject:</strong> {{ $email->subject }}</p>
                <p><strong>Sent At:</strong> {{ $email->created_at->format('d.m.Y H:i') }}</p>
                <hr>
                <p><strong>Body:</strong></p>
                <div class="mb-3">
                    {!! $email->body !!}
                </div>

                @if($email->alt_body)
                    <p><strong>Alternative Body:</strong></p>
                    <div class="mb-3">
                        {{ $email->alt_body }}
                    </div>
                @endif

                @if($email->attachments && is_array($email->attachments))
                    <p><strong>Attachments:</strong></p>
                    <ul>
                        @foreach($email->attachments as $attachment)
                            <li><a href="{{ Storage::url($attachment['path']) }}" target="_blank">{{ $attachment['name'] }}</a></li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                {{-- Future enhancements: Add resend email or other actions --}}
            </div>
        </div>
    </div>
</div>
