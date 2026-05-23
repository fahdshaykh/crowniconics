<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('frontend.components.sidebar', function ($view) {
            $wishlist = [];
            if (Auth::check()) {
                $wishlist = Wishlist::where('user_id', Auth::id())
                    ->with(['property' => function ($query) {
                        $query->with('category'); // Eager load the category relationship
                    }])
                    ->get()
                    ->map(function ($item) {
                        return [
                            'property_id' => $item->property_id,
                            'title' => $item->property ? ucfirst($item->property->title) : 'Unknown Property',
                            'featured_image_url' => $item->property ? $item->property->featured_image_url : asset('assets/img/default-property.jpg'),
                            'formatted_price' => $item->property ? $item->property->formatted_price : 'N/A',
                            'location_display' => $item->property ? $item->property->location_display : 'Unknown Location',
                            'beds' => $item->property ? $item->property->beds : 0,
                            'bathrooms' => $item->property ? $item->property->bathrooms : 0,
                            'area_sqft' => $item->property ? number_format($item->property->area_sqft) : 0,
                            'category_name' => $item->property && $item->property->category ? $item->property->category->name : 'N/A',
                            'property_url' => $item->property ? route('properties.show', $item->property_id) : '#',
                        ];
                    });
            }
            $view->with('wishlist', $wishlist);
        });
    }
}
