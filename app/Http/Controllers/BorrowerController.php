<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrower;
use Illuminate\Support\Facades\Storage;

class BorrowerController extends Controller
{

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


    // admin panel
    // view all borrowers in admin index side
    public function index()
    {
        $borrowers = Borrower::orderBy('created_at', 'desc')->get();
        return view('pages.admin.borrowers.index', compact('borrowers'));
    }
    public function show($id)
    {
        $borrower = Borrower::findOrFail($id);
        return view('pages.admin.borrowers.show', compact('borrower'));
    }

}
