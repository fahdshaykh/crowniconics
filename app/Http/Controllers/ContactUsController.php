<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit()
    // {
    //     $contactus = ContactUs::first();

    //     return view('dashboard.pages.contacts.edit', compact('contactus'));
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, $id)
    // {
    //     $contactus = ContactUs::find($id);

    //     $validated = $request->validate([
    //         'title' => 'nullable|string|max:100',
    //         'description'  => 'nullable|string|max:100',
    //         'email'      => 'required|email|max:150',
    //         'phone'      => 'required|string|max:20',
    //         'address'  => 'nullable|string|max:100',
    //     ]);

    //     $contactus->update($validated);

    //     return $this->redirectWithSuccess('Contact us updated successfully!');
    // }
}
