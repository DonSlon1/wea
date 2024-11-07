{{-- resources/views/mail/statistics.blade.php --}}
@php
    use Carbon\Carbon;
@endphp

@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1 class="mb-0">Statistika odeslaných emailů</h1>
        </div>
        <div class="card-body">
            {{-- Filter Form --}}
            <form method="GET" action="{{ route('mail.statistics') }}" class="row g-3 mb-4">
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Od:</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date', $startDate) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">Do:</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date', $endDate) }}" required>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filtr</button>
                </div>
            </form>

            {{-- Statistics Summary --}}
            <h2 class="mb-4">Počet odeslaných emailů od
                {{ Carbon::parse($startDate)->format('d.m.Y') }}
                do
                {{ Carbon::parse($endDate)->format('d.m.Y') }}
            </h2>

            {{-- Chart Container --}}
            <div class="mb-5">
                <h4>Graf odeslaných emailů</h4>
                <canvas id="emailsChart" width="400" height="200"></canvas>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Prepare data for Chart.js
            const labels = [
                @foreach($statistics as $stat)
                    "{{ \Carbon\Carbon::parse($stat->date)->format('d.m.Y') }}",
                @endforeach
            ];

            const data = [
                @foreach($statistics as $stat)
                    {{ $stat->count }},
                @endforeach
            ];

            // Get the context of the canvas
            const ctx = document.getElementById('emailsChart').getContext('2d');

            // Create the Chart
            const emailsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Počet odeslaných emailů',
                        data: data,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        hoverBackgroundColor: 'rgba(54, 162, 235, 0.8)',
                        hoverBorderColor: 'rgba(54, 162, 235, 1)',
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            enabled: true,
                            mode: 'index',
                            intersect: false,
                        },
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Počet odeslaných emailů v čase'
                        }
                    },
                    interaction: {
                        mode: 'nearest',
                        axis: 'x',
                        intersect: false
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Datum'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Počet emailů'
                            },
                            ticks: {
                                precision:0 // Ensure whole numbers
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
