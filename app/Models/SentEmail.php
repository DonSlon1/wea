<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class SentEmail extends Model
    {
        use HasFactory;

        protected $fillable = ['recipients', 'subject', 'body', 'alt_body', 'attachments'];

        protected $casts = [
            'recipients' => 'array',
            'attachments' => 'array',
        ];
    }
