<?php

namespace App\Http\Controllers;

use App\Enums\BooleanEnum;
use Illuminate\Http\Request;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::latest()->paginate(10);
        return view('dashboard.pages.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('dashboard.pages.partners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('partners/images', 'public');
        }

        Partner::create($data);

        return redirect()->route('partners.index')->with('success', 'Partner created successfully!');
    }

    public function show(Partner $partner)
    {
        return view('dashboard.pages.partners.show', compact('partner'));
    }

    public function edit(Partner $partner)
    {
        return view('dashboard.pages.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($partner->image && \Storage::disk('public')->exists($partner->image)) {
                \Storage::disk('public')->delete($partner->image);
            }
            $data['image'] = $request->file('image')->store('partners/images', 'public');
        }

        $partner->update($data);

        return redirect()->route('partners.index')->with('success', 'Partner updated successfully!');
    }

    public function destroy(Partner $partner)
    {
        if ($partner->image && \Storage::disk('public')->exists($partner->image)) {
            \Storage::disk('public')->delete($partner->image);
        }

        $partner->delete();

        return redirect()->route('partners.index')->with('success', 'Partner deleted successfully!');
    }
    public function toggleStatus(Partner $partner): RedirectResponse
    {
        $partner->toggleStatus();

        $message = $partner->fresh()->isActive()
            ? 'Partner activated successfully.'
            : 'Partner deactivated successfully.';

        return redirect()->back()->with('success', $message);
    }
}
