<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        /* Import Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #f4f4f4;
            padding: 20px;
            text-align: center;
            border-bottom: 2px solid #ddd;
        }

        .header img {
            max-width: 150px;
            margin-bottom: 10px;
        }

        .company-details {
            text-align: center;
            margin-bottom: 20px;
        }

        .invoice-title {
            font-size: 2em;
            margin-bottom: 10px;
            color: #0066cc;
        }

        .invoice-details, .billing-details {
            width: 45%;
            float: left;
            margin-bottom: 20px;
        }

        .billing-details {
            float: right;
            text-align: right;
        }

        .clearfix {
            clear: both;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th {
            background-color: #0066cc;
            color: #fff;
            padding: 10px;
            text-align: left;
        }

        td {
            padding: 10px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .total-row td {
            font-weight: bold;
            background-color: #f4f4f4;
        }

        .footer {
            position: absolute;
            bottom: 30px;
            width: 100%;
            text-align: center;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>
<!-- Header with Logo -->
<div class="header">
    @if(file_exists(public_path('images/company_logo.png')))
        <img src="{{ public_path('images/company_logo.png') }}" alt="Company Logo">
    @else
        <h2>Your Company Name</h2>
    @endif
</div>

<!-- Invoice Title -->
<div class="company-details">
    <div class="invoice-title">Invoice</div>
    <div>Invoice Number: <strong>{{ $invoice->invoice_number }}</strong></div>
    <div>Date: {{ $invoice->invoice_date }}</div>
</div>

<div class="clearfix"></div>

<!-- Billing and Company Details -->
<div class="invoice-details">
    <h3>Bill To:</h3>
    <p>
        {{ $invoice->contact->first_name }} {{ $invoice->contact->last_name }}<br>
        @if($invoice->contact->company_name)
            {{ $invoice->contact->company_name }}<br>
        @endif
        @if($invoice->contact->address)
            {{ $invoice->contact->address }}<br>
        @endif
        @if($invoice->contact->city || $invoice->contact->state || $invoice->contact->zip_code)
            {{ $invoice->contact->city }}, {{ $invoice->contact->state }} {{ $invoice->contact->zip_code }}<br>
        @endif
        @if($invoice->contact->phone_number)
            Phone: {{ $invoice->contact->phone_number }}<br>
        @endif
        @if($invoice->contact->website)
            Website: {{ $invoice->contact->website }}<br>
        @endif
        Email: {{ $invoice->contact->email }}
    </p>
</div>
<div class="invoice-details">
    <h3>Your Company:</h3>
    <p>
        Your Company Name<br>
        1234 Street Address<br>
        City, State, ZIP<br>
        Phone: (555) 123-4567<br>
        Email: info@yourcompany.com<br>
        Website: www.yourcompany.com
    </p>
</div>

<div class="clearfix"></div>

<!-- Invoice Items Table -->
<h3>Invoice Details</h3>
<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Description</th>
        <th>Quantity</th>
        <th>Unit Price ($)</th>
        <th>Total ($)</th>
    </tr>
    </thead>
    <tbody>
    @foreach($invoice->items as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->description }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ number_format($item->unit_price, 2) }}</td>
            <td>{{ number_format($item->total, 2) }}</td>
        </tr>
    @endforeach
    <tr class="total-row">
        <td colspan="4" class="text-end">Total:</td>
        <td>${{ number_format($invoice->amount, 2) }}</td>
    </tr>
    </tbody>
</table>

<!-- Additional Notes (Optional) -->
@if($invoice->description)
    <div>
        <h4>Notes:</h4>
        <p>{{ $invoice->description }}</p>
    </div>
@endif

<!-- Footer -->
<div class="footer">
    <p>Your Company Name | 1234 Street Address, City, State, ZIP | Phone: (555) 123-4567 | Email: info@yourcompany.com | Website: www.yourcompany.com</p>
</div>
</body>
</html>
