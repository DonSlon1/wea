@extends('layouts.app')

@section('content')
    <h1>Kontakty</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('contacts.create') }}" class="btn btn-primary mb-3">Přidat Kontakt</a>

    @if($contacts->count())
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Jméno</th>
                <th>Příjmení</th>
                <th>Email</th>
            </tr>
            </thead>
            <tbody>
            @foreach($contacts as $contact)
                <tr>
                    <td>{{ $contact->id }}</td>
                    <td>{{ $contact->first_name }}</td>
                    <td>{{ $contact->last_name }}</td>
                    <td>{{ $contact->email }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>Žádné kontakty nebyly nalezeny.</p>
    @endif
@endsection
