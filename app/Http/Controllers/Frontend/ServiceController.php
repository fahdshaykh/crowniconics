<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\BooleanEnum;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use App\Models\ServiceReview;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display all service
     */
    public function all(Request $request)
    {
        $query = Service::with(['professionals']);

        $query = $this->applyFilters($query, $request);

        $categories = Category::where('main_category_id',2)->where('status', BooleanEnum::TRUE->value)->select('id','name')->with('categoryType')->get();

        // $types = Type::where('status',BooleanEnum::TRUE->value)->select('id','name')->get();

        $services = $query->latest()->get();

        return view('frontend.pages.services', compact('services', 'categories'));
    }

    /**
     * Display service details
     */
    public function serviceDetails(Service $service)
    {
        $existingReview = null;

        if (auth()->check()) {
            $existingReview = \App\Models\ServiceReview::where('user_id', auth()->id())
                ->first();
        }

        $service->load('category', 'type', 'professionals.serviceReviews');

        return view('frontend.pages.service_details', compact('service', 'existingReview'));
    }

    /**
     * Display all professionals
     */
    // public function professionals(Request $request, Service $service)
    // {
    //     // dd($service->professionals);
    //     $service = $this->applyFilters($service, $request);

    //     $professionals = $service->professionals()->paginate(9);

    //     $filterOptions = $this->getFilterOptions();

    //     return view('frontend.pages.professionals', compact('filterOptions', 'service', 'professionals'));
    // }

    /**
     * Display service details
     */
    public function show(User $user)
    {
        $existingReview = null;

        if (auth()->check()) {
            $existingReview = \App\Models\ServiceReview::where('professional_id', $user->id)
                ->where('user_id', auth()->id())
                ->first();
        }

        $user->load('services');

        return view('frontend.pages.professional-details', compact('user', 'existingReview'));
    }

    /**
     * Apply filters to the query
     */
    private function applyFilters($query, Request $request)
    {
        // Search by keyword
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

        // Filter by max price
        if ($request->filled('max-price')) {
            $maxPrice = (float) str_replace(['$', ','], '', $request->get('max-price'));
            $query->where('price', '<=', $maxPrice);
        }

                // Filter by max price
        if ($request->filled('max-experience')) {
            $maxExperience = (float) str_replace(['$', ','], '', $request->get('max-experience'));
            $query->where('experience_years', '<=', $maxExperience);
        }

        return $query;
    }
    private function getFilterOptions()
    {
        return [
            'price_ranges' => [
                ['label' => 'Under $500', 'max' => 500],
                ['label' => '$500 - $1000', 'max' => 1000],
                ['label' => '1000 - $2000', 'max' => 2000],
                ['label' => '$2000 - $5000', 'max' => 5000],
                ['label' => 'Over $5000', 'max' => 1000000],
            ],
            'experience_ranges' => [
                ['label' => 'Under 5', 'max' => 5],
                ['label' => '5 - 10', 'max' => 10],
                ['label' => '10 - 15', 'max' => 15],
                ['label' => '15 - 20', 'max' => 20],
                ['label' => 'Over 20', 'max' => 50],
            ],
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'professional_id' => 'nullable|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $review = new \App\Models\ServiceReview();
        $review->service_id = $validated['service_id'] ?? null;
        $review->user_id = auth()->id();
        $review->rating = $validated['rating'];
        $review->reviews_count = 1; // you can adjust logic later

        // Optional: handle professional rating
        if ($request->filled('professional_id')) {
            $review->professional_id = $request->professional_id;
        }

        $review->save();

        return response()->json([
            'success' => true,
            'message' => 'Thank you! Your rating has been submitted successfully.',
            'data' => $review
        ]);
    }


}
