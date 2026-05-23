@extends('frontend.layouts.app')
@section('title', 'Buy Properties')
@section('content')
<main>

        <!-- BREADCRUMB SECTION START -->
        <div class="ul-breadcrumb">
            <div class="wow animate__fadeInUp">
                <h2 class="ul-breadcrumb-title">Buy Properties</h2>
                <div class="ul-breadcrumb-nav">
                    <a href="{{route('home')}}">Home</a>
                    <span class="separator"><i class="flaticon-aro-left"></i></span>
                    <span class="current-page">Buy Properties</span>
                </div>
            </div>
        </div>
        <!-- BREADCRUMB SECTION END -->

        <div class="ul-inner-page-content-wrapper ul-projects-page-content-wrapper">
            <div class="ul-inner-page-container">
                <!-- search filters -->
                <form action="{{ route('buy') }}" method="GET" class="ul-projects-search-filters">
                    <div class="row row-cols-lg-4 row-cols-sm-3 row-cols-2 row-cols-xxs-1 justify-content-center wow animate__fadeInUp">
                        <div class="col">
                            <input type="text" name="keyword" id="keyword" 
                                placeholder="Enter Keyword" 
                                value="{{ request('keyword') }}"
                                class="form-control">
                        </div>
                        <div class="col">
                            <select name="type_id" id="type-id" class="form-select">
                                <option value="">Select Type</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}" {{ request('type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <select name="max-price" id="max-price" class="form-select">
                                <option value="">Max Rent</option>
                                @foreach($filterOptions['price_ranges'] ?? [] as $range)
                                    <option value="{{ $range['max'] }}" {{ request('max-price') == $range['max'] ? 'selected' : '' }}>
                                        {{ $range['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <div class="ul-projects-search-filters-btns">
                                <button type="button" class="ul-projects-search-filters-expand-btn"><i class="flaticon-filter"></i></button>
                                <button type="submit" class="ul-projects-search-filters-btn ul-btn">Search Properties</button>
                            </div>
                        </div>
                    </div>

                    <div class="ul-projects-search-filters-row-2 row row-cols-lg-4 row-cols-sm-3 row-cols-2 row-cols-xxs-1 justify-content-center wow animate__fadeInUp">

                        <div class="col">
                            <select name="country_id" id="country_id" class="form-select">
                                <option value="">Select Country</option>
                                @foreach($filterOptions['countries'] ?? [] as $country)
                                    <option value="{{ $country->id }}">
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <select name="city_id" id="city_id" class="form-select">
                                <option value="">Select City</option>
                            </select>
                        </div>
                        <div class="col">
                            <select name="beds" id="beds" class="form-select">
                                <option value="">Beds</option>
                                <option value="1" {{ request('beds') == '1' ? 'selected' : '' }}>1+</option>
                                <option value="2" {{ request('beds') == '2' ? 'selected' : '' }}>2+</option>
                                <option value="3" {{ request('beds') == '3' ? 'selected' : '' }}>3+</option>
                                <option value="4" {{ request('beds') == '4' ? 'selected' : '' }}>4+</option>
                                <option value="5" {{ request('beds') == '5' ? 'selected' : '' }}>5+</option>
                            </select>
                        </div>

                        <div class="col">
                            <select name="bathrooms" id="bathrooms" class="form-select">
                                <option value="">Bathrooms</option>
                                <option value="1" {{ request('bathrooms') == '1' ? 'selected' : '' }}>1+</option>
                                <option value="2" {{ request('bathrooms') == '2' ? 'selected' : '' }}>2+</option>
                                <option value="3" {{ request('bathrooms') == '3' ? 'selected' : '' }}>3+</option>
                                <option value="4" {{ request('bathrooms') == '4' ? 'selected' : '' }}>4+</option>
                                <option value="5" {{ request('bathrooms') == '5' ? 'selected' : '' }}>5+</option>
                            </select>
                        </div>
                    </div>
                </form>

                <!-- Results Summary -->
                @if(request()->hasAny(['keyword', 'property-type', 'location', 'max-price', 'beds', 'floors', 'garages']))
                    <div class="alert alert-info wow animate__fadeInUp">
                        <strong>{{ $properties->total() }}</strong> properties found
                        @if(request('keyword'))
                            for "<strong>{{ request('keyword') }}</strong>"
                        @endif
                        <a href="{{ route('properties.buy') }}" class="btn btn-sm btn-outline-primary ms-2">Clear Filters</a>
                    </div>
                @endif

                <!-- project cards grid -->
                <div class="row row-cols-md-3 row-cols-2 row-cols-xxs-1 ul-bs-row">
                    @forelse($properties as $property)
                        <div class="col wow animate__fadeInUp">
                            <div class="ul-project">
                                <div class="ul-project-img">
                                    <a href="{{ route('properties.show', $property) }}"> <img src="{{ $property->featured_image_url }}" alt="{{ $property->title }}"> </a>
                                    <!-- <span class="ul-project-tag">Available</span> -->
                                </div>
                                <div class="ul-project-txt">
                                    <span class="ul-project-tag"> {{ $property->category?->name ?? 'N/A' }} </span>
                                    <div class="top">
                                        <div class="left">
                                            <span class="ul-project-price">
                                                <span class="number">{{ $property->formatted_price }}</span>
                                            </span>
                                            <a href="{{ route('properties.show', $property) }}" class="ul-project-title">{{ Ucfirst($property->title) }}</a>
                                            <p class="ul-project-location">{{ $property->location_display }}</p>
                                        </div>
                                        <div class="right">
                                            <button class="ul-project-add-to-favorites-btn" data-property-id="{{ $property->id }}">
                                                <i class="flaticon-heart"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- bottom -->
                                    <div class="ul-project-infos">
                                        <!-- single info -->
                                        <div class="ul-project-info">
                                            <span class="icon"><i class="flaticon-bed-color"></i></span>
                                            <span class="text">{{ $property->beds }} Beds</span>
                                        </div>
                                        <!-- single info -->
                                        <div class="ul-project-info">
                                            <span class="icon"><i class="flaticon-bath"></i></span>
                                            <span class="text">{{ $property->bathrooms }} Bathrooms</span>
                                        </div>
                                        <!-- single info -->
                                        <div class="ul-project-info">
                                            <span class="icon"><i class="flaticon-scale"></i></span>
                                            <span class="text">{{ number_format($property->area_sqft) }} sqft</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <div class="text-muted">
                                <i class="flaticon-house-2" style="font-size: 4rem; opacity: 0.5;"></i>
                                <h4 class="mt-3">No properties found</h4>
                                <p>Try adjusting your search criteria or browse all properties.</p>
                                <a href="{{ route('properties.buy') }}" class="btn btn-primary">View All Properties</a>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $properties->links('vendor.pagination.custom-pagination') }}
                </div>
            </div>
        </div>

        <!-- RECENTLY VIEWED SECTION START -->
        @if(isset($recentlyViewed) && $recentlyViewed->count() > 0)
            <div class="ul-inner-page-content-wrapper wow animate__fadeInUp mt-5">
                <div class="ul-inner-page-container">
                    <h3 class="ul-section-title mb-4">Recently Viewed Properties</h3>
                    <div class="row row-cols-md-3 row-cols-2 row-cols-xxs-1 ul-bs-row">
                        @foreach($recentlyViewed as $property)
                            <div class="col wow animate__fadeInUp">
                                <div class="ul-project">
                                    <div class="ul-project-img">
                                        <a href="{{ route('properties.show', $property) }}">
                                            <img src="{{ $property->featured_image_url }}" alt="{{ $property->title }}">
                                        </a>
                                    </div>
                                    <div class="ul-project-txt">
                                        <span class="ul-project-tag">{{ $property->category?->name ?? 'N/A' }}</span>
                                        <div class="top">
                                            <div class="left">
                                                <span class="ul-project-price">
                                                    <span class="number">{{ $property->formatted_price }}</span>
                                                </span>
                                                <a href="{{ route('properties.show', $property) }}" class="ul-project-title">{{ ucfirst($property->title) }}</a>
                                                <p class="ul-project-location">{{ $property->location_display }}</p>
                                            </div>
                                        </div>
                                        <div class="ul-project-infos">
                                            <div class="ul-project-info">
                                                <span class="icon"><i class="flaticon-bed-color"></i></span>
                                                <span class="text">{{ $property->beds }} Beds</span>
                                            </div>
                                            <div class="ul-project-info">
                                                <span class="icon"><i class="flaticon-bath"></i></span>
                                                <span class="text">{{ $property->bathrooms }} Bathrooms</span>
                                            </div>
                                            <div class="ul-project-info">
                                                <span class="icon"><i class="flaticon-scale"></i></span>
                                                <span class="text">{{ number_format($property->area_sqft) }} sqft</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        <!-- RECENTLY VIEWED SECTION END -->

        <!-- APP AD SECTION START -->
        <div class="ul-app-ad ul-app-ad--2 wow animate__fadeInUp">
            <div class="ul-app-ad-container">
                <div class="ul-app-ad-content">
                    <div class="row align-items-start gy-5">
                        <!-- txt -->
                        <div class="col-lg-7">
                            <div class="ul-app-ad-txt">
                                <span class="ul-section-sub-title">Download App</span>
                                <h2 class="ul-section-title">Download Our Real Estate Mobile App <span class="colored">15% Off</span></h2>
                                <div class="ul-app-ad-btns">
                                    <button>
                                        <i class="flaticon-play"></i>
                                        <span>
                                            <span class="sub-title">Get in on</span>
                                            <span class="title">Apps Store</span>
                                        </span>
                                    </button>
                                    <button>
                                        <i class="flaticon-play"></i>
                                        <span>
                                            <span class="sub-title">Get in on</span>
                                            <span class="title">Google Play</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- img -->
                        <div class="col-lg-5">
                            <div class="ul-app-ad-imgs">
                                <div class="ul-app-ad-img">
                                    <!-- qr code -->
                                    <img src="assets/img/app-ad-qr-code.jpg" alt="QR Code" class="ul-app-ad-qr-code">
                                    <!-- app screenshot 1 -->
                                    <img src="assets/img/app-ad-ss-1.png" alt="App screenshot" class="ul-app-ad-ss-1">
                                </div>
                                <div class="ul-app-ad-img">
                                    <!-- app screenshot 2 -->
                                    <img src="assets/img/app-ad-ss-2.png" alt="App Screenshot" class="ul-app-ad-ss-2">
                                </div>

                                <!-- vector -->
                                <img src="assets/img/app-ad-img-vector.svg" alt="vector" class="vector">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- APP AD SECTION END -->

    </main>

    <script>
    
    // Favorite button functionality
    document.querySelectorAll('.ul-project-add-to-favorites-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const propertyId = this.dataset.propertyId;
            // Add favorite functionality here
            this.classList.toggle('active');
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        let countrySelect = document.getElementById('country_id');
        let citySelect = document.getElementById('city_id');
        let initialCityId = "{{ old('city_id', $user->city_id ?? '') }}";

        // Country change event (only fetch cities, no auto-submit)
        countrySelect.addEventListener('change', function() {
            let country_id = this.value;
            citySelect.innerHTML = '<option value="">Select City</option>';

            if (country_id) {
                fetch(`/get-cities-by-country/${encodeURIComponent(country_id)}`)
                    .then(res => res.json())
                    .then(data => {
                        console.log(data);
                        
                        data.forEach(city => {
                            let option = new Option(city.name, city.id);
                            citySelect.add(option);
                        });
                        // Pre-select city if initial value exists
                        if (initialCityId && stateSelect.value) {
                            citySelect.value = initialCityId;
                            initialCityId = null; // Clear after first use
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching cities:', error);
                    });
            }
        });

        // Trigger change if country is pre-selected
        @if(old('country_id') || request('country_id'))
            countrySelect.value = "{{ old('country_id', request('country_id') ?? '') }}";
            countrySelect.dispatchEvent(new Event('change'));
        @endif
    });
</script>
@endsection