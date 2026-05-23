<?php

namespace App\Http\Controllers;

use App\Enums\BooleanEnum;
use App\Enums\PropertyStatusEnum;
use App\Http\Requests\PropertyStoreRequest;
use App\Http\Requests\PropertyUpdateRequest;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\Type;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Nnjeim\World\Models\Country;

class PropertyController extends Controller
{
    /**
     * Display a listing of properties.
     */
    public function index(Request $request)
    {
        $query = Property::with(['user', 'agent', 'category', 'type', 'city']);

        if (Auth::check() && Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('reference_number', 'like', "%{$search}%")
                    ->orWhere('city_id', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Filter by city
        if ($request->filled('city')) {
            $query->whereHas('city', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->city . '%');
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        // Filter by price range
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->priceRange($request->min_price, $request->max_price);
        }

        // Filter by bedrooms
        if ($request->filled('bedrooms')) {
            $query->bedrooms($request->bedrooms);
        }

        $properties = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        // Get filter options for dropdowns.
        $categories = Category::where('main_category_id', 1)->pluck('name', 'id');

        $types  = Type::whereIn('category_id', $categories->keys()->toArray())->pluck('name', 'id');
        $world = Country::all();
        $statuses   = Property::distinct()->pluck('status');
        // Get cities that have properties
        $cities = Property::with('city')
            ->whereNotNull('city_id')
            ->get()
            ->pluck('city.name')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        return view('dashboard.pages.properties.index', compact(
            'properties',
            'categories',
            'world',
            'types',
            'statuses',
            'cities'
        ));
    }


    /**
     * Show the form for creating a new properties.
     */
    public function create()
    {
        $agents = User::where('role', 'agent')->get(['id', 'name']);

        // Now you can use activeTypes relationship
        $categories = Category::active()
            ->where('main_category_id', 1)
            ->with(['activeTypes'])
            ->get();

        $types = $categories->pluck('activeTypes')->flatten();

        $countries = Country::get(['id', 'name']);
        $statuses = Property::distinct()->pluck('status');
        $priceTypes = ['fixed', 'negotiable', 'per_month'];
        $properties = Property::whereNull('parent_id')->get(['id', 'title']);

        return view('dashboard.pages.properties.form', compact(
            'agents',
            'categories',
            'countries',
            'properties',
            'types',
            'statuses',
            'priceTypes'
        ));
    }


    /**
     * Store a newly created property in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Check if user has active subscription and can list properties
        if (!$user->canListProperty()) {
            return redirect()->route('subscriptions.plans')
                ->with('error', 'You need an active subscription to list properties. Your current plan has reached its property listing limit.');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'category_id' => 'required|exists:categories,id',
            'type_id' => 'required|exists:types,id',
            // 'status' => 'required|in:available,sold,rented,pending,draft',
            'country_id' => 'required|string|max:100',
            'state_id' => 'nullable|string|max:100',
            'city_id' => 'required|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'address' => 'required|string|max:500',
            'price' => 'required|numeric|min:0',
            'price_type' => 'required|string|max:50',
            'area_sqft' => 'required|numeric|min:0',
            'beds' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'parking' => 'nullable|integer|min:0',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'features' => 'nullable|string',
            'parent_id' => 'nullable|exists:properties,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $validator->validated();
            $data['user_id'] = $user->id;

            // Handle featured image upload
            if ($request->hasFile('featured_image')) {
                $data['featured_image'] = $request->file('featured_image')->store('properties/featured', 'public');
            }

            if ($request->hasFile('images')) {
                $images = [];
                foreach ($request->file('images') as $image) {
                    $images[] = $image->store('properties/gallery', 'public');
                }
                $data['images'] = $images;
            }

            if ($request->filled('features')) {
                $data['features'] = $request->input('features');
            }
            
            $property = Property::create($data);
            
            // Increment subscription property usage
            if ($user->getCurrentSubscription()) {
                $user->getCurrentSubscription()->incrementPropertyUsage();
            }
            
            return redirect()->route('properties')->with('success', 'Property created successfully!');
        } catch (\Exception $e) {
            // dd('Error creating property', $e->getMessage(), $e->getTraceAsString());
            return $this->redirectWithError('Error creating property: ' . $e->getMessage());
        }
    }




    /**
     * Display the specified properties.
     */
    public function show(Property $property)
    {
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


    /**
     * Show the form for editing the specified properties.
     */
    public function edit(Property $property)
    {

        $agents     = User::where('role', 'agent')->pluck('name', 'id');

        $categories = Category::where('main_category_id', 1)->get();

        $types = Type::whereHas('category', function ($query) {
            $query->where('main_category_id', 1);
        })->get();
        $countries = Country::get();

        $statuses   = ['available', 'sold', 'rented', 'pending', 'draft'];
        $priceTypes = ['fixed', 'negotiable', 'per_month'];
        $properties = Property::whereNull('parent_id')->select('id', 'title')->get();

        return view('dashboard.pages.properties.form', compact(
            'property',
            'agents',
            'categories',
            'types',
            'statuses',
            'priceTypes',
            'countries',
            'properties'
        ));
    }



    /**
     * Update the specified property in storage.
     */
    public function update(Request $request, Property $property)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'category_id' => 'required|exists:categories,id',
            'type_id' => 'required|exists:types,id',
            // 'status' => 'required|in:available,sold,rented,pending,draft',
            'country_id' => 'required|string|max:100',
            'city_id' => 'required|string|max:100',
            'state_id' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'address' => 'required|string|max:500',
            'price' => 'required|numeric|min:0',
            'price_type' => 'required|string|max:50',
            'currency' => 'nullable|string|max:10',
            'area_sqft' => 'required|numeric|min:0',
            'beds' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'parking' => 'nullable|integer|min:0',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'features' => 'nullable|string',
            'parent_id' => 'nullable|exists:properties,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        try {
            // Handle featured image
            if ($request->hasFile('featured_image')) {
                if ($property->featured_image) {
                    Storage::disk('public')->delete($property->featured_image);
                }
                $data['featured_image'] = $request->file('featured_image')
                    ->store('properties/featured', 'public');
            }

            if ($request->hasFile('images')) {
                $images = $property->images ?? [];
                foreach ($request->file('images') as $image) {
                    $images[] = $image->store('properties/gallery', 'public');
                }
                $data['images'] = $images;
            }

            if ($request->filled('features')) {
                $data['features'] = $request->input('features');
            }
            $property->update($data);

            return $this->redirectWithSuccess('Property updated successfully!');
        } catch (\Exception $e) {
            return $this->redirectWithError('Error updating property: ' . $e->getMessage());
        }
    }



    /**
     * Remove the specified property from storage.
     */
    public function destroy(Property $property)
    {
        try {
            // Delete images from storage
            if ($property->featured_image) {
                Storage::disk('public')->delete($property->featured_image);
            }

            if ($property->images) {
                foreach ($property->images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }

            $property->delete();

            return $this->redirectWithSuccess('Property deleted successfully!');
        } catch (\Exception $e) {
            return $this->redirectWithError('Error deleting property: ' . $e->getMessage());
        }
    }

    /**
     * Toggle property status.
     */
    public function toggleStatus(Property $property)
    {
        try {
            $newStatus = $property->status === 'available' ? 'draft' : 'available';
            $property->update(['status' => $newStatus]);
            return $this->success('Property status updated successfully!', ['status' => $newStatus]);
        } catch (\Exception $e) {
            return $this->error('Error updating property status: ' . $e->getMessage());
        }
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(Property $property): RedirectResponse
    {
        try {
            $newFeaturedStatus = $property->is_featured === BooleanEnum::TRUE
                ? BooleanEnum::FALSE
                : BooleanEnum::TRUE;

            $property->update(['is_featured' => $newFeaturedStatus->value]);

            $message = $newFeaturedStatus === BooleanEnum::TRUE
                ? 'Property featured successfully!'
                : 'Property unfeatured successfully!';

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating featured status: ' . $e->getMessage());
        }
    }

    /**
     * Get property statistics.
     */
    public function statistics()
    {
        $stats = $this->stats();
        return $this->success('Property statistics retrieved successfully!', $stats);
    }

    public function stats()
    {
        $properties = Property::all();

        $total = $properties->count();
        $available = $properties->where('status', PropertyStatusEnum::AVAILABLE->value)->count();
        $sold = $properties->where('status', PropertyStatusEnum::SOLD->value)->count();
        $rented = $properties->where('status', PropertyStatusEnum::RENTED->value)->count();
        $draft = $properties->where('status', PropertyStatusEnum::DRAFT->value)->count();
        $featured = $properties->where('is_featured', true)->count();

        return [
            'total'     => $total,
            'available' => $available,
            'sold'      => $sold,
            'rented'    => $rented,
            'draft'     => $draft,
            'featured'  => $featured,
        ];
    }

    public function changeStatus(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        // Authorization check - only allow if user owns the property or is admin
        if (Auth::user()->role !== 'admin' && $property->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        $validated = $request->validate([
            'status' => 'required|in:available,sold,rented,pending,draft'
        ]);

        // Use the model's changeStatus method
        $success = $property->changeStatus($validated['status']);

        if ($success) {
            return response()->json([
                'success' => true,
                'message' => 'Property status updated successfully.',
                'new_status' => $property->status,
                'badge_class' => $property->getStatusBadgeClass() // Use the model method
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to update property status.'
        ], 422);
    }

    public function getStatusOptions($id)
    {
        $property = Property::findOrFail($id);
        $currentStatus = $property->status;

        $statusOptions = Property::getAllowedStatuses();

        return response()->json([
            'current_status' => $currentStatus,
            'status_options' => $statusOptions
        ]);
    }
}
