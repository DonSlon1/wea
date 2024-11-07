<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        /* Basic styles for PDF */
        body { font-family: DejaVu Sans, sans-serif; }
        .header { text-align: center; margin-bottom: 50px; }
        .details { margin-bottom: 20px; }
        .details p { margin: 5px 0; }
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
    <p><strong>Amount:</strong> ${{ number_format($invoice->amount, 2) }}</p>
    <p><strong>Description:</strong> {{ $invoice->description }}</p>
    <p><strong>Template:</strong> {{ $invoice->pdfTemplate->name }}</p>
</div>

<div class="footer">
    <p>Thank you for your business!</p>
</div>
</body>
</html>
