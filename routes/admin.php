<?php

use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\SubscriptionPlanController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\MpesaCallbackController;

Route::get('/admin', function () {
    $role = auth()->user()->role;
    if ($role == 'professional') {
        return redirect()->route('profile.edit');
    }
    return view('dashboard.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/wishlist/index', [WishlistController::class, 'index'])->name('wishlist.index');
Route::get('/wishlist/property/{id}', [WishlistController::class, 'show'])->name('wishlist.show');
Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

Route::prefix('admin')->middleware(['auth', 'role:admin,agent', 'verified', 'subscription:property_listing'])->group(function () {

    Route::get('/properties', [PropertyController::class, 'index'])->name('properties');
    Route::get('properties/create', [PropertyController::class, 'create'])->name('property.create');
    Route::post('properties', [PropertyController::class, 'store'])->name('properties.store');
    Route::get('properties/{property}', [PropertyController::class, 'show'])->name('property.show');
    Route::get('properties/{property}/edit', [PropertyController::class, 'edit'])->name('property.edit');
    Route::put('properties/{property}', [PropertyController::class, 'update'])->name('property.update');
    Route::delete('properties/{property}', [PropertyController::class, 'destroy'])->name('property.destroy');
    Route::patch('properties/{property}/toggle-status', [PropertyController::class, 'toggleStatus'])->name('properties.toggle-status');
    Route::patch('properties/{property}/toggle-featured', [PropertyController::class, 'toggleFeatured'])->name('properties.toggle-featured');
    Route::get('properties-statistics', [PropertyController::class, 'statistics'])->name('properties.statistics');
     Route::post('/property/{property}/change-status', [PropertyController::class, 'changeStatus'])
         ->name('property.change-status');
    Route::get('/property/{property}/status-options', [PropertyController::class, 'getStatusOptions'])
         ->name('property.status-options');

});


Route::prefix('admin')->middleware(['auth', 'role:admin,agent,professional,customer', 'verified'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

Route::middleware(['role:admin'])->group(function () {

    // Users Management
    Route::get('/admin/users', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('users.index');
    Route::get('/admin/users/create', [UserController::class, 'create'])->middleware(['auth', 'verified'])->name('user.create');
    Route::post('/admin/users', [UserController::class, 'store'])->middleware(['auth', 'verified'])->name('users.store');
    Route::get('/admin/users/{user}', [UserController::class, 'show'])->middleware(['auth', 'verified'])->name('users.show');
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->middleware(['auth', 'verified'])->name('users.edit');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->middleware(['auth', 'verified'])->name('users.update');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->middleware(['auth', 'verified'])->name('users.destroy');
    Route::patch('/admin/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->middleware(['auth', 'verified'])->name('users.toggle-status');
    
    // Roles Management
    Route::get('/admin/roles', [RoleController::class, 'index'])->middleware(['auth', 'verified'])->name('roles.index');
    Route::get('/admin/roles/create', [RoleController::class, 'create'])->middleware(['auth', 'verified'])->name('roles.create');
    Route::post('/admin/roles', [RoleController::class, 'store'])->middleware(['auth', 'verified'])->name('roles.store');
    Route::get('/admin/roles/{role}', [RoleController::class, 'show'])->middleware(['auth', 'verified'])->name('roles.show');
    Route::get('/admin/roles/{role}/edit', [RoleController::class, 'edit'])->middleware(['auth', 'verified'])->name('roles.edit');
    Route::put('/admin/roles/{role}', [RoleController::class, 'update'])->middleware(['auth', 'verified'])->name('roles.update');
    Route::delete('/admin/roles/{role}', [RoleController::class, 'destroy'])->middleware(['auth', 'verified'])->name('roles.destroy');

    // Permissions Management
    Route::get('/admin/permissions', [PermissionController::class, 'index'])->middleware(['auth', 'verified'])->name('permissions.index');
    Route::get('/admin/permissions/create', [PermissionController::class, 'create'])->middleware(['auth', 'verified'])->name('permissions.create');
    Route::post('/admin/permissions', [PermissionController::class, 'store'])->middleware(['auth', 'verified'])->name('permissions.store');
    Route::get('/admin/permissions/{permission}', [PermissionController::class, 'show'])->middleware(['auth', 'verified'])->name('permissions.show');
    Route::get('/admin/permissions/{permission}/edit', [PermissionController::class, 'edit'])->middleware(['auth', 'verified'])->name('permissions.edit');
    Route::put('/admin/permissions/{permission}', [PermissionController::class, 'update'])->middleware(['auth', 'verified'])->name('permissions.update');
    Route::delete('/admin/permissions/{permission}', [PermissionController::class, 'destroy'])->middleware(['auth', 'verified'])->name('permissions.destroy');

    // Services Management
    Route::get('/admin/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/admin/services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/admin/services', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/admin/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/admin/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/admin/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
    Route::get('/admin/get-types/{category_id}', [ServiceController::class, 'getTypes'])->name('services.getTypes');
    Route::get('/admin/service/{id}', [ServiceController::class, 'show'])->name('service.show');
    Route::patch('/admin/services/{service}/toggle-status', [ServiceController::class, 'toggleStatus'])->name('service.toggle-status');

    //category management routes
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::get('/category/{id}', [CategoryController::class, 'show'])->name('category.show');
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::put('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/destroy/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
    Route::patch('/categories/{id}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('category.toggle-status');


    // Type Management Routes
    Route::get('/types', [TypeController::class, 'index'])->name('types.index');
    Route::get('/type/create', [TypeController::class, 'create'])->name('type.create');
    Route::post('/type/store', [TypeController::class, 'store'])->name('type.store');
    Route::get('/type/{id}', [TypeController::class, 'show'])->name('type.show');
    Route::get('/type/edit/{id}', [TypeController::class, 'edit'])->name('type.edit');
    Route::put('/type/update/{id}', [TypeController::class, 'update'])->name('type.update');
    Route::delete('/type/destroy/{id}', [TypeController::class, 'destroy'])->name('type.destroy');
    Route::patch('/types/{type}/toggle-status', [TypeController::class, 'toggleStatus'])->name('type.toggle-status');

    Route::resource('/admin/sliders', SliderController::class);
    Route::patch('/admin/sliders/{slider}/toggle-status', [SliderController::class, 'toggleStatus'])
        ->name('slider.toggle-status');

    Route::resource('/admin/partners', PartnerController::class);
    Route::patch('/admin/partners/{partner}/toggle-status', [PartnerController::class, 'toggleStatus'])
        ->name('partner.toggle-status');

    Route::resource('contacts', ContactController::class);

    Route::get('/contact-us/edit', [ContactUsController::class, 'edit'])->name('contactus.edit');
    Route::put('/contact-us/update/{id}', [ContactUsController::class, 'update'])->name('contactus.update');

    // Subscription Plans Management
    Route::get('/subscription-plans', [SubscriptionPlanController::class, 'index'])->name('subscription-plans.index');
    Route::get('/subscription-plan/create', [SubscriptionPlanController::class, 'create'])->name('subscription-plan.create');
    Route::get('/subscription-plan/{id}', [SubscriptionPlanController::class, 'show'])->name('subscription-plan.show');
    Route::get('/subscription-plan/edit/{id}', [SubscriptionPlanController::class, 'edit'])->name('subscription-plan.edit');
    Route::post('/subscription-plan/store', [SubscriptionPlanController::class, 'store'])->name('subscription-plan.store');
    Route::put('/subscription-plan/update/{id}', [SubscriptionPlanController::class, 'update'])->name('subscription-plan.update');
    Route::delete('/subscription-plan/destroy/{id}', [SubscriptionPlanController::class, 'destroy'])->name('subscription-plan.destroy');
    Route::patch('/subscription-plans/{id}/toggle-status', [SubscriptionPlanController::class, 'toggleStatus'])->name('subscription-plans.toggle-status');});

    // User Subscription Routes
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
        Route::get('/subscriptions/plans', [SubscriptionController::class, 'plans'])->name('subscriptions.plans');
        Route::get('/subscriptions/plan/{plan}', [SubscriptionController::class, 'showPlan'])->name('subscriptions.show-plan');
        Route::post('/subscriptions/subscribe/{plan}', [SubscriptionController::class, 'subscribe'])->name('subscriptions.subscribe');
        Route::get('/subscriptions/payment-status/{subscription}', [SubscriptionController::class, 'paymentStatus'])->name('subscriptions.payment-status');
        Route::get('/subscriptions/check-payment/{subscription}', [SubscriptionController::class, 'checkPaymentStatus'])->name('subscriptions.check-payment');
        Route::post('/subscriptions/cancel/{subscription}', [SubscriptionController::class, 'cancel'])->name('subscriptions.cancel');
        Route::get('/subscriptions/usage/{subscription}', [SubscriptionController::class, 'usage'])->name('subscriptions.usage');
    });

    // M-Pesa Callback Routes (No authentication required)
    Route::prefix('api/mpesa')->group(function () {
        Route::post('/callback', [MpesaCallbackController::class, 'stkCallback'])->name('mpesa.stk-callback');
        Route::post('/timeout', [MpesaCallbackController::class, 'timeoutCallback'])->name('mpesa.timeout-callback');
        Route::post('/balance', [MpesaCallbackController::class, 'balanceCallback'])->name('mpesa.balance-callback');
    });

Route::get('admin/users/get-states/{countryId}', [UserController::class, 'getStates'])->name('getStates');
Route::get('/users/get-cities/{stateId}', [UserController::class, 'getCities'])->name('getCities');
Route::get('/get-types/{categoryId}', [TypeController::class, 'getCategoryTypes'])->name('getTypes');
