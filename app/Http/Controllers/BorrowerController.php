<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrower;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

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



    public function indexClient()
    {
        $borrowers = Borrower::latest()->paginate(10); // 10 per page
        return view('pages.borrowersList', compact('borrowers'));
    }

    public function search(Request $request)
    {
        $search = $request->get('search', '');

        $borrowers = Borrower::query()
            ->where('fname', 'like', "%{$search}%")
            ->orWhere('lname', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orWhere('contact_number', 'like', "%{$search}%")
            ->orderBy('fname')
            ->take(20)
            ->get();

        return response()->json($borrowers);
    }

    public function showClient(Borrower $borrower)
    {
        return view('pages.showBorrower', compact('borrower'));
    }


    public function create()
    {
        return view('pages.admin.borrowers.create');
    }


    public function store(Request $request)
    {
        try {
            // Form validation (Laravel will handle error messages automatically)
            $validated = $request->validate([
                'fname' => 'required|string|max:255',
                'lname' => 'required|string|max:255',
                'address' => 'nullable|string',
                'contact_number' => 'required|string|max:20',
                'email' => 'required|email|unique:borrowers,email',
                'employment_status' => 'required|string',
                'income' => 'nullable|numeric',
                'id_card' => 'required|string',
                'id_image' => 'required|image|max:2048',
            ]);

            // Handle file upload
            if ($request->hasFile('id_image')) {
                $filename = time() . '.' . $request->id_image->extension();
                $path = $request->file('id_image')->storeAs('ids', $filename, 'public');
                $validated['id_image'] = 'storage/' . $path; // For asset() use
            }


            // Create borrower
            Borrower::create($validated);

            $route = auth()->user()->role === 'super_admin'
                ? route('admin.borrowers.index')
                : '/borrowers';

            return redirect($route)->with('success', 'Borrower added successfully.');

        } catch (ValidationException $e) {
            // Laravel handles this automatically — no need to catch it unless you want to customize
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Borrower creation error: ' . $e->getMessage()); // log full error
            $route = auth()->user()->role === 'super_admin'
                ? route('admin.borrowers.index')
                : '/borrowers-client';

            return redirect($route)->with('error', 'Failed to add borrower. Please try again.');
        }
    }




    public function show($id)
    {
        $borrower = Borrower::findOrFail($id);
        return view('pages.admin.borrowers.show', compact('borrower'));
    }

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
            // Delete old image if it exists
            if ($borrower->id_image && Storage::disk('public')->exists(str_replace('storage/', '', $borrower->id_image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $borrower->id_image));
            }

            $filename = time() . '.' . $request->id_image->extension();
            $path = $request->file('id_image')->storeAs('ids', $filename, 'public');
            $validated['id_image'] = 'storage/' . $path; // Correct path for asset()
        } else {
            // Retain existing image
            $validated['id_image'] = $borrower->id_image;
        }


        $borrower->update($validated);

        return redirect()->route('admin.borrowers.index', ['page' => $request->input('page', 1)])->with('success', 'Borrower updated successfully.');
    }


    public function destroy(Borrower $borrower)
    {
        // Optionally delete associated image
        if ($borrower->id_image && Storage::disk('public')->exists($borrower->id_image)) {
            Storage::disk('public')->delete($borrower->id_image);
        }

        $borrower->delete();

        return redirect()->route('admin.borrowers.index')
            ->with('success', 'Borrower deleted successfully.');
    }


}
