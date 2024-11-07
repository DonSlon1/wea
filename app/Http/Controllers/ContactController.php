<?php

    namespace App\Http\Controllers;

    use App\Models\Contact;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;

    class ContactController extends Controller
    {
        /**
         * Display a listing of the contacts.
         */
        public function index()
        {
            // Fetch all contacts with pagination (e.g., 10 per page)
            $contacts = Contact::paginate(10);

            return view('contacts.index', compact('contacts'));
        }

        /**
         * Show the form for creating a new contact.
         */
        public function create()
        {
            return view('contacts.create');
        }

        /**
         * Store a newly created contact in storage.
         */
        public function store(Request $request)
        {
            // Validate the incoming request data
            $request->validate([
                'first_name'     => 'required|string|max:255',
                'last_name'      => 'required|string|max:255',
                'email'          => 'required|email|unique:contacts,email',
                'phone_number'   => 'nullable|string|max:20',
                'address'        => 'nullable|string|max:255',
                'city'           => 'nullable|string|max:100',
                'state'          => 'nullable|string|max:100',
                'zip_code'       => 'nullable|string|max:20',
                'company_name'   => 'nullable|string|max:255',
                'website'        => 'nullable|url|max:255',
                'notes'          => 'nullable|string',
            ]);

            try {
                // Create a new contact
                Contact::create($request->all());

                return redirect()->route('contacts.index')->with('success', 'Contact created successfully.');
            } catch (\Exception $e) {
                // Log the error for debugging
                Log::error('Error creating contact: ' . $e->getMessage());

                return redirect()->back()->with('error', 'Failed to create contact. Please try again.')->withInput();
            }
        }

        /**
         * Display the specified contact.
         */
        public function show(Contact $contact)
        {
            return view('contacts.show', compact('contact'));
        }

        /**
         * Show the form for editing the specified contact.
         */
        public function edit(Contact $contact)
        {
            return view('contacts.edit', compact('contact'));
        }

        /**
         * Update the specified contact in storage.
         */
        public function update(Request $request, Contact $contact)
        {
            // Validate the incoming request data
            $request->validate([
                'first_name'     => 'required|string|max:255',
                'last_name'      => 'required|string|max:255',
                'email'          => 'required|email|unique:contacts,email,' . $contact->id,
                'phone_number'   => 'nullable|string|max:20',
                'address'        => 'nullable|string|max:255',
                'city'           => 'nullable|string|max:100',
                'state'          => 'nullable|string|max:100',
                'zip_code'       => 'nullable|string|max:20',
                'company_name'   => 'nullable|string|max:255',
                'website'        => 'nullable|url|max:255',
                'notes'          => 'nullable|string',
            ]);

            try {
                // Update the contact with validated data
                $contact->update($request->all());

                return redirect()->route('contacts.index')->with('success', 'Contact updated successfully.');
            } catch (\Exception $e) {
                // Log the error for debugging
                Log::error('Error updating contact: ' . $e->getMessage());

                return redirect()->back()->with('error', 'Failed to update contact. Please try again.')->withInput();
            }
        }

        /**
         * Remove the specified contact from storage.
         */
        public function destroy(Contact $contact)
        {
            try {
                $contact->delete();

                return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully.');
            } catch (\Exception $e) {
                // Log the error for debugging
                Log::error('Error deleting contact: ' . $e->getMessage());

                return redirect()->back()->with('error', 'Failed to delete contact. Please try again.');
            }
        }
    }
