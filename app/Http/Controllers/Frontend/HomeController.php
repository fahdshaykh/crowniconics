<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\BooleanEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Category;
use App\Models\Country;
use App\Models\Partner;
use App\Models\Slider;
use App\Models\Type;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured properties for the homepage
        $featuredProperties = Property::with(['user'])
            ->limit(6)
            ->get();

        // $categories = Category::all();

        $categories = Category::with(['properties' => function ($q) {
            $q->limit(6);
        }])
        ->where('main_category_id', 1)
        ->get();
        
        $types = Type::whereHas('category', function ($query) {
            $query->where('main_category_id', 1);
        })->get();

        $sliders = Slider::where('status', BooleanEnum::TRUE->value)->get();

        $partners = Partner::where('status', BooleanEnum::TRUE->value)->get();
        
        // Get property statistics
        $stats = [
            'total' => Property::count(),
            'buy' => Property::where('type_id', 'buy')->count(),
            'rent' => Property::where('type_id', 'rent')->count(),
            'countries' => Country::orderBy('name')->pluck('id', 'name'),
        ];

        return view('frontend.index', compact('featuredProperties', 'stats','categories', 'types', 'sliders', 'partners'));
    }
}
