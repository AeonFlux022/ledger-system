<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrower;
use Illuminate\Support\Facades\Storage;

class BorrowerController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'id_card' => 'required|string',
            'id_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'income' => 'required|numeric|min:0',
            'employment_status' => 'required|in:employed,unemployed',
        ]);

        if ($request->hasFile('id_image')) {
            $filename = time() . '.' . $request->file('id_image')->extension();

            // Save to storage/app/public/ids
            $path = $request->file('id_image')->storeAs('public/ids', $filename);

            // Save to DB as a browser-accessible path
            $validated['id_image'] = 'storage/ids/' . $filename;
        }


        Borrower::create($validated);

        return redirect('/borrowers-client')->with('success', 'Borrower added successfully.');
    }
}
