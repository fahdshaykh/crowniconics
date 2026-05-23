<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\BooleanEnum;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Property;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;

class PropertyController extends Controller
{
    /**
     * Display all properties
     */
    public function all(Request $request)
    {
        $query = Property::with(['user']);

        // Apply filters
        $query = $this->applyFilters($query, $request);

        $properties = $query->latest()->paginate(12);

        // Get filter options
        $filterOptions = $this->getFilterOptions();
        
        return view('frontend.pages.properties', compact('properties', 'filterOptions'));
    }

    /**
     * Display properties for buying
     */
    public function buy(Request $request)
    {
        $query = Property::with(['user', 'category'])
            ->whereHas('category', function ($q) {
                $q->where('name', 'Sell'); // Adjust 'name' based on your categories table column
            });
        
        // Apply filters
        $query = $this->applyFilters($query, $request);
        
        $properties = $query->latest()->paginate(6);
        $properties->withPath('buy')->appends($request->except('page'));
        
        // Get filter options   
        $filterOptions = $this->getFilterOptions();

        // Load recently viewed properties
        $viewedIds = session('recently_viewed', []);

        $types = Type::where('status', BooleanEnum::TRUE->value)
                        ->whereHas('category', function ($query) {
                            $query->where('main_category_id', 1);
                        })
                        ->select('id', 'name')
                        ->get();

        $recentlyViewed = Property::whereIn('id', $viewedIds)->get()
            ->sortBy(function ($item) use ($viewedIds) {
                return array_search($item->id, $viewedIds);
            });

        // dd($recentlyViewed);
        
        return view('frontend.pages.buy', compact('properties', 'filterOptions', 'types', 'recentlyViewed'));
    }

    /**
     * Display properties for renting
     */
    public function rent(Request $request)
    {
        $query = Property::with(['user', 'category'])
            ->whereHas('category', function ($q) {
                $q->where('name', 'Rent'); // Adjust 'name' based on your categories table column
            });
        
        // Apply filters
        $query = $this->applyFilters($query, $request);
        
        $properties = $query->latest()->paginate(6);
        $properties->withPath('rent')->appends($request->except('page'));
        
        // Get filter options
        $filterOptions = $this->getFilterOptions();

        $types = Type::where('status', BooleanEnum::TRUE->value)
                        ->whereHas('category', function ($query) {
                            $query->where('main_category_id', 1);
                        })
                        ->select('id', 'name')
                        ->get();

        // Load recently viewed properties
        $viewedIds = session('recently_viewed', []);

        $recentlyViewed = Property::whereIn('id', $viewedIds)->get()
            ->sortBy(function ($item) use ($viewedIds) {
                return array_search($item->id, $viewedIds);
            });
        
        return view('frontend.pages.rent', compact('properties', 'types', 'filterOptions', 'recentlyViewed'));
    }

    /**
     * Display property details
     */
    public function show(Property $property)
    {

        $property->load(['user', 'type', 'category']);
        // recently viewed code
        $recentlyViewed = session()->get('recently_viewed', []);
        $recentlyViewed = array_filter($recentlyViewed, fn($id) => $id != $property->id);
        array_unshift($recentlyViewed, $property->id);
        $recentlyViewed = array_slice($recentlyViewed, 0, 6);
        session(['recently_viewed' => $recentlyViewed]);
        //recently viewed code end here



        $relatedProperties = null;
        if($property->parent_id === null){
            $relatedProperties = Property::where('parent_id', $property->id)->get();
        }else{
            $relatedProperties = Property::where('parent_id', $property->parent_id)->where('id', '!=', $property->id)->get(); 
        }
        if($relatedProperties->count() <= 0){
          $relatedProperties = Property::with(['user', 'type', 'category'])
                            ->where('id', '!=', $property->id)
                            ->where('city_id', $property->city_id)
                            ->where('type_id', $property->type_id)
                            ->limit(6)
                            ->get();
        }
        // Get related properties
        

        return view('frontend.pages.property-details', compact('property', 'relatedProperties'));
    }

