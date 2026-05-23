@extends('frontend.layouts.app')
@section('title', 'Crown Iconics')
@section('content')
    <main>
        <section class="ul-banner">
            <!-- top -->
            <div class="top">
                <div class="ul-banner-slider swiper">
                    <div class="swiper-wrapper">
                        <!-- single slide -->
                        @foreach($sliders as $slider)
                        
                            <div class="swiper-slide">
                                <div class="ul-banner-slide" 
                                    style="background: url('{{ asset($slider->slider_image) }}') no-repeat center center; background-size: cover;">
                                    <div class="ul-banner-container">
                                        <div class="row align-items-center flex-sm-row flex-column-reverse">
                                            <!-- banner text -->
                                            <div class="col-md-9 col-sm-8">
                                                <span class="ul-banner-slide-shadow-title">{{ $slider->title }}</span>
                                                <div class="ul-banner-slide-txt wow animate__fadeInUp">
                                                    <span class="ul-banner-slide-sub-title">{{ $slider->title ?? '' }}</span>
                                                    <h1 class="ul-banner-slide-title">{{ $slider->heading ?? '' }}</h1>
                                                    <p class="ul-banner-slide-descr">{{ $slider->description ?? '' }}</p>
                                                    <div class="ul-banner-slide-btns">
                                                        <a href="{{ route('allpropertise') }}" class="ul-btn">Explore Properties</a>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- banner image (optional small image/video button) -->
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        
                        
                    </div>
                </div>
            </div>

            <!-- bottom -->
            <div class="bottom">
                <div class="left wow animate__fadeInUp">
                    <div class="ul-banner-address-slider swiper">
                        <div class="swiper-wrapper">
                            <!-- single slide -->
                            @foreach ($sliders as $slider)
                            <div class="swiper-slide">
                                <span class="address-1">{{ $slider->note }}</span>
                            </div>
                            @endforeach

                        </div>

                    </div>
                </div>

                <div class="right wow animate__fadeInUp">
                    <div class="ul-banner-slider-pagination"></div>
                    <div class="ul-banner-slider-nav ul-slider-nav">
                        <button class="prev"><i class="flaticon-left"></i></button>
                        <button class="next"><i class="flaticon-right"></i></button>
                    </div>
                </div>
            </div>
        </section>
        <!-- BANNER SECTION END -->


        <!-- CITIES SECTION START -->
        <!-- <section class="ul-cities ul-section-spacing">
            <div class="ul-container wow animate__fadeInUp">
           
                <div class="ul-section-heading">
                    <div class="left">
                        <h2 class="ul-section-title">Find Properties in These Cities</h2>
                        <p class="ul-section-descr">Discover your perfect home or investment opportunity in some of the most sought-after cities across the United States. Browse through our curated listings and explore neighborhoods that match your lifestyle.</p>
                    </div>
                    <div class="right">
                        <a href="{{route('allpropertise')}}" class="ul-btn">See All Properties</a>
                    </div>
                </div>

                <div class="row row-cols-xl-4 row-cols-md-3 row-cols-2 row-cols-xxs-1 g-4 mx-auto">
                    <div class="col">
                        <div class="ul-city">
                            <div class="img"><a href="projects.html"><img src="assets/img/city-1.jpg" alt="City Image"></a></div>
                            <div class="txt">
                                <h3 class="ul-city-title"><a href="projects.html">New York</a></h3>
                                <span class="ul-city-count">15 Properties</span>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="ul-city">
                            <div class="img"><a href="projects.html"><img src="assets/img/city-2.jpg" alt="City Image"></a></div>
                            <div class="txt">
                                <h3 class="ul-city-title"><a href="projects.html">Los Angeles</a></h3>
                                <span class="ul-city-count">15 Properties</span>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="ul-city">
                            <div class="img"><a href="projects.html"><img src="assets/img/city-3.jpg" alt="City Image"></a></div>
                            <div class="txt">
                                <h3 class="ul-city-title"><a href="projects.html">Chicago</a></h3>
                                <span class="ul-city-count">15 Properties</span>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="ul-city">
                            <div class="img"><a href="projects.html"><img src="assets/img/city-4.jpg" alt="City Image"></a></div>
                            <div class="txt">
                                <h3 class="ul-city-title"><a href="projects.html">Houston</a></h3>
                                <span class="ul-city-count">15 Properties</span>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="ul-city">
                            <div class="img"><a href="projects.html"><img src="assets/img/city-5.jpg" alt="City Image"></a></div>
                            <div class="txt">
                                <h3 class="ul-city-title"><a href="projects.html">San Diego</a></h3>
                                <span class="ul-city-count">15 Properties</span>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="ul-city">
                            <div class="img"><a href="projects.html"><img src="assets/img/city-6.jpg" alt="City Image"></a></div>
                            <div class="txt">
                                <h3 class="ul-city-title"><a href="projects.html">Columbus</a></h3>
                                <span class="ul-city-count">15 Properties</span>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="ul-city">
                            <div class="img"><a href="projects.html"><img src="assets/img/city-7.jpg" alt="City Image"></a></div>
                            <div class="txt">
                                <h3 class="ul-city-title"><a href="projects.html">Columbus</a></h3>
                                <span class="ul-city-count">15 Properties</span>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="ul-city">
                            <div class="img"><a href="projects.html"><img src="assets/img/city-8.jpg" alt="City Image"></a></div>
                            <div class="txt">
                                <h3 class="ul-city-title"><a href="projects.html">Las Vegas</a></h3>
                                <span class="ul-city-count">15 Properties</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ul-cities-vectors">
                <img src="assets/img/cities-vector-1.svg" alt="vector" class="vector-1 wow animate__fadeInLeft">
                <img src="assets/img/cities-vector-2.svg" alt="vector" class="vector-2 wow animate__fadeInUp">
            </div>
        </section> -->
        <!-- CITIES SECTION END -->


        <!-- WHY CHOOSE US SECTION START -->
        <section class="ul-why-choose-us ul-section-spacing wow animate__fadeInUp">
            <div class="ul-container">
                <div class="row row-cols-lg-2 row-cols-1 align-items-center">
                    <div class="col">
                        <!-- <div class="d-flex justify-content-end"> -->
                        <div class="ul-why-choose-us-imgs">
                            <div class="img"><img src="assets/img/why-choose-img-1.jpg" alt="image"></div>
                            <div class="img">
                                <img src="assets/img/why-choose-img-2.jpg" alt="image">
                                <!-- icon -->
                                <div class="icon"><i class="flaticon-home-agreement"></i></div>
                            </div>
                        </div>
                        <!-- </div> -->
                    </div>

                    <!-- txt -->
                    <div class="col">
                        <div class="ul-why-choose-us-txt">
                            <span class="ul-section-sub-title">Why choose us</span>
                            <h2 class="ul-section-title">We Bring Your Dream Homes to Reality</h2>
                            <p class="ul-why-choose-us-heading-descr">We offer perfect real estate services</p>

                            <div class="ul-why-choose-us-list">
                                <div class="ul-why-choose-us-list-item">
                                    <div class="icon"><i class="flaticon-property"></i></div>
                                    <div class="txt">
                                        <h3 class="ul-why-choose-us-list-item-title">Property Management</h3>
                                        <p class="ul-why-choose-us-list-item-descr">At Crown Iconics, we believe a home is more than walls and a roof—it’s where life unfolds. Our mission is to connect you with luxury residences, modern apartments, elegant villas, and premium offices that suit your lifestyle and investment goals.</p>
                                    </div>
                                </div>

                                <div class="ul-why-choose-us-list-item">
                                    <div class="icon"><i class="flaticon-list-1"></i></div>
                                    <div class="txt">
                                        <h3 class="ul-why-choose-us-list-item-title">Professional Services</h3>
                                        <p class="ul-why-choose-us-list-item-descr"> Our team delivers tailored solutions—from buying and renting to investment planning—with meticulous attention to detail and unwavering professionalism. Trust in our commitment to elevate your property experience through unparalleled service and trusted insights.</p>
                                    </div>
                                </div>

                                <!-- <div class="ul-why-choose-us-list-item">
                                    <div class="icon"><i class="flaticon-change"></i></div>
                                    <div class="txt">
                                        <h3 class="ul-why-choose-us-list-item-title">Financing made easy</h3>
                                        <p class="ul-why-choose-us-list-item-descr">Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit perspiciatis adipisci quas facere a!</p>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- WHY CHOOSE US SECTION END -->


        <!-- PROPERTY FILTER SEARCH SECTION START -->
        <section class="ul-property-filter-search ul-section-spacing pt-0">
            <div class="ul-property-filter-search-container">
                <h3 class="ul-property-filter-search-title text-center wow animate__fadeInUp">Search Your Property</h3>
                <form action="{{ route('allpropertise') }}" method="GET" class="ul-property-filter-search-form wow animate__fadeInUp">
                    <div class="form-group">
                        <label for="filter-location">Location</label>
                        <select name="country_id" id="filter-location">
                            <option value="">All Locations</option>
                            @foreach($stats['countries'] ?? [] as $city => $id)
                                <option value="{{ $id }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="filter-property-type">Property Type</label>
                        <select name="property-type" id="filter-property-type">
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}"> {{ $type->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="filter-price">Price Range</label>
                        <select name="max-price" id="filter-price">
                            <option value="">Any Price</option>
                            <option value="100000">Under $100,000</option>
                            <option value="200000">Under $200,000</option>
                            <option value="300000">Under $300,000</option>
                            <option value="500000">Under $500,000</option>
                            <option value="1000000">Under $1,000,000</option>
                        </select>
                    </div>

                    <button type="submit"><span class="icon"><i class="flaticon-search"></i></span> Search</button>
                </form>
            </div>
        </section>
        <!-- PROPERTY FILTER SEARCH SECTION END -->


        <!-- FEATURED PROPERTIES SECTION START -->
        <section class="ul-featured-properties ul-section-spacing">
            <!-- section title slider -->
            <div class="ul-featured-properties-title-slider splide">
                <div class="splide__track">
                    <ul class="splide__list">
                        <li class="splide__slide">
                            <h2 class="ul-featured-properties-title-txt"><i class="flaticon-star"></i> Featured Properties</h2>
                        </li>
                        <li class="splide__slide">
                            <h2 class="ul-featured-properties-title-txt"><i class="flaticon-star"></i> Featured Properties</h2>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- properties slider -->
            <div class="ul-featured-properties-slider-wrapper wow animate__fadeInUp">
                <div class="ul-featured-properties-slider swiper">
                    <div class="swiper-wrapper">
                        @forelse($featuredProperties as $index => $property)
                            <!-- single property slider item -->
                            <div class="swiper-slide">
                                <div class="ul-featured-property ul-project">
                                    <div>
                                        <div class="header">
                                            <div class="left"><span class="index">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span></div>
                                            <div class="right">
                                                <button class="ul-project-add-to-favorites-btn" data-property-id="{{ $property->id }}">
                                                    <i class="flaticon-heart"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <a href="{{ route('properties.show', $property->id) }}" class="ul-project-title">{{ $property->title }}</a>
                                        <p class="ul-project-location">{{ $property->location_display }}</p>
                                    </div>
                                    <div class="ul-project-img">
                                        <img src="{{ $property->featured_image_url }}" alt="{{ $property->title }}">
                                                                            <span class="ul-project-tag">Available</span>
                                    </div>
                                    <div class="ul-project-txt">
                                        <!-- price -->
                                        <span class="ul-project-price">
                                            <span class="number">{{ $property->formatted_price }}</span>
                                        </span>
                                        <!-- infos -->
                                        <div class="ul-project-infos ul-featured-property-infos">
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-scale"></i></span>
                                                <span class="text">{{ number_format($property->area_sqft) }} sqft</span>
                                            </div>
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-location"></i></span>
                                                <span class="text">{{ $property->location_display }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <!-- Fallback if no featured properties -->
                            <div class="swiper-slide">
                                <div class="ul-featured-property ul-project">
                                    <div>
                                        <div class="header">
                                            <div class="left"><span class="index">01</span></div>
                                            <div class="right">
                                                <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                            </div>
                                        </div>
                                        <a href="{{route('allpropertise')}}" class="ul-project-title">Browse Properties</a>
                                        <p class="ul-project-location">Discover amazing properties</p>
                                    </div>
                                    <div class="ul-project-img">
                                        <img src="assets/img/project-1.jpg" alt="Browse Properties">
                                        <span class="ul-project-tag">New</span>
                                    </div>
                                    <div class="ul-project-txt">
                                        <span class="ul-project-price"><span class="number">Explore</span></span>
                                        <div class="ul-project-infos ul-featured-property-infos">
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-house-2"></i></span>
                                                <span class="text">Properties</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- slider navigation -->
                <div class="ul-featured-properties-slider-nav ul-slider-nav">
                    <button class="prev"><i class="flaticon-arrow"></i></button>
                    <button class="next"><i class="flaticon-right-arrow"></i></button>
                </div>
            </div>
        </section>
        <!-- FEATURED PROPERTIES SECTION END -->


        <!-- FACILITY SECTION START -->
        <section class="ul-facilities ul-section-spacing">
            <div class="ul-container">
                <div class="row ul-bs-row row-cols-lg-2 row-cols-1 wow animate__fadeInUp">
                    <!-- text -->
                    <div class="col">
                        <div class="ul-facilities-txt">
                            <h6 class="ul-section-sub-title">Our Top Facilities</h6>
                            <h2 class="ul-section-title">Making living spaces More Beautiful</h2>
                            <p class="ul-facilities-descr">Over 39,000 people work for us in more than 70 countries all over the This breadth of global coverage, combined with specialist services</p>

                            <div class="ul-facilities-stats">
                                <!-- single stat -->
                                <div class="ul-facilities-stat">
                                    <span class="number">80%</span>
                                    <span class="txt">Completed Property</span>
                                </div>
                                <!-- single stat -->
                                <div class="ul-facilities-stat">
                                    <span class="number">99%</span>
                                    <span class="txt">Satisfied Customers</span>
                                </div>
                                <!-- single stat -->
                                <div class="ul-facilities-stat">
                                    <span class="number">50%</span>
                                    <span class="txt">Home ownership</span>
                                </div>
                            </div>

                            <div class="ul-facilities-list">
                                <ul>
                                    <li>Living rooms are pre-wired for Surround</li>
                                    <li>Luxurious interior design and amenities</li>
                                    <li>Private balconies with stunning views</li>
                                    <li>A rare combination of inspired architecture</li>
                                </ul>
                            </div>

                            <div class="ul-facilities-img-slider-wrapper">
                                <div class="ul-facilities-img-slider-nav ul-slider-nav">
                                    <button class="prev"><i class="flaticon-arrow"></i></button>
                                    <button class="next"><i class="flaticon-right-arrow"></i></button>
                                </div>
                                <div class="ul-facilities-img-slider swiper">
                                <div class="swiper-wrapper">
                                    @forelse($featuredProperties as $index => $property)
                                        <div class="swiper-slide">
                                            <a href="{{ route('properties.show', $property) }}"><img src="{{ $property->featured_image_url }}" alt="{{ $property->title }}"></a>
                                        </div>
                                    @empty
                                        <div class="swiper-slide"><img src="assets/img/project-1.jpg" alt="Facility Image"></div>
                                        <div class="swiper-slide"><img src="assets/img/project-2.jpg" alt="Facility Image"></div>
                                        <div class="swiper-slide"><img src="assets/img/project-3.jpg" alt="Facility Image"></div>
                                        <div class="swiper-slide"><img src="assets/img/project-4.jpg" alt="Facility Image"></div>
                                    @endforelse
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>

                    <!-- img -->
                    <div class="col">
                        <div class="ul-facilities-img"><img src="assets/img/facility-img.jpg" alt="Facility Image"></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- FACILITY SECTION END -->


        <!-- PROPERTIES SECTION START -->
        <section class="ul-properties ul-section-spacing">
            <div class="ul-container">
                <!-- section heading -->
                <div class="ul-section-heading text-center justify-content-center wow animate__fadeInUp">
                    <div>
                        <span class="ul-section-sub-title">Our Properties</span>
                        <h2 class="ul-section-title">We Bring Dream Homes To Reality</h2>
                    </div>
                </div>

                {{-- <div class="ul-properties-tab-navs wow animate__fadeInUp">
                    <button class="tab-nav active" data-tab="tab-rent"><i class="flaticon-key"></i> Rent</button>
                    <button class="tab-nav" data-tab="tab-buy"><i class="flaticon-buy"></i> Buy</button>
                    <button class="tab-nav" data-tab="tab-sell"><i class="flaticon-house-2"></i> Sell</button>
                </div> --}}

                <div class="ul-properties-tab-navs wow animate__fadeInUp">
                    @foreach($categories as $index => $category)
                        <button class="tab-nav {{ $index === 0 ? 'active' : '' }}" data-tab="tab-{{ $category->id }}">
                            <i class="flaticon-house-2"></i> {{ $category->name }}
                        </button>
                    @endforeach
                </div>

                <div class="tabs-wrapper wow animate__fadeInUp">
                     @foreach($categories as $index => $category)
                        <div class="ul-tab {{ $index === 0 ? 'active' : '' }}" id="tab-{{ $category->id }}">
                            <div class="row row-cols-md-3 row-cols-2 row-cols-xxs-1 ul-bs-row">
                                @forelse($category->properties as $property)
                                    <div class="col h-100">
                                        <div class="ul-project h-100">
                                            <div class="ul-project-img">
                                                <img src="{{ $property->featured_image_url }}" alt="{{ $property->title }}">
                                                @if($property->is_featured)
                                                    <span class="ul-project-tag">Featured</span>
                                                @endif
                                            </div>
                                            <div class="ul-project-txt">
                                                <div class="top">
                                                    <div class="left">
                                                        <span class="ul-project-price">
                                                            <span class="number">{{ $property->formatted_price }}</span>
                                                            @if($property->type == 'rent') /Month @endif
                                                        </span>
                                                        <a href="{{ route('properties.show', $property) }}" class="ul-project-title">
                                                            {{ $property->title }}
                                                        </a>
                                                        <p class="ul-project-location">{{ $property->address }}</p>
                                                    </div>
                                                </div>
                                                <div class="ul-project-infos ul-featured-property-infos">
                                                    @if($property->beds)
                                                        <div class="ul-project-info"><i class="flaticon-bed-color"></i> {{ $property->beds }} Beds</div>
                                                    @endif
                                                    @if($property->bathrooms)
                                                        <div class="ul-project-info"><i class="flaticon-bath"></i> {{ $property->bathrooms }} Bathrooms</div>
                                                    @endif
                                                    @if($property->area_sqft)
                                                        <div class="ul-project-info"><i class="flaticon-scale"></i> {{ $property->area_sqft }} sqft</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p>No properties available in {{ $category->name }}</p>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                    <!-- 1st tab / rent -->
                    {{-- <div class="ul-tab active" id="tab-rent">
                        <div class="row row-cols-md-3 row-cols-2 row-cols-xxs-1 ul-bs-row">
                            <!-- single project -->
                            <div class="col">
                                <div class="ul-project">
                                    <div class="ul-project-img"><img src="assets/img/project-1.jpg" alt="Project Image"></div>
                                    <div class="ul-project-txt">
                                        <span class="ul-project-tag">Popular</span>
                                        <div class="top">
                                            <div class="left">
                                                <span class="ul-project-price"><span class="number">$4,500</span>/Month</span>
                                                <a href="project-details.html" class="ul-project-title">Palm Harbor</a>
                                                <p class="ul-project-location">2821 Lake Sevilla, Palm Harbor, TX</p>
                                            </div>
                                            <div class="right">
                                                <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                            </div>
                                        </div>

                                        <!-- bottom -->
                                        <div class="ul-project-infos ul-featured-property-infos">
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bed-color"></i></span>
                                                <span class="text">3 Beds</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bath"></i></span>
                                                <span class="text">2 Bathrooms</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-scale"></i></span>
                                                <span class="text">6x7.5 m²</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- single project -->
                            <div class="col">
                                <div class="ul-project">
                                    <div class="ul-project-img"><img src="assets/img/project-2.jpg" alt="Project Image"></div>
                                    <div class="ul-project-txt">
                                        <span class="ul-project-tag">Popular</span>
                                        <div class="top">
                                            <div class="left">
                                                <span class="ul-project-price"><span class="number">$4,500</span>/Month</span>
                                                <a href="project-details.html" class="ul-project-title">Beverly Springfield</a>
                                                <p class="ul-project-location">2821 Lake Sevilla, Palm Harbor, TX</p>
                                            </div>
                                            <div class="right">
                                                <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                            </div>
                                        </div>

                                        <!-- bottom -->
                                        <div class="ul-project-infos ul-featured-property-infos">
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bed-color"></i></span>
                                                <span class="text">3 Beds</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bath"></i></span>
                                                <span class="text">2 Bathrooms</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-scale"></i></span>
                                                <span class="text">6x7.5 m²</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- single project -->
                            <div class="col">
                                <div class="ul-project">
                                    <div class="ul-project-img"><img src="assets/img/project-3.jpg" alt="Project Image"></div>
                                    <div class="ul-project-txt">
                                        <span class="ul-project-tag">Popular</span>
                                        <div class="top">
                                            <div class="left">
                                                <span class="ul-project-price"><span class="number">$4,500</span>/Month</span>
                                                <a href="project-details.html" class="ul-project-title">Faulkner Ave</a>
                                                <p class="ul-project-location">2821 Lake Sevilla, Palm Harbor, TX</p>
                                            </div>
                                            <div class="right">
                                                <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                            </div>
                                        </div>

                                        <!-- bottom -->
                                        <div class="ul-project-infos ul-featured-property-infos">
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bed-color"></i></span>
                                                <span class="text">3 Beds</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bath"></i></span>
                                                <span class="text">2 Bathrooms</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-scale"></i></span>
                                                <span class="text">6x7.5 m²</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- single project -->
                            <div class="col">
                                <div class="ul-project">
                                    <div class="ul-project-img"><img src="assets/img/project-4.jpg" alt="Project Image"></div>
                                    <div class="ul-project-txt">
                                        <span class="ul-project-tag">Popular</span>
                                        <div class="top">
                                            <div class="left">
                                                <span class="ul-project-price"><span class="number">$4,500</span>/Month</span>
                                                <a href="project-details.html" class="ul-project-title">St. Crystal</a>
                                                <p class="ul-project-location">2821 Lake Sevilla, Palm Harbor, TX</p>
                                            </div>
                                            <div class="right">
                                                <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                            </div>
                                        </div>

                                        <!-- bottom -->
                                        <div class="ul-project-infos ul-featured-property-infos">
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bed-color"></i></span>
                                                <span class="text">3 Beds</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bath"></i></span>
                                                <span class="text">2 Bathrooms</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-scale"></i></span>
                                                <span class="text">6x7.5 m²</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- single project -->
                            <div class="col">
                                <div class="ul-project">
                                    <div class="ul-project-img"><img src="assets/img/project-5.jpg" alt="Project Image"></div>
                                    <div class="ul-project-txt">
                                        <span class="ul-project-tag">Popular</span>
                                        <div class="top">
                                            <div class="left">
                                                <span class="ul-project-price"><span class="number">$4,500</span>/Month</span>
                                                <a href="project-details.html" class="ul-project-title">Cove Red</a>
                                                <p class="ul-project-location">2821 Lake Sevilla, Palm Harbor, TX</p>
                                            </div>
                                            <div class="right">
                                                <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                            </div>
                                        </div>

                                        <!-- bottom -->
                                        <div class="ul-project-infos ul-featured-property-infos">
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bed-color"></i></span>
                                                <span class="text">3 Beds</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bath"></i></span>
                                                <span class="text">2 Bathrooms</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-scale"></i></span>
                                                <span class="text">6x7.5 m²</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- single project -->
                            <div class="col">
                                <div class="ul-project">
                                    <div class="ul-project-img"><img src="assets/img/project-6.jpg" alt="Project Image"></div>
                                    <div class="ul-project-txt">
                                        <span class="ul-project-tag">Popular</span>
                                        <div class="top">
                                            <div class="left">
                                                <span class="ul-project-price"><span class="number">$4,500</span>/Month</span>
                                                <a href="project-details.html" class="ul-project-title">Tarpon Bay</a>
                                                <p class="ul-project-location">2821 Lake Sevilla, Palm Harbor, TX</p>
                                            </div>
                                            <div class="right">
                                                <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                            </div>
                                        </div>

                                        <!-- bottom -->
                                        <div class="ul-project-infos ul-featured-property-infos">
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bed-color"></i></span>
                                                <span class="text">3 Beds</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bath"></i></span>
                                                <span class="text">2 Bathrooms</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-scale"></i></span>
                                                <span class="text">6x7.5 m²</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <!-- 2nd tab / buy -->
                    {{-- <div class="ul-tab" id="tab-buy">
                        <div class="row row-cols-md-3 row-cols-2 row-cols-xxs-1 ul-bs-row">
                            <!-- single project -->
                            <div class="col">
                                <div class="ul-project">
                                    <div class="ul-project-img"><img src="assets/img/project-4.jpg" alt="Project Image"></div>
                                    <div class="ul-project-txt">
                                        <span class="ul-project-tag">Popular</span>
                                        <div class="top">
                                            <div class="left">
                                                <span class="ul-project-price"><span class="number">$4,500</span>/Month</span>
                                                <a href="project-details.html" class="ul-project-title">St. Crystal</a>
                                                <p class="ul-project-location">2821 Lake Sevilla, Palm Harbor, TX</p>
                                            </div>
                                            <div class="right">
                                                <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                            </div>
                                        </div>

                                        <!-- bottom -->
                                        <div class="ul-project-infos ul-featured-property-infos">
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bed-color"></i></span>
                                                <span class="text">3 Beds</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bath"></i></span>
                                                <span class="text">2 Bathrooms</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-scale"></i></span>
                                                <span class="text">6x7.5 m²</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- single project -->
                            <div class="col">
                                <div class="ul-project">
                                    <div class="ul-project-img"><img src="assets/img/project-5.jpg" alt="Project Image"></div>
                                    <div class="ul-project-txt">
                                        <span class="ul-project-tag">Popular</span>
                                        <div class="top">
                                            <div class="left">
                                                <span class="ul-project-price"><span class="number">$4,500</span>/Month</span>
                                                <a href="project-details.html" class="ul-project-title">Cove Red</a>
                                                <p class="ul-project-location">2821 Lake Sevilla, Palm Harbor, TX</p>
                                            </div>
                                            <div class="right">
                                                <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                            </div>
                                        </div>

                                        <!-- bottom -->
                                        <div class="ul-project-infos ul-featured-property-infos">
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bed-color"></i></span>
                                                <span class="text">3 Beds</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bath"></i></span>
                                                <span class="text">2 Bathrooms</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-scale"></i></span>
                                                <span class="text">6x7.5 m²</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- single project -->
                            <div class="col">
                                <div class="ul-project">
                                    <div class="ul-project-img"><img src="assets/img/project-6.jpg" alt="Project Image"></div>
                                    <div class="ul-project-txt">
                                        <span class="ul-project-tag">Popular</span>
                                        <div class="top">
                                            <div class="left">
                                                <span class="ul-project-price"><span class="number">$4,500</span>/Month</span>
                                                <a href="project-details.html" class="ul-project-title">Tarpon Bay</a>
                                                <p class="ul-project-location">2821 Lake Sevilla, Palm Harbor, TX</p>
                                            </div>
                                            <div class="right">
                                                <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                            </div>
                                        </div>

                                        <!-- bottom -->
                                        <div class="ul-project-infos ul-featured-property-infos">
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bed-color"></i></span>
                                                <span class="text">3 Beds</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bath"></i></span>
                                                <span class="text">2 Bathrooms</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-scale"></i></span>
                                                <span class="text">6x7.5 m²</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- single project -->
                            <div class="col">
                                <div class="ul-project">
                                    <div class="ul-project-img"><img src="assets/img/project-1.jpg" alt="Project Image"></div>
                                    <div class="ul-project-txt">
                                        <span class="ul-project-tag">Popular</span>
                                        <div class="top">
                                            <div class="left">
                                                <span class="ul-project-price"><span class="number">$4,500</span>/Month</span>
                                                <a href="project-details.html" class="ul-project-title">Palm Harbor</a>
                                                <p class="ul-project-location">2821 Lake Sevilla, Palm Harbor, TX</p>
                                            </div>
                                            <div class="right">
                                                <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                            </div>
                                        </div>

                                        <!-- bottom -->
                                        <div class="ul-project-infos ul-featured-property-infos">
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bed-color"></i></span>
                                                <span class="text">3 Beds</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bath"></i></span>
                                                <span class="text">2 Bathrooms</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-scale"></i></span>
                                                <span class="text">6x7.5 m²</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- single project -->
                            <div class="col">
                                <div class="ul-project">
                                    <div class="ul-project-img"><img src="assets/img/project-2.jpg" alt="Project Image"></div>
                                    <div class="ul-project-txt">
                                        <span class="ul-project-tag">Popular</span>
                                        <div class="top">
                                            <div class="left">
                                                <span class="ul-project-price"><span class="number">$4,500</span>/Month</span>
                                                <a href="project-details.html" class="ul-project-title">Beverly Springfield</a>
                                                <p class="ul-project-location">2821 Lake Sevilla, Palm Harbor, TX</p>
                                            </div>
                                            <div class="right">
                                                <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                            </div>
                                        </div>

                                        <!-- bottom -->
                                        <div class="ul-project-infos ul-featured-property-infos">
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bed-color"></i></span>
                                                <span class="text">3 Beds</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bath"></i></span>
                                                <span class="text">2 Bathrooms</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-scale"></i></span>
                                                <span class="text">6x7.5 m²</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- single project -->
                            <div class="col">
                                <div class="ul-project">
                                    <div class="ul-project-img"><img src="assets/img/project-3.jpg" alt="Project Image"></div>
                                    <div class="ul-project-txt">
                                        <span class="ul-project-tag">Popular</span>
                                        <div class="top">
                                            <div class="left">
                                                <span class="ul-project-price"><span class="number">$4,500</span>/Month</span>
                                                <a href="project-details.html" class="ul-project-title">Faulkner Ave</a>
                                                <p class="ul-project-location">2821 Lake Sevilla, Palm Harbor, TX</p>
                                            </div>
                                            <div class="right">
                                                <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                            </div>
                                        </div>

                                        <!-- bottom -->
                                        <div class="ul-project-infos ul-featured-property-infos">
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bed-color"></i></span>
                                                <span class="text">3 Beds</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bath"></i></span>
                                                <span class="text">2 Bathrooms</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-scale"></i></span>
                                                <span class="text">6x7.5 m²</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <!-- 3rd tab / sell -->
                    {{-- <div class="ul-tab" id="tab-sell">
                        <div class="row row-cols-md-3 row-cols-2 row-cols-xxs-1 ul-bs-row">
                            <!-- single project -->
                            <div class="col">
                                <div class="ul-project">
                                    <div class="ul-project-img"><img src="assets/img/project-3.jpg" alt="Project Image"></div>
                                    <div class="ul-project-txt">
                                        <span class="ul-project-tag">Popular</span>
                                        <div class="top">
                                            <div class="left">
                                                <span class="ul-project-price"><span class="number">$4,500</span>/Month</span>
                                                <a href="project-details.html" class="ul-project-title">Faulkner Ave</a>
                                                <p class="ul-project-location">2821 Lake Sevilla, Palm Harbor, TX</p>
                                            </div>
                                            <div class="right">
                                                <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                            </div>
                                        </div>

                                        <!-- bottom -->
                                        <div class="ul-project-infos ul-featured-property-infos">
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bed-color"></i></span>
                                                <span class="text">3 Beds</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bath"></i></span>
                                                <span class="text">2 Bathrooms</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-scale"></i></span>
                                                <span class="text">6x7.5 m²</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- single project -->
                            <div class="col">
                                <div class="ul-project">
                                    <div class="ul-project-img"><img src="assets/img/project-4.jpg" alt="Project Image"></div>
                                    <div class="ul-project-txt">
                                        <span class="ul-project-tag">Popular</span>
                                        <div class="top">
                                            <div class="left">
                                                <span class="ul-project-price"><span class="number">$4,500</span>/Month</span>
                                                <a href="project-details.html" class="ul-project-title">St. Crystal</a>
                                                <p class="ul-project-location">2821 Lake Sevilla, Palm Harbor, TX</p>
                                            </div>
                                            <div class="right">
                                                <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                            </div>
                                        </div>

                                        <!-- bottom -->
                                        <div class="ul-project-infos ul-featured-property-infos">
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bed-color"></i></span>
                                                <span class="text">3 Beds</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bath"></i></span>
                                                <span class="text">2 Bathrooms</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-scale"></i></span>
                                                <span class="text">6x7.5 m²</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- single project -->
                            <div class="col">
                                <div class="ul-project">
                                    <div class="ul-project-img"><img src="assets/img/project-1.jpg" alt="Project Image"></div>
                                    <div class="ul-project-txt">
                                        <span class="ul-project-tag">Popular</span>
                                        <div class="top">
                                            <div class="left">
                                                <span class="ul-project-price"><span class="number">$4,500</span>/Month</span>
                                                <a href="project-details.html" class="ul-project-title">Palm Harbor</a>
                                                <p class="ul-project-location">2821 Lake Sevilla, Palm Harbor, TX</p>
                                            </div>
                                            <div class="right">
                                                <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                            </div>
                                        </div>

                                        <!-- bottom -->
                                        <div class="ul-project-infos ul-featured-property-infos">
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bed-color"></i></span>
                                                <span class="text">3 Beds</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bath"></i></span>
                                                <span class="text">2 Bathrooms</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-scale"></i></span>
                                                <span class="text">6x7.5 m²</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- single project -->
                            <div class="col">
                                <div class="ul-project">
                                    <div class="ul-project-img"><img src="assets/img/project-2.jpg" alt="Project Image"></div>
                                    <div class="ul-project-txt">
                                        <span class="ul-project-tag">Popular</span>
                                        <div class="top">
                                            <div class="left">
                                                <span class="ul-project-price"><span class="number">$4,500</span>/Month</span>
                                                <a href="project-details.html" class="ul-project-title">Beverly Springfield</a>
                                                <p class="ul-project-location">2821 Lake Sevilla, Palm Harbor, TX</p>
                                            </div>
                                            <div class="right">
                                                <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                            </div>
                                        </div>

                                        <!-- bottom -->
                                        <div class="ul-project-infos ul-featured-property-infos">
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bed-color"></i></span>
                                                <span class="text">3 Beds</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bath"></i></span>
                                                <span class="text">2 Bathrooms</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-scale"></i></span>
                                                <span class="text">6x7.5 m²</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- single project -->
                            <div class="col">
                                <div class="ul-project">
                                    <div class="ul-project-img"><img src="assets/img/project-5.jpg" alt="Project Image"></div>
                                    <div class="ul-project-txt">
                                        <span class="ul-project-tag">Popular</span>
                                        <div class="top">
                                            <div class="left">
                                                <span class="ul-project-price"><span class="number">$4,500</span>/Month</span>
                                                <a href="project-details.html" class="ul-project-title">Cove Red</a>
                                                <p class="ul-project-location">2821 Lake Sevilla, Palm Harbor, TX</p>
                                            </div>
                                            <div class="right">
                                                <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                            </div>
                                        </div>

                                        <!-- bottom -->
                                        <div class="ul-project-infos ul-featured-property-infos">
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bed-color"></i></span>
                                                <span class="text">3 Beds</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bath"></i></span>
                                                <span class="text">2 Bathrooms</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-scale"></i></span>
                                                <span class="text">6x7.5 m²</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- single project -->
                            <div class="col">
                                <div class="ul-project">
                                    <div class="ul-project-img"><img src="assets/img/project-6.jpg" alt="Project Image"></div>
                                    <div class="ul-project-txt">
                                        <span class="ul-project-tag">Popular</span>
                                        <div class="top">
                                            <div class="left">
                                                <span class="ul-project-price"><span class="number">$4,500</span>/Month</span>
                                                <a href="project-details.html" class="ul-project-title">Tarpon Bay</a>
                                                <p class="ul-project-location">2821 Lake Sevilla, Palm Harbor, TX</p>
                                            </div>
                                            <div class="right">
                                                <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                            </div>
                                        </div>

                                        <!-- bottom -->
                                        <div class="ul-project-infos ul-featured-property-infos">
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bed-color"></i></span>
                                                <span class="text">3 Beds</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bath"></i></span>
                                                <span class="text">2 Bathrooms</span>
                                            </div>
                                            <!-- single info -->
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-scale"></i></span>
                                                <span class="text">6x7.5 m²</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>

                <div class="text-center wow animate__fadeInUp">
                    <a href="{{route('allpropertise')}}" class="ul-btn ul-properties-btn">Browse More Properties</a>
                </div>
            </div>
        </section>
        <!-- PROPERTIES SECTION END -->


        <!-- STATS SECTION START -->
        <div class="ul-stats ul-section-spacing">
            <!-- <div class="ul-container"> -->
            <div class="ul-stats-wrapper wow animate__fadeInUp">
                <div class="ul-stats-item">
                    <i class="flaticon-buildings"></i>
                    <span class="number">{{ $stats['total'] ?? 0 }}+</span>
                    <span class="txt">Total Properties</span>
                </div>
                <div class="ul-stats-item">
                    <i class="flaticon-house-2"></i>
                    <span class="number">{{ $stats['buy'] ?? 0 }}+</span>
                    <span class="txt">Properties for Sale</span>
                </div>
                <div class="ul-stats-item">
                    <i class="flaticon-key"></i>
                    <span class="number">{{ $stats['rent'] ?? 0 }}+</span>
                    <span class="txt">Properties for Rent</span>
                </div>
                <div class="ul-stats-item">
                    <i class="flaticon-star"></i>
                    <span class="number">{{ $stats['featured'] ?? 0 }}+</span>
                    <span class="txt">Featured Properties</span>
                </div>
            </div>
            <!-- </div> -->
        </div>
        <!-- STATS SECTION END -->


        <!-- TESTIMONIAL SECTION START -->
        <section class="ul-testimonial ul-section-spacing">
            <div class="ul-testimonial-container">
                <div class="row row-cols-lg-2 row-cols-1 gx-0 align-items-center flex-lg-row flex-column-reverse gy-5">
                    <!-- img -->
                    <div class="col">
                        <div class="ul-testimonial-img wow animate__fadeInUp">
                            <img src="assets/img/testimonial-img.jpg" alt="Testimonial Image">
                        </div>
                    </div>

                    <!-- testimonial slider -->
                    <div class="col">
                        <div class="ul-testimonial-txt wow animate__fadeInUp">
                            <div class="ul-section-heading">
                                <div>
                                    <span class="ul-section-sub-title">Testimonials</span>
                                    <h2 class="ul-section-title">What Our Clients Say</h2>
                                </div>
                            </div>
                            <div class="ul-testimonial-slider swiper">
                                <div class="swiper-wrapper">
                                    <!-- single slide -->
                                    <div class="swiper-slide">
                                        <div class="ul-testimony">
                                            <div class="top">
                                                <div class="ul-testimony-reviewer-img">
                                                    <img src="assets/img/team-1.jpg" alt="Reviewer Image">
                                                </div>

                                                <div class="ul-testimony-reviewer-info">
                                                    <h3 class="ul-testimony-reviewer-name">Kathryn Murphy</h3>
                                                    <h4 class="ul-testimony-reviewer-role">Medical Assistant</h4>
                                                    <div class="ul-testimony-rating">
                                                        <i class="flaticon-star"></i>
                                                        <i class="flaticon-star"></i>
                                                        <i class="flaticon-star"></i>
                                                        <i class="flaticon-star"></i>
                                                        <i class="flaticon-star"></i>
                                                    </div>
                                                </div>

                                                <div class="ul-testimony-quotation-icon flex-shrink-0">
                                                    <img src="assets/img/quotation-icon.svg" alt="quotaion-icon">
                                                </div>
                                            </div>
                                            <p class="ul-testimony-txt">Consectetur adipiscing elit. Integer nunc viverra laoreet est the is porta pretium metus aliquam eget maecenas porta is nunc viverra Aenean pulvinar maximus leo ”</p>
                                        </div>
                                    </div>

                                    <!-- single slide -->
                                    <div class="swiper-slide">
                                        <div class="ul-testimony">
                                            <div class="top">
                                                <div class="ul-testimony-reviewer-img">
                                                    <img src="assets/img/team-2.jpg" alt="Reviewer Image">
                                                </div>

                                                <div class="ul-testimony-reviewer-info">
                                                    <h3 class="ul-testimony-reviewer-name">Kathryn Murphy</h3>
                                                    <h4 class="ul-testimony-reviewer-role">Medical Assistant</h4>
                                                    <div class="ul-testimony-rating">
                                                        <i class="flaticon-star"></i>
                                                        <i class="flaticon-star"></i>
                                                        <i class="flaticon-star"></i>
                                                        <i class="flaticon-star"></i>
                                                        <i class="flaticon-star"></i>
                                                    </div>
                                                </div>

                                                <div class="ul-testimony-quotation-icon flex-shrink-0">
                                                    <img src="assets/img/quotation-icon.svg" alt="quotaion-icon">
                                                </div>
                                            </div>
                                            <p class="ul-testimony-txt">Consectetur adipiscing elit. Integer nunc viverra laoreet est the is porta pretium metus aliquam eget maecenas porta is nunc viverra Aenean pulvinar maximus leo ”</p>
                                        </div>
                                    </div>

                                    <!-- single slide -->
                                    <div class="swiper-slide">
                                        <div class="ul-testimony">
                                            <div class="top">
                                                <div class="ul-testimony-reviewer-img">
                                                    <img src="assets/img/team-3.jpg" alt="Reviewer Image">
                                                </div>

                                                <div class="ul-testimony-reviewer-info">
                                                    <h3 class="ul-testimony-reviewer-name">Kathryn Murphy</h3>
                                                    <h4 class="ul-testimony-reviewer-role">Medical Assistant</h4>
                                                    <div class="ul-testimony-rating">
                                                        <i class="flaticon-star"></i>
                                                        <i class="flaticon-star"></i>
                                                        <i class="flaticon-star"></i>
                                                        <i class="flaticon-star"></i>
                                                        <i class="flaticon-star"></i>
                                                    </div>
                                                </div>

                                                <div class="ul-testimony-quotation-icon flex-shrink-0">
                                                    <img src="assets/img/quotation-icon.svg" alt="quotaion-icon">
                                                </div>
                                            </div>
                                            <p class="ul-testimony-txt">Consectetur adipiscing elit. Integer nunc viverra laoreet est the is porta pretium metus aliquam eget maecenas porta is nunc viverra Aenean pulvinar maximus leo ”</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- slider pagination -->
                                <div class="ul-testimonial-slider-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- TESTIMONIAL SECTION END -->


        <!-- BLOG SECTION START -->
        <!-- <section class="ul-blogs ul-section-spacing">
            <div class="ul-container wow animate__fadeInUp">
                <div class="ul-section-heading">
                    <div class="left">
                        <span class="ul-section-sub-title">Latest News</span>
                        <h2 class="ul-section-title">Our Latest News & Blog</h2>
                    </div>

                    <div class="right">
                        <a href="blog.html" class="ul-btn ul-blogs-heading-btn">View All News</a>
                    </div>
                </div>


                <div class="row row-cols-lg-2 row-cols-1 ul-bs-row">
                    <div class="col">
                        <div class="ul-blog-wrapper">
                            <div class="ul-blog">
                                <div class="ul-blog-img"><img src="assets/img/blog-1.jpg" alt="Blog Image"></div>
                                <div class="ul-blog-txt">
                                    <div class="ul-blog-infos">
                                        <div class="ul-blog-info">
                                            <span class="icon"><i class="flaticon-user"></i></span>
                                            <span class="text font-normal text-[14px] text-etGray">By Admin</span>
                                        </div>
                                        <div class="ul-blog-info">
                                            <span class="icon"><i class="flaticon-calendar"></i></span>
                                            <span class="text font-normal text-[14px] text-etGray">Jun 24, 2024</span>
                                        </div>
                                    </div>
                                    <a href="blog-details.html" class="ul-blog-title">What to Look for When Buying a Pre-Owned Car Cars Which is Right for You</a>
                                    <p class="ul-blog-excerpt">From luxury and economy cars and find out which best suits your lifestyle economy cars and find</p>
                                    <a href="blog-details.html" class="ul-blog-btn">Read More <span class="icon"><i class="flaticon-aro-left"></i></span></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="ul-blog-wrapper">
                            <div class="ul-blog ul-blog-horizontal">
                                <div class="ul-blog-img"><img src="assets/img/blog-2.jpg" alt="Blog Image"></div>
                                <div class="ul-blog-txt">
                                    <div class="ul-blog-infos">
                                        <div class="ul-blog-info">
                                            <span class="icon"><i class="flaticon-user"></i></span>
                                            <span class="text font-normal text-[14px] text-etGray">By Admin</span>
                                        </div>
                                        <div class="ul-blog-info">
                                            <span class="icon"><i class="flaticon-calendar"></i></span>
                                            <span class="text font-normal text-[14px] text-etGray">Jun 24, 2024</span>
                                        </div>
                                    </div>
                                    <a href="blog-details.html" class="ul-blog-title">What to Look for When Buying a</a>
                                    <p class="ul-blog-excerpt">From luxury and economy cars and find out which best</p>
                                    <a href="blog-details.html" class="ul-blog-btn">Read More <span class="icon"><i class="flaticon-aro-left"></i></span></a>
                                </div>
                            </div>

                            <div class="ul-blog ul-blog-horizontal">
                                <div class="ul-blog-img"><img src="assets/img/blog-3.jpg" alt="Blog Image"></div>
                                <div class="ul-blog-txt">
                                    <div class="ul-blog-infos">
                                        <div class="ul-blog-info">
                                            <span class="icon"><i class="flaticon-user"></i></span>
                                            <span class="text font-normal text-[14px] text-etGray">By Admin</span>
                                        </div>
                                        <div class="ul-blog-info">
                                            <span class="icon"><i class="flaticon-calendar"></i></span>
                                            <span class="text font-normal text-[14px] text-etGray">Jun 24, 2024</span>
                                        </div>
                                    </div>
                                    <a href="blog-details.html" class="ul-blog-title">What to Look for When Buying a</a>
                                    <p class="ul-blog-excerpt">From luxury and economy cars and find out which best</p>
                                    <a href="blog-details.html" class="ul-blog-btn">Read More <span class="icon"><i class="flaticon-aro-left"></i></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
        <!-- BLOG SECTION END -->


        <!-- PARTNERS AREA START -->
        <div class="ul-partners-area" style="margin-top: 30px;">
            <div class="ul-container wow animate__fadeInUp">
                
                <span class="ul-partners-area-title">Trusted by The World's Best</span>

                <div class="ul-partners-slider swiper">
                    <div class="swiper-wrapper align-items-center">
                        <!-- single slide -->
                        @foreach ($partners as $partner)
                            <div class="swiper-slide">
                                <img src="{{ $partner->partner_image }}" alt="Parter Logo">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- PARTNERS AREA END -->


        <!-- APP AD SECTION START -->
        <div class="ul-app-ad wow animate__fadeInUp">
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
@endsection