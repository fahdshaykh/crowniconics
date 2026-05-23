<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wishlists = Wishlist::with(['property', 'user'])->latest()->paginate(10);
        return view('dashboard.pages.wishlist.index', compact('wishlists'));
    }

    /**
     * Display the specified properties.
     */
    public function show($id)
    {
        $property = Property::findOrFail($id);
        // Use with() for eager loading instead of load() to avoid N+1 issues
        $property->loadMissing([
            'user',
            'agent',
            'category',
            'type',
            'city',
            'state',
            'country',
            'children' // Add children if showing related properties
        ]);

        return view('dashboard.pages.properties.show', compact('property'));
    }

    public function destroy($id)
    {
        $wishlist = Wishlist::find($id);
        $wishlist->delete();

        return redirect()->route('wishlist.index')->with('success', 'Wishlist deleted successfully!');
    }
}
