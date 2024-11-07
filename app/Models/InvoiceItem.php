<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class InvoiceItem extends Model
    {
        use HasFactory;

        protected $fillable = [
            'invoice_id',
            'description',
            'quantity',
            'unit_price',
        ];

        public function invoice()
        {
            return $this->belongsTo(Invoice::class);
        }

        /**
         * Accessor to calculate the total price for the item.
         */
        public function getTotalAttribute()
        {
            return $this->quantity * $this->unit_price;
        }
    }
