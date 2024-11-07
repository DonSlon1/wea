<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * Zobrazí seznam kontaktů.
     */
    public function index()
    {
        $contacts = Contact::orderBy('first_name')->get();
        return view('contacts.index', compact('contacts'));
    }

    /**
     * Zobrazí formulář pro vytvoření nového kontaktu.
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Uloží nový kontakt do databáze.
     */
    public function store(Request $request)
    {
        // Validace vstupů
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:contacts,email',
        ]);

        // Vytvoření nového kontaktu
        Contact::create([
            'first_name' => $request->input('first_name'),
            'last_name'  => $request->input('last_name'),
            'email'      => $request->input('email'),
        ]);

        // Přesměrování zpět s úspěšnou zprávou
        return redirect()->route('contacts.index')->with('success', 'Kontakt byl úspěšně přidán.');
    }

    // Volitelné: Metody show, edit, update, destroy mohou být přidány později, pokud budou potřeba
}
