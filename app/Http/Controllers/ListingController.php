<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // Show all listings
    public function index() {
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
            ]);
    }
    // Show single listing
    public function show(Listing $listing) {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }
    // Show create form
    public function create(Listing $listing) {
        return view('listings.create');
    }

    // Store listing data
    public function store(Request $request) {
        $formFields = $request->validate([
            "company" => ['required', Rule::unique('listings', 'company')],
            "title" => 'required',
            "location" => 'required',
            "email" => ['required', 'email'],
            "website" => 'required',
            "tags" => 'required',
            "description" => 'required'
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        return redirect('/')->with('message', 'Listing created successfully!');
    }

    //Show edit form
    public function edit(Listing $listing) {
        return view('listings.edit', ['listing' => $listing]);
    } 

    // Update listing data
    public function update(Request $request, Listing $listing) {

        // Make sure logged in user is owner
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized action');
        }

        $formFields = $request->validate([
            "company" => ['required'],
            "title" => 'required',
            "location" => 'required', 
            "email" => ['required', 'email'],
            "website" => 'required',
            "tags" => 'required',
            "description" => 'required'
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formFields);

        return back()->with('message', 'Listing updated successfully!');
    }

    // Delete listing
    public function destroy(Listing $listing) {
        // Make sure logged in user is owner
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized action');
        }

        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted successfully!');
    }

    // Manage Listings
    public function manage(Listing $listing) {
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }

}
