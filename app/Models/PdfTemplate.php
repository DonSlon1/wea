<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class PdfTemplate extends Model
    {
        use HasFactory;

        protected $fillable = [
            'name',
            'blade_template',
        ];

        public function invoices()
        {
            return $this->hasMany(Invoice::class);
        }
    }
