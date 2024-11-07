<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Invoice extends Model
    {
        use HasFactory;

        protected $fillable = [
            'invoice_number',
            'invoice_date',
            'amount',
            'description',
            'pdf_template_id',
        ];

        public function pdfTemplate()
        {
            return $this->belongsTo(PdfTemplate::class);
        }

        public function items()
        {
            return $this->hasMany(InvoiceItem::class);
        }
    }
