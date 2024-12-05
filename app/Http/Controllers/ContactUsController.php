<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    // Store a new Contact
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'gmail' => 'required|email',
            'mobile_number' => 'required|string',
            'facebook_link' => 'nullable|url',
            'instagram_link' => 'nullable|url',
            'telegram_link' => 'nullable|url',
            'whatsapp_link' => 'nullable|url',
        ]);

        $contact = ContactUs::create($validatedData);

        return response()->json([
            'status' => 201,
            'message' => 'Contact information saved successfully.',
            'contact' => $contact,
        ], 201);
    }

    // Retrieve all contacts
    public function index()
    {
        $contacts = ContactUs::all();

        return response()->json([
            'status' => 200,
            'message' => 'Contacts retrieved successfully.',
            'data' => $contacts,
        ]);
    }

    // Retrieve a specific contact (Edit)
    public function edit($id)
    {
        $contact = ContactUs::find($id);

        if (!$contact) {
            return response()->json([
                'status' => 404,
                'message' => 'Contact not found.',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Contact retrieved successfully.',
            'data' => $contact,
        ]);
    }

    // Update a specific contact
    public function update(Request $request, $id)
    {
        $contact = ContactUs::find($id);

        if (!$contact) {
            return response()->json([
                'status' => 404,
                'message' => 'Contact not found.',
            ], 404);
        }

        $validatedData = $request->validate([
            'gmail' => 'required|email',
            'mobile_number' => 'required|string',
            'facebook_link' => 'nullable|url',
            'instagram_link' => 'nullable|url',
            'telegram_link' => 'nullable|url',
            'whatsapp_link' => 'nullable|url',
        ]);

        $contact->update($validatedData);

        return response()->json([
            'status' => 200,
            'message' => 'Contact information updated successfully.',
            'data' => $contact,
        ]);
    }

    // Delete a specific contact
    public function destroy($id)
    {
        $contact = ContactUs::find($id);

        if (!$contact) {
            return response()->json([
                'status' => 404,
                'message' => 'Contact not found.',
            ], 404);
        }

        $contact->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Contact deleted successfully.',
        ]);
    }
}
