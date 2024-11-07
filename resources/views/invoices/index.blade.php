@extends('layouts.app')

@section('content')
    <h1>Invoices</h1>
    <a href="{{ route('invoices.create') }}" class="btn btn-primary mb-3">Create New Invoice</a>

    @if($invoices->count())
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Invoice Number</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Template</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->invoice_date }}</td>
                    <td>${{ number_format($invoice->amount, 2) }}</td>
                    <td>{{ $invoice->pdfTemplate->name }}</td>
                    <td>
                        <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-warning btn-sm">Edit</a>
                        <a href="{{ route('invoices.download', $invoice) }}" class="btn btn-success btn-sm">Download PDF</a>
                        <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $invoices->links() }}
    @else
        <p>No invoices found.</p>
    @endif
@endsection
