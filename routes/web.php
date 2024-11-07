<?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\MailController;
    use App\Http\Controllers\ContactController;

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
    Route::resource('contacts', ContactController::class)->only(['index', 'create', 'store']);
