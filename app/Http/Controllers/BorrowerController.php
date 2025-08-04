<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrower;
use Illuminate\Support\Facades\Storage;

class BorrowerController extends Controller
{


    // admin panel
    // view all borrowers in admin index side
    public function index()
    {
        session(['borrowers_previous_url' => url()->previous()]);

        // Use pagination: 10 borrowers per page, ordered by latest created
        $borrowers = Borrower::orderBy('created_at', 'desc')->paginate(10);

        return view('pages.admin.borrowers.index', compact('borrowers'));
    }



    public function create()
    {
        return view('pages.admin.borrowers.create');
    }

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
            $filename = time() . '.' . $request->id_image->extension();
            $path = $request->id_image->storeAs('ids', $filename, 'public');
            $validated['id_image'] = 'storage/ids/' . $filename;

        }


        Borrower::create($validated);

        if (auth()->user()->role === 'super_admin') {
            return redirect()->route('admin.borrowers.index')->with('success', 'Borrower added successfully.');
        } else {
            return redirect('/borrowers-client')->with('success', 'Borrower added successfully.');
        }
    }


    public function show($id)
    {
        $borrower = Borrower::findOrFail($id);
        return view('pages.admin.borrowers.show', compact('borrower'));
    }

    //     // show edit form for borrower
//     public function edit(Borrower $borrower)
//     {
//         return view('pages.admin.borrowers.edit', compact('borrower'));
//     }

    // update a borrower
    public function update(Request $request, Borrower $borrower)
    {
        $validated = $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'employment_status' => 'required|string',
            'income' => 'nullable|numeric',
            'id_card' => 'required|string|max:50',
            'id_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('id_image')) {
            // Optionally delete old image
            if ($borrower->id_image && \Storage::disk('public')->exists($borrower->id_image)) {
                \Storage::disk('public')->delete($borrower->id_image);
            }

            // Store the new file and assign path
            $validated['id_image'] = $request->file('id_image')->store('ids', 'public');
        } else {
            // If no new image, retain the old one
            $validated['id_image'] = $borrower->id_image;
        }

        $borrower->update($validated);

        return redirect()->route('admin.borrowers.index', ['page' => $request->input('page', 1)])->with('success', 'Borrower updated successfully.');
    }


    public function destroy(Borrower $borrower)
    {
        // Optionally delete associated image
        if ($borrower->id_image && \Storage::disk('public')->exists($borrower->id_image)) {
            \Storage::disk('public')->delete($borrower->id_image);
        }

        $borrower->delete();

        return redirect()->route('admin.borrowers.index')
            ->with('success', 'Borrower deleted successfully.');
    }


}
