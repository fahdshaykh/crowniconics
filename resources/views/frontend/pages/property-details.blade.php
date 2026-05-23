@extends('frontend.layouts.app')
@section('title', $property->title)
@section('content')
<main>
    <!-- BREADCRUMB SECTION START -->
    <div class="ul-breadcrumb">
        <div class="wow animate__fadeInUp">
            <h2 class="ul-breadcrumb-title">{{ Ucfirst($property->title) }}</h2>
            <div class="ul-breadcrumb-nav">
                <a href="{{ route('home') }}">Home</a>
                <span class="separator"><i class="flaticon-aro-left"></i></span>
                <a href="{{ route('allpropertise') }}">Properties</a>
                <span class="separator"><i class="flaticon-aro-left"></i></span>
                <span class="current-page">{{ $property->title }}</span>
            </div>
        </div>
    </div>
    <!-- BREADCRUMB SECTION END -->

    <div class="ul-inner-page-content-wrapper mb-5">
        <div class="ul-inner-page-container">
            <!-- heading -->
            <div class="ul-project-details-heading">
                <div class="left">
                    <h3 class="ul-project-details-title">{{ Ucfirst($property->title) }}</h3>
                    <span class="ul-project-details-location"><span class="icon"><i class="flaticon-maps-and-flags"></i></span>{{ $property->address }}, {{ $property->location_display }}</span>
                </div>

                <div class="right">
                    <div class="ul-project-details-actions">
                        <button class="ul-project-add-to-favorites-btn {{ auth()->check() && auth()->user()->wishlists()->where('property_id', $property->id)->exists() ? 'ul-project-add-to-favorites-btn-done' : '' }}" 
                                data-property-id="{{ $property->id }}"
                                title="{{ auth()->check() && auth()->user()->wishlists()->where('property_id', $property->id)->exists() ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
                            <i class="{{ auth()->check() && auth()->user()->wishlists()->where('property_id', $property->id)->exists() ? 'flaticon-heart-filled' : 'flaticon-heart' }}" 
                               style="{{ auth()->check() && auth()->user()->wishlists()->where('property_id', $property->id)->exists() ? 'color: #FFD700;' : '' }}"></i>
                        </button>
                    </div>
                    <div class="ul-project-details-price"><span class="number">{{ $property->formatted_price }}</span> {{ $property->price_type ? Ucfirst($property->price_type) : 'No Mention' }}</div>
                </div>
            </div>

            <!-- body -->
            <div class="ul-project-details-body">
                <div class="row gy-5">
                    <!-- left -->
                    <div class="col-lg-8">
                        <!-- img slider -->
                        <div class="ul-project-details-slider-wrapper wow animate__fadeInUp">
                            <div class="swiper ul-project-details-img-slider">
                                <div class="swiper-wrapper">
                                    <div class="main-image">
                                        <img src="{{ $property->featured_image_url }}" alt="{{ $property->title }}" class="img-fluid rounded">
                                        @if($property->is_featured)
                                            <span class="featured-badge">Featured</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($property->hasImages())
                            <div class="swiper ul-project-details-img-slider-thumb">
                                <div class="swiper-wrapper">
                                    @foreach($property->images_urls as $index => $image)
                                    <div class="swiper-slide">
                                        <img src="{{ $image }}" alt="{{ $property->title }}" class="img-fluid rounded thumbnail">
                                    </div>
                                    @endforeach
                                </div>

                                <!-- navigation -->
                                <div class="ul-slider-nav ul-project-details-img-slider-thumb-nav">
                                    <button class="prev"><i class="flaticon-arrow"></i></button>
                                    <button class="next"><i class="flaticon-right-arrow"></i></button>
                                </div>
                            </div>
                            @else
                             @php
                                        $imagePath = $property->featured_image_url && file_exists(public_path($property->featured_image_url))
                                            ? asset($property->featured_image_url)
                                            : asset('images/property.jpg');
                                    @endphp
                            @endif
                        </div>

                        <!-- description -->
                        <div class="ul-project-details-block wow animate__fadeIn">
                            <h3 class="ul-project-details-title">Description</h3>
                            <p> {{ $property->description }} </p>
                        </div>

                        <!-- overview -->
                        <div class="ul-project-details-block wow animate__fadeIn">
                            <h3 class="ul-project-details-title">Overview</h3>
                            <div class="ul-project-details-overview-infos wow animate__fadeInUp">
                                <div class="row row-cols-xl-5 row-cols-sm-4 row-cols-3 row-cols-xxs-2 ul-bs-row">

                                    @if($property->type)
                                    <div class="col">
                                        <div class="ul-project-details-overview-info">
                                            <div class="icon"><i class="flaticon-home-tik-mark"></i></div>
                                            <div class="txt">
                                                <span class="key">Type</span>
                                                <span class="value">{{ $property->type?->name ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if($property->bedrooms)
                                    <div class="col">
                                        <div class="ul-project-details-overview-info">
                                            <div class="icon"><i class="flaticon-bed-color"></i></div>
                                            <div class="txt">
                                                <span class="key">Bedroom</span>
                                                <span class="value"> {{ $property->bedrooms }} </span>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if($property->bathrooms)
                                    <div class="col">
                                        <div class="ul-project-details-overview-info">
                                            <div class="icon"><i class="flaticon-bath"></i></div>
                                            <div class="txt">
                                                <span class="key">Baths</span>
                                                <span class="value"> {{ $property->bathrooms }} </span>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if($property->area_sqft)
                                    <div class="col">
                                        <div class="ul-project-details-overview-info">
                                            <div class="icon"><i class="flaticon-buildings"></i></div>
                                            <div class="txt">
                                                <span class="key">Sqft</span>
                                                <span class="value">{{ number_format($property->area_sqft) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if($property->category)
                                    <div class="col">
                                        <div class="ul-project-details-overview-info">
                                            <div class="icon"><i class="flaticon-house-1"></i></div>
                                            <div class="txt">
                                                <span class="key">Purpose</span>
                                                <span class="value">For {{ $property->category?->name ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if($property->area_sqft)
                                    <div class="col">
                                        <div class="ul-project-details-overview-info">
                                            <div class="icon"><i class="flaticon-parking"></i></div>
                                            <div class="txt">
                                                <span class="key">Parking</span>
                                                <span class="value">{{ $property->parking }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                </div>
                            </div>
                        </div>

                        <!-- preview video -->
                        

                        <!-- Features & aminities -->
                        <div class="ul-project-details-block wow animate__fadeIn">
                            <h3 class="ul-project-details-title">Features & Aminities</h3>
                            <div class="ul-project-details-features wow animate__fadeInUp">
                                @foreach ($property->features_array as $feature)
                                    <span class="feature">
                                        <span class="icon"><i class="flaticon-check-4"></i></span>
                                        <span class="txt">{{ $feature }}</span>
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- location -->

                        <!-- floor plan -->
                        

                        <!-- customer review -->
                        

                        <!-- Add a review -->
                        
                    </div>

                    
                    <!-- right sidebar -->
                    <div class="col-lg-4">
                        <div class="ul-project-details-sidebar wow animate__fadeInUp">
                            <h3 class="ul-project-details-sidebar-title">Contact the Agent</h3>

                            <div class="accordion" id="agentAccordion">

                                <!-- Agent Info -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingAgent">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAgent" aria-expanded="true" aria-controls="collapseAgent">
                                            Agent Information
                                        </button>
                                    </h2>
                                    <div id="collapseAgent" class="accordion-collapse collapse show" aria-labelledby="headingAgent" data-bs-parent="#agentAccordion">
                                        <div class="accordion-body d-flex align-items-center">
                                            <div class="me-3">
                                                <img src="{{ $property->user?->profile_image_url }}" 
                                                    alt="Agent Image" class="rounded-circle" width="80" height="80">
                                            </div>
                                            <div>
                                                <h5>{{ $property->user->name ?? 'No agent' }}</h5>
                                                <span class="text-muted">{{ Ucfirst($property->user->role) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Info -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingContact">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseContact" aria-expanded="false" aria-controls="collapseContact">
                                            Contact Information
                                        </button>
                                    </h2>
                                    <div id="collapseContact" class="accordion-collapse collapse" aria-labelledby="headingContact" data-bs-parent="#agentAccordion">
                                        <div class="accordion-body">
                                            <p><strong>Phone:</strong> <a href="tel:{{ $property->user->phone ?? '' }}">{{ $property->user->phone ?? 'No phone' }}</a></p>
                                            <p><strong>Email:</strong> <a href="mailto:{{ $property->user->email ?? '' }}">{{ $property->user->email ?? 'No Email' }}</a></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Address -->
                                <!-- <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingAddress">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAddress" aria-expanded="false" aria-controls="collapseAddress">
                                            Address
                                        </button>
                                    </h2>
                                    <div id="collapseAddress" class="accordion-collapse collapse" aria-labelledby="headingAddress" data-bs-parent="#agentAccordion">
                                        <div class="accordion-body">
                                            <p>{{ $property->user->address ?? 'No address provided' }}</p>
                                        </div>
                                    </div>
                                </div> -->

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RELATED PROPERTIES SECTION START -->
    <div class="ul-inner-page-content-wrapper wow animate__fadeInUp mt-5 mb-5">
        <div class="ul-inner-page-container">
            <h3 class="ul-section-title mb-4">Related Properties</h3>

            @if($relatedProperties->count())
                <div class="row row-cols-md-3 row-cols-2 row-cols-xxs-1 ul-bs-row">
                    @foreach($relatedProperties as $related)
                        <div class="col wow animate__fadeInUp">
                            <div class="ul-project">
                                <div class="ul-project-img">
                                    <a href="{{ route('properties.show', $related) }}">
                                        <img src="{{ $related->featured_image_url }}" alt="{{ $related->title }}">
                                    </a>
                                </div>
                                <div class="ul-project-txt">
                                    <span class="ul-project-tag">{{ $related->category?->name ?? 'N/A' }}</span>
                                    <div class="top">
                                        <div class="left">
                                            <span class="ul-project-price">
                                                <span class="number">{{ $related->formatted_price }}</span>
                                            </span>
                                            <a href="{{ route('properties.show', $related) }}" class="ul-project-title">
                                                {{ ucfirst($related->title) }}
                                            </a>
                                            <p class="ul-project-location">{{ $related->location_display }}</p>
                                        </div>
                                    </div>
                                    <div class="ul-project-infos">
                                        <div class="ul-project-info">
                                            <span class="icon"><i class="flaticon-bed-color"></i></span>
                                            <span class="text">{{ $related->bedrooms }} Beds</span>
                                        </div>
                                        <div class="ul-project-info">
                                            <span class="icon"><i class="flaticon-bath"></i></span>
                                            <span class="text">{{ $related->bathrooms }} Baths</span>
                                        </div>
                                        <div class="ul-project-info">
                                            <span class="icon"><i class="flaticon-scale"></i></span>
                                            <span class="text">{{ number_format($related->area_sqft) }} sqft</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p>No related properties found.</p>
            @endif
        </div>
    </div>
    <!-- RELATED PROPERTIES SECTION END -->

</main>

<style>
.property-gallery .main-image {
    position: relative;
}
.featured-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    background: #ffc107;
    color: #000;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: bold;
}
.thumbnail-images .thumbnail {
    cursor: pointer;
    transition: opacity 0.3s;
}
.thumbnail-images .thumbnail:hover {
    opacity: 0.8;
}
.property-info-card .property-price {
    color: #28a745;
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}
.property-meta {
    margin: 1.5rem 0;
}
.meta-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
}
.meta-item i {
    margin-right: 0.5rem;
    color: #6c757d;
}
.property-details-list {
    list-style: none;
    padding: 0;
}
.property-details-list li {
    padding: 0.5rem 0;
    border-bottom: 1px solid #f8f9fa;
}
.amenity-item, .feature-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
}
.amenity-item i, .feature-item i {
    margin-right: 0.5rem;
    color: #28a745;
}
.agent-avatar {
    object-fit: cover;
}
.location-details p {
    margin-bottom: 0.5rem;
}
</style>

<script>
// Image gallery functionality
document.querySelectorAll('.thumbnail').forEach(function(thumbnail) {
    thumbnail.addEventListener('click', function() {
        const mainImage = document.querySelector('.main-image img');
        const tempSrc = mainImage.src;
        mainImage.src = this.src;
        this.src = tempSrc;
    });
});

// Map functionality
function initMap() {
    console.log('Map initialized');
}

document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('property-map')) {
        initMap();
    }
});
</script>

<script>
    $(document).ready(function() {
        // Create modal HTML and append to body
        const modalHtml = `
            <div class="modal fade" id="loginPromptModal" tabindex="-1" aria-labelledby="loginPromptModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="loginPromptModalLabel">Login Required</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            You need to be logged in to add or remove properties from your wishlist.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <a href="/login" class="btn btn-primary">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        `;
        $('body').append(modalHtml);

        $('.ul-project-add-to-favorites-btn').each(function() {
            var $button = $(this);
            var propertyId = $button.data('property-id');

            $button.on('click', function() {
                var isAdded = true;
                var url = '/wishlist/add';
                var data = { property_id: propertyId };

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: JSON.stringify(data),
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('#csrf-token').val()
                    },
                    success: function(response) {
                        if (response.message === 'Property removed from wishlist') {
                            alert(response.message || 'Property removed from wishlist');
                            $button.removeClass('ul-project-add-to-favorites-btn-done');
                            // $button.find('i').removeClass('flaticon-heart-filled').addClass('flaticon-heart');
                        } else {
                            alert(response.message || 'Property added to wishlist');
                            $button.addClass('ul-project-add-to-favorites-btn-done');
                            // $button.find('i').removeClass('flaticon-heart').addClass('flaticon-heart-filled');
                        }
                        console.log('Button classes:', $button.attr('class')); // Debug log
                        console.log('Icon classes:', $button.find('i').attr('class')); // Debug log
                        console.log('Icon computed color:', window.getComputedStyle($button.find('i')[0]).color); // Debug computed style
                    },
                    error: function(xhr) {
                        if (xhr.status === 401) {
                            // Show modal instead of alert for unauthorized
                            $('#loginPromptModal').modal('show');
                        } else {
                            var response;
                            try {
                                response = JSON.parse(xhr.responseText);
                            } catch (e) {
                                response = { message: 'Failed to ' + (isAdded ? 'remove from' : 'add to') + ' wishlist.' };
                            }
                            alert(response.message);
                        }
                    }
                });
            });
        });
    });
</script>
@endsection