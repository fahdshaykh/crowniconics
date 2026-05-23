@extends('frontend.layouts.app')
@section('title', 'Service Professionals')
@section('content')
<main>

        <!-- BREADCRUMB SECTION START -->
        <div class="ul-breadcrumb">
            <div class="wow animate__fadeInUp">
                <h2 class="ul-breadcrumb-title">Rent Properties</h2>
                <div class="ul-breadcrumb-nav">
                    <a href="{{route('home')}}">Home</a>
                    <span class="separator"><i class="flaticon-aro-left"></i></span>
                    <span class="current-page">Rent Properties</span>
                </div>
            </div>
        </div>
        <!-- BREADCRUMB SECTION END -->

        <div class="ul-inner-page-content-wrapper ul-projects-page-content-wrapper">
            <div class="ul-inner-page-container">
                <!-- search filters -->
                <form action="{{ route('services.professionals', $service) }}" method="GET" class="ul-projects-search-filters">
                    <div class="row row-cols-lg-4 row-cols-sm-3 row-cols-2 row-cols-xxs-1 justify-content-center wow animate__fadeInUp">
                        <div class="col">
                            <input type="text" name="keyword" id="keyword" 
                                   placeholder="Enter Keyword" 
                                   value="{{ request('keyword') }}"
                                   class="form-control">
                        </div>
                        <div class="col">
                            <select name="max-price" id="max-price" class="form-select">
                                <option value="">Max Price</option>
                                @foreach($filterOptions['price_ranges'] ?? [] as $range)
                                    <option value="{{ $range['max'] }}" {{ request('max-price') == $range['max'] ? 'selected' : '' }}>
                                        {{ $range['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <select name="max-experience" id="max-price" class="form-select">
                                <option value="">Max experience</option>
                                @foreach($filterOptions['experience_ranges'] ?? [] as $range)
                                    <option value="{{ $range['max'] }}" {{ request('max-experience') == $range['max'] ? 'selected' : '' }}>
                                        {{ $range['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <div class="ul-projects-search-filters-btns">
                                <button type="submit" class="ul-projects-search-filters-btn ul-btn">Search Professionals</button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Results Summary -->
                @if(request()->hasAny(['keyword', 'max-price', 'max-experience']))
                    <div class="alert alert-info wow animate__fadeInUp">
                        <strong>{{ $service->professionals->count() }}</strong> Professionals found
                        @if(request('keyword'))
                            for "<strong>{{ request('keyword') }}</strong>"
                        @endif
                        <a href="{{ route('services') }}" class="btn btn-sm btn-outline-primary ms-2">Clear Filters</a>
                    </div>
                @endif

                <!-- project cards grid -->
                <div class="row row-cols-md-3 row-cols-2 row-cols-xxs-1 ul-bs-row">
                    @forelse($service->professionals as $professional)
                        <!-- single team -->
                        <div class="col">
                            <div class="ul-team-card">
                                <div class="ul-team-card-img">
                                    <a href="{{ route('professional.show', $professional) }}">
                                        <img src="{{ $professional->profile_image_url }}" alt="{{ $professional->name }}">
                                    </a>
                                </div>

                                <div class="ul-team-card-txt">
                                    <h4 class="ul-team-card-title"><a href="{{ route('professional.show', $professional) }}"> {{ $professional->name }} </a></h4>
                                    <span class="ul-team-card-subtitle">Call <a href="tel:01236547890"> {{ $professional->phone }} </a></span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <div class="text-muted">
                                <i class="flaticon-key" style="font-size: 4rem; opacity: 0.5;"></i>
                                <h4 class="mt-3">No Professionals found</h4>
                                <p>Try adjusting your search criteria or browse all Professionals.</p>
                                <a href="{{ route('services') }}" class="btn btn-primary">View All Services</a>
                            </div>
                        </div>
                    @endforelse
                </div>













                

                <!-- Pagination -->
                @if($professionals->hasPages())
                    <div class="d-flex justify-content-center mt-5">
                        {{ $professionals->links() }}
                    </div>
                @endif
            </div>
        </div>

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
        // Auto-submit form when filters change
        // document.querySelectorAll('.ul-projects-search-filters select, .ul-projects-search-filters input').forEach(function(element) {
        //     element.addEventListener('change', function() {
        //         if (this.name !== 'keyword') { // Don't auto-submit on keyword input
        //             this.closest('form').submit();
        //         }
        //     });
        // });

        // Favorite button functionality
        document.querySelectorAll('.ul-project-add-to-favorites-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                const propertyId = this.dataset.propertyId;
                // Add favorite functionality here
                this.classList.toggle('active');
            });
        });
    </script>
@endsection