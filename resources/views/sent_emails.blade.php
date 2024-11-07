@extends('layouts.app')

@section('content')
    <h1>Odeslané Emaily</h1>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Příjemci</th>
            <th>Předmět</th>
            <th>Datum odeslání</th>
            <th>Akce</th>
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
                <td>{{ $email->subject }}</td>
                <td>{{ $email->created_at->format('d.m.Y H:i') }}</td>
                <td>
                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#emailModal{{ $email->id }}">Zobrazit</button>

                    <!-- Modal -->
                    <div class="modal fade" id="emailModal{{ $email->id }}" tabindex="-1" aria-labelledby="emailModalLabel{{ $email->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="emailModalLabel{{ $email->id }}">Detail Emailu</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Příjemci:</strong> {{ implode(', ', $email->recipients) }}</p>
                                    <p><strong>Předmět:</strong> {{ $email->subject }}</p>
                                    <p><strong>Text zprávy:</strong></p>
                                    <div>{!! $email->body !!}</div>
                                    @if($email->alt_body)
                                        <p><strong>Alternativní text:</strong></p>
                                        <div>{{ $email->alt_body }}</div>
                                    @endif
                                    @if($email->attachments)
                                        <p><strong>Přílohy:</strong></p>
                                        <ul>
                                            @foreach($email->attachments as $attachment)
                                                <li><a href="{{ Illuminate\Support\Facades\Storage::url($attachment['path']) }}" target="_blank">{{ $attachment['name'] }}</a></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $sentEmails->links() }}
@endsection
