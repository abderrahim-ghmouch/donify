<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use Illuminate\Http\Request;

class OrganisationController extends Controller
{
    /**
     * List all verified organisations (public)
     */
    public function index()
    {
        $organisations = Organisation::where('is_verified', true)->get();

        return response()->json([
            'status' => 'success',
            'data' => $organisations
        ]);
    }

    /**
     * Show a single organisation (public)
     */
    public function show($id)
    {
        $organisation = Organisation::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $organisation
        ]);
    }

    /**
     * Register a new organisation (public - no auth needed)
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'email'       => 'required|email|unique:organisations,email',
            'phone'       => 'required|string|max:20',
            'address'     => 'required|string',
            'logo'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'document'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // Handle logo (profile image)
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = asset('storage/' . $request->file('logo')->store('organisations/logos', 'public'));
        }

        // Handle verification document
        $documentPath = null;
        if ($request->hasFile('document')) {
            $documentPath = asset('storage/' . $request->file('document')->store('organisations/documents', 'public'));
        }

        $organisation = Organisation::create([
            'name'          => $validated['name'],
            'description'   => $validated['description'] ?? null,
            'email'         => $validated['email'],
            'phone'         => $validated['phone'],
            'address'       => $validated['address'],
            'logo'          => $logoPath,
            'document_path' => $documentPath,
            'is_verified'   => false,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Organisation registered. Awaiting admin verification.',
            'data'    => $organisation
        ], 201);
    }

    public function verify($id)
    {
        $organisation = Organisation::findOrFail($id);
        $organisation->update(['is_verified' => true]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Organisation has been verified.',
            'data'    => $organisation
        ]);
    }

    /**
     * Admin: reject/unverify an organisation
     */
    public function reject($id)
    {
        $organisation = Organisation::findOrFail($id);
        $organisation->update(['is_verified' => false]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Organisation has been rejected.',
            'data'    => $organisation
        ]);
    }

    /**
     * Admin: list all pending (unverified) organisations
     */
    public function pending()
    {
        $organisations = Organisation::where('is_verified', false)->get();

        return response()->json([
            'status' => 'success',
            'data'   => $organisations
        ]);
    }
}
