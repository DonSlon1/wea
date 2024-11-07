{{-- resources/views/invoices/index.blade.php --}}
@extends('layouts.app')

@section('title', 'All Invoices')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">All Invoices</h2>
            <a href="{{ route('invoices.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Create New Invoice</a>
        </div>
        <div class="card-body">
            @if($invoices->count())
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                        <tr>
                            <th>Invoice Number</th>
                            <th>Date</th>
                            <th>Amount ($)</th>
                            <th>Template</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d.m.Y') }}</td>
                                <td>{{ number_format($invoice->amount, 2) }}</td>
                                <td>{{ $invoice->pdfTemplate->name }}</td>
                                <td>
                                    <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-info btn-sm" title="View"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                    <a href="{{ route('invoices.download', $invoice) }}" class="btn btn-success btn-sm" title="Download PDF"><i class="bi bi-download"></i></a>
                                    <a href="{{ route('mail.create', ['invoice_id' => $invoice->id]) }}" class="btn btn-primary btn-sm" title="Send via Email"><i class="bi bi-envelope-fill"></i></a>
                                    <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this invoice?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete"><i class="bi bi-trash-fill"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center">
                    {{ $invoices->links() }}
                </div>
            @else
                <div class="alert alert-warning text-center" role="alert">
                    No invoices found. <a href="{{ route('invoices.create') }}" class="alert-link">Create one now!</a>
                </div>
            @endif
        </div>
    </div>
@endsection
