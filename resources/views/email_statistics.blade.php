@extends('layouts.app')

@section('content')
    <h1>Statistika odeslaných emailů</h1>

    <form method="GET" action="{{ route('mail.statistics') }}" class="row g-3 mb-4">
        <div class="col-md-4">
            <label for="start_date" class="form-label">Od:</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate }}">
        </div>
        <div class="col-md-4">
            <label for="end_date" class="form-label">Do:</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate }}">
        </div>
        <div class="col-md-4 align-self-end">
            <button type="submit" class="btn btn-primary">Filtr</button>
        </div>
    </form>

    <h2>Počet odeslaných emailů od {{ \Carbon\Carbon::parse($startDate)->format('d.m.Y') }} do {{ \Carbon\Carbon::parse($endDate)->format('d.m.Y') }}</h2>

    <ul class="peity-bar">
        @foreach($statistics as $stat)
            <li>{{ $stat->count }},</li>
        @endforeach
    </ul>
@endsection

@push('scripts')
    <script>
        $(function() {
            $(".peity-bar").peity("bar", { width: 300, height: 100, delimiter: ',', min: 0 });
        });
    </script>
@endpush