    /**
     * Apply filters to the query
     */
    private function applyFilters($query, Request $request)
    {
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%")
                  ->orWhere('address', 'like', "%{$keyword}%");
            });
        }

        // Filter by category_id
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by type
        if ($request->filled('type_id')) {
            $query->where('type_id', $request->type_id);
        }

        // Filter by country_id
        if ($request->filled('country_id')) {
            $query->where('country_id', $request->country_id);
        }

        // Filter by city_id
        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        // Filter by max price
        if ($request->filled('max-price')) {
            $maxPrice = (float) str_replace(['$', ','], '', $request->get('max-price'));
            $query->where('price', '<=', $maxPrice);
        }

        // Filter by beds
        if ($request->filled('beds')) {
            $query->where('beds', '>=', $request->beds);
        }

        // Filter by bathrooms
        if ($request->filled('bathrooms')) {
            $query->where('bathrooms', '>=', $request->bathrooms);
        }
        return $query;
    }

    /**
     * Get filter options for dropdowns
     */
    // private function getFilterOptions()
    // {
    //     return [
    //         'cities' => Property::select('city')->distinct()->pluck('city')->sort(),
    //         'price_ranges' => [
    //             ['label' => 'Under $100,000', 'max' => 100000],
    //             ['label' => '$100,000 - $200,000', 'max' => 200000],
    //             ['label' => '$200,000 - $300,000', 'max' => 300000],
    //             ['label' => '$300,000 - $500,000', 'max' => 500000],
    //             ['label' => 'Over $500,000', 'max' => 1000000],
    //         ]
    //     ];
    // }
    private function getFilterOptions()
    {
        $countries = Country::orderBy('name')
            ->select('id','name')
            ->get();
        // Get categories with their types for filter dropdowns
        $categories = Category::where('main_category_id', 1)->where('status', BooleanEnum::TRUE->value)
                    ->select('id', 'name')->with('categoryType')->get();

        return [
            'countries' => $countries,
            'categories' => $categories,
            'price_ranges' => [
                ['label' => 'Under $100,000', 'max' => 100000],
                ['label' => '$100,000 - $200,000', 'max' => 200000],
                ['label' => '$200,000 - $300,000', 'max' => 300000],
                ['label' => '$300,000 - $500,000', 'max' => 500000],
                ['label' => 'Over $500,000', 'max' => 1000000],
            ],
        ];
    }

    /**
     * Search properties (AJAX)
     */
    public function search(Request $request)
    {
        $query = Property::with(['user']);

        $query = $this->applyFilters($query, $request);

        $properties = $query->latest()->paginate(12);

        if ($request->ajax()) {
            return response()->json([
                'properties' => $properties,
                'html' => view('frontend.components.property-grid', compact('properties'))->render()
            ]);
        }

        return view('frontend.pages.search-results', compact('properties'));
    }

    /**
     * Get property statistics
     */
    public function statistics()
    {
        $stats = [
            'total' => Property::count(),
            'cities' => Property::distinct()->pluck('city')->count(),
        ];

        return response()->json($stats);
    }

    public function propertise(Request $request)
    {
        // $query = Property::with(['city']);
        $query = Property::query()
        ->select([
            'id',
            'title', 
            'meta_title', 
            'price', 
            'currency',
            'beds',
            'bathrooms',
            'area_sqft', 
            'featured_image',
            'category_id',
            'type_id',
            'country_id', 
            'state_id', 
            'city_id'])
        ->with([
            'user' => fn($query) => $query->select('id', 'name'), // Limit user fields
            'category' => fn($query) => $query->select('id', 'name'), // Limit category fields
            'type' => fn($query) => $query->select('id', 'name'), // Limit type fields
            'country' => fn($query) => $query->select('id', 'name'), // Limit country fields
            'city' => fn($query) => $query->select('id', 'name'), // Limit city fields
        ]);
 
        // Apply filters
        $query = $this->applyFilters($query, $request);
        
        // Get filter options
        $filterOptions = $this->getFilterOptions();

        $categories = Category::where('main_category_id',1)->where('status', BooleanEnum::TRUE->value)
                    ->select('id','name')->with('categoryType')->get();


        $properties = $query->latest()->paginate(6);
        $properties->withPath('propertise')->appends($request->except('page'));


        // Load recently viewed properties
        $viewedIds = session('recently_viewed', []);

        $recentlyViewed = Property::whereIn('id', $viewedIds)->get()
            ->sortBy(function ($item) use ($viewedIds) {
                return array_search($item->id, $viewedIds);
            });

        return view('frontend.pages.properties', compact('properties', 'filterOptions','categories', 'recentlyViewed'));
    }

    public function addWishlist(Request $request)
    {
        // Check if user is authenticated
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $propertyId = $request->input('property_id');

        // Check if the property is already in the wishlist
        $exists = Wishlist::where('user_id', $user->id)
                         ->where('property_id', $propertyId)
                         ->exists();

        if ($exists) {
            // Remove from wishlist
            Wishlist::where('user_id', $user->id)
                   ->where('property_id', $propertyId)
                   ->delete();
            return response()->json(['message' => 'Property removed from wishlist']);
        }

        // Add to wishlist
        Wishlist::create([
            'user_id' => $user->id,
            'property_id' => $propertyId,
        ]);

        return response()->json(['message' => 'Property added to wishlist']);
    }
}
