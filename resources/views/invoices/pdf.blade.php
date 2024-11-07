<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        /* Basic styles for PDF */
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 50px; }
        .details { margin-bottom: 20px; }
        .details p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 8px; text-align: left; }
        .footer { position: fixed; bottom: 0; text-align: center; font-size: 12px; }
    </style>
</head>
<body>
<div class="header">
    <h1>Invoice</h1>
    <h3>{{ $invoice->invoice_number }}</h3>
</div>

<div class="details">
    <p><strong>Date:</strong> {{ $invoice->invoice_date }}</p>
    <p><strong>Description:</strong> {{ $invoice->description }}</p>
    <p><strong>Template:</strong> {{ $invoice->pdfTemplate->name }}</p>
</div>

<h3>Items</h3>
<table>
    <thead>
    <tr>
        <th>Description</th>
        <th>Quantity</th>
        <th>Unit Price ($)</th>
        <th>Total ($)</th>
    </tr>
    </thead>
    <tbody>
    @foreach($invoice->items as $item)
        <tr>
            <td>{{ $item->description }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ number_format($item->unit_price, 2) }}</td>
            <td>{{ number_format($item->total, 2) }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
        <td><strong>{{ number_format($invoice->amount, 2) }}</strong></td>
    </tr>
    </tbody>
</table>

<div class="footer">
    <p>Thank you for your business!</p>
</div>
</body>
</html>
