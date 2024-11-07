<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Contact extends Model
    {
        use HasFactory;

        protected $fillable = [
            'first_name',
            'last_name',
            'email',
            'phone_number',
            'address',
            'city',
            'state',
            'zip_code',
            'company_name',
            'website',
            'notes',
        ];
    }
