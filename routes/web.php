<?php

    use App\Http\Controllers\InvoiceController;
    use App\Http\Controllers\PdfTemplateController;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\MailController;
    use App\Http\Controllers\ContactController;
    use App\Http\Controllers\PdfController;

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    */

// Stránka pro odesílání emailů
    Route::get('/', [MailController::class, 'create'])->name('mail.create');
    Route::post('/send', [MailController::class, 'send'])->name('mail.send');
    Route::get('/sent-emails', [MailController::class, 'sentEmails'])->name('mail.sentEmails');
    Route::get('/statistics', [MailController::class, 'emailStatistics'])->name('mail.statistics');

// Správa kontaktů
    Route::resource('contacts', ContactController::class);

// Invoice Routes
    Route::resource('invoices', InvoiceController::class);

// PDF Template Routes
    Route::resource('pdf-templates', PdfTemplateController::class);

// Route to download PDF
    Route::get('invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');
    Route::get('invoices/{invoice}/preview', [InvoiceController::class, 'preview'])->name('invoices.preview');
