<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Frontend\PropertyController;
use App\Models\Property;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\ServiceController;
use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;
use App\Models\ContactUs;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', function () {
    return view('frontend.pages.about');
})->name('about');

Route::get('/contact', function () {
    $contact = ContactUs::first();
    return view('frontend.pages.contact', compact('contact'));
})->name('contact');


Route::post('/contact/store', [ContactController::class, 'store'])->name('contact.store');

Route::prefix('properties')->name('properties.')->group(function () {
    Route::get('/', [PropertyController::class, 'all'])->name('all');
    Route::get('/buy', [PropertyController::class, 'buy'])->name('buy');
    Route::get('/rent', [PropertyController::class, 'rent'])->name('rent');
    Route::get('/search', [PropertyController::class, 'search'])->name('search');
    Route::get('/{property}', [PropertyController::class, 'show'])->name('show');
    Route::get('/statistics', [PropertyController::class, 'statistics'])->name('statistics');
});

Route::get('/category/{category}', [PropertyController::class, 'getPropertiesForCategory'])->name('category.properties');


// Legacy routes for backward compatibility
Route::get('/rent', [PropertyController::class, 'rent'])->name('rent');
Route::get('/buy', [PropertyController::class, 'buy'])->name('buy');
Route::get('/properties', [PropertyController::class, 'propertise'])->name('allpropertise');
Route::get('/services', [ServiceController::class, 'all'])->name('services');
Route::get('/service-details/{service}', [ServiceController::class, 'serviceDetails'])->name('services.details');
Route::get('/services-professionals/{service}', [ServiceController::class, 'professionals'])->name('services.professionals');
Route::get('/professional-details/{user}', [ServiceController::class, 'show'])->name('professional.show');

Route::post('/service-review', [ServiceController::class, 'store'])->name('service.review.store');
Route::post('/wishlist/add', [PropertyController::class, 'addWishlist'])->name('properties.wishlist');


Route::get('/get-states/{country}', [LocationController::class, 'getStates'])->name('getStates');
Route::get('/get-cities/{state}', [LocationController::class, 'getCities'])->name('getCities');
Route::get('/get-cities-by-country/{country_id}', [LocationController::class, 'getCitiesByCountry'])->name('getCitiesByCountry');


// Test routes for subscription plan CRUD
Route::prefix('test')->group(function() {
    // List all plans
    Route::get('/subscription-plans', function() {
        $plans = App\Models\SubscriptionPlan::all();
        return response()->json([
            'message' => 'Subscription Plans',
            'count' => $plans->count(),
            'plans' => $plans->map(function($plan) {
                return [
                    'id' => $plan->id,
                    'name' => $plan->name,
                    'description' => $plan->description,
                    'monthly_price' => $plan->monthly_price,
                    'yearly_price' => $plan->yearly_price,
                    'currency' => $plan->currency,
                    'is_active' => $plan->is_active,
                    'property_listings' => $plan->property_listings,
                    'featured_listings' => $plan->featured_listings,
                    'created_at' => $plan->created_at,
                ];
            })
        ]);
    });
    
    // Create a new plan
    Route::post('/subscription-plans', function(Illuminate\Http\Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'monthly_price' => 'required|numeric|min:0',
            'yearly_price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'property_listings' => 'required|integer|min:0',
            'featured_listings' => 'required|integer|min:0',
        ]);
        
        $plan = App\Models\SubscriptionPlan::create($request->all());
        
        return response()->json([
            'message' => 'Plan created successfully',
            'plan' => $plan
        ]);
    });
    
    // Update a plan
    Route::put('/subscription-plans/{id}', function(Illuminate\Http\Request $request, $id) {
        $plan = App\Models\SubscriptionPlan::findOrFail($id);
        
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'monthly_price' => 'sometimes|numeric|min:0',
            'yearly_price' => 'sometimes|numeric|min:0',
            'currency' => 'sometimes|string|max:3',
            'property_listings' => 'sometimes|integer|min:0',
            'featured_listings' => 'sometimes|integer|min:0',
        ]);
        
        $plan->update($request->all());
        
        return response()->json([
            'message' => 'Plan updated successfully',
            'plan' => $plan
        ]);
    });
    
    // Delete a plan
    Route::delete('/subscription-plans/{id}', function($id) {
        $plan = App\Models\SubscriptionPlan::findOrFail($id);
        
        // Check if plan has subscriptions
        if ($plan->subscriptions()->count() > 0) {
            return response()->json([
                'error' => 'Cannot delete plan. It has active subscriptions.',
                'subscriptions_count' => $plan->subscriptions()->count()
            ], 400);
        }
        
        $plan->delete();
        
        return response()->json([
            'message' => 'Plan deleted successfully'
        ]);
    });
    
    // Toggle plan status
    Route::patch('/subscription-plans/{id}/toggle-status', function($id) {
        $plan = App\Models\SubscriptionPlan::findOrFail($id);
        $plan->update(['is_active' => !$plan->is_active]);
        
        return response()->json([
            'message' => 'Plan status toggled successfully',
            'plan' => $plan
        ]);
    });
    
    // Test interface
    Route::get('/subscription-plans-interface', function() {
        return view('test.subscription-plans-crud');
    });
    
    // Admin interface access (for testing)
    Route::get('/admin-access', function() {
        return view('test.admin-access');
    });
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
