@extends('frontend.layouts.app')
@section('title', $service->title)
@section('content')

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


<!-- put this in your <style> area (replace older .rating styles) -->
<style>
    /* display ratings (plain i elements) */
    .rating i {
        font-size: 30px;
        color: gray; /* default */
        cursor: pointer;
        transition: color 0.2s;
    }
    .rating i.active,
    .rating i.hover {
        color: gold;
    }

    /* form rating buttons */
    .rating-field {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .rating-field button {
        background: transparent;
        border: none;
        padding: 0;
        cursor: pointer;
    }
    /* make the <i> ignore pointer events so the button receives the click */
    .rating-field button i {
        font-size: 30px;
        color: gray;
        transition: color 0.2s;
        pointer-events: none;
    }
    .rating-field button.active i,
    .rating-field button.hover i {
        color: gold;
    }
</style>


<main>
    <!-- BREADCRUMB SECTION START -->
    <div class="ul-breadcrumb">
        <div class="wow animate__fadeInUp">
            <h2 class="ul-breadcrumb-title">{{ Ucfirst($service->title) }}</h2>
            <div class="ul-breadcrumb-nav">
                <a href="{{route('home')}}">Home</a>
                <span class="separator"><i class="flaticon-aro-left"></i></span>
                 <a href="{{ route('allpropertise') }}">Properties</a> 
                <span class="separator"><i class="flaticon-aro-left"></i></span>
                <span class="current-page">{{ $service->title }}</span>
            </div>
        </div>
    </div>
    <!-- BREADCRUMB SECTION END -->

    <div class="ul-inner-page-content-wrapper mb-5">
        <div class="ul-inner-page-container">
            <!-- heading -->
            @php
                $averageRating = round($service->reviews->avg('rating'), 1);
                $filledStars = floor($averageRating);
                $halfStar = ($averageRating - $filledStars) >= 0.5;
                $emptyStars = 5 - $filledStars - ($halfStar ? 1 : 0);
            @endphp

            <div class="ul-project-details-heading">
                <div class="left">
                    <h3 class="ul-project-details-title" style="text-align: center;"> {{ Ucfirst($service->title) }} </h3>
                    
                    <p>
                        Rating:
                        <span class="stars">
                            {{-- filled stars --}}
                            @for($i = 0; $i < $filledStars; $i++)
                                <i class="flaticon-star-1 text-warning"></i>
                            @endfor

                            {{-- half star --}}
                            @if($halfStar)
                                <i class="flaticon-star-half text-warning"></i>
                            @endif

                            {{-- empty stars --}}
                            @for($i = 0; $i < $emptyStars; $i++)
                                <i class="flaticon-star-1 text-muted"></i>
                            @endfor
                        </span>
                        <small>({{ $averageRating }}/5)</small>
                    </p>
                </div>

                <div class="right">
                    <div class="ul-project-details-actions">
                        <!-- share -->
                        <!-- <button class="ul-project-details-action">
                            <span class="icon"><i class="flaticon-heart"></i></span>
                            <span>Save</span>
                        </button> -->
                        <!-- share -->
                        
                        <!-- share -->
                        
                    </div>
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
                                        <img src="{{ $service->service_image }}" alt="{{ $service->title }}" class="img-fluid rounded">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- description -->
                        <div class="ul-project-details-block wow animate__fadeIn">
                            <h3 class="ul-project-details-title">Description</h3>
                            <p> {{ $service->description }} </p>
                        </div>

                        <!-- overview -->
                        <div class="ul-project-details-block wow animate__fadeIn">
                            <h3 class="ul-project-details-title">Overview</h3>
                            <div class="ul-project-details-overview-infos wow animate__fadeInUp">
                                <div class="row row-cols-xl-5 row-cols-sm-4 row-cols-3 row-cols-xxs-2 ul-bs-row">

                                    @if($service->category)
                                    <div class="col">
                                        <div class="ul-project-details-overview-info">
                                            <div class="icon"><i class="flaticon-house-1"></i></div>
                                            <div class="txt">
                                                <span class="key">Category</span>
                                                <span class="value">{{ $service->category?->name ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if($service->type)
                                    <div class="col">
                                        <div class="ul-project-details-overview-info">
                                            <div class="icon"><i class="flaticon-home-tik-mark"></i></div>
                                            <div class="txt">
                                                <span class="key">Type</span>
                                                <span class="value">{{ $service->type?->name ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if($service->professionals)
                                    <div class="col">
                                        <div class="ul-project-details-overview-info">
                                            <div class="icon"><i class="flaticon-tools"></i></div>
                                            <div class="txt">
                                                <span class="key">Professionals</span>
                                                <span class="value"> {{ $service->professionals->count() }} </span>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                </div>
                            </div>
                        </div>

                        <!-- preview video -->
                        
                        

                        <!-- Features & aminities -->

                        <!-- location -->

                        <!-- floor plan -->
                        

                        <!-- customer review -->
                        

                        <!-- Add a review -->
                        @if(auth()->check())
                            @if($existingReview)
                                <div class="alert alert-info mt-4">
                                    You already rated this professional 
                                    <strong>{{ $existingReview->rating }}</strong> out of 5 ⭐.
                                </div>
                            @else
                                <div class="ul-project-details-block ul-project-details-review-form-wrapper wow animate__fadeIn mt-4">
                                    <h3 class="ul-project-details-title">Add a Review</h3>
                                    <form id="reviewForm" action="{{ route('service.review.store') }}" method="POST" class="ul-project-details-review-form wow animate__fadeInUp">
                                        @csrf
                                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                                        <input type="hidden" name="rating" id="review-rating" value="0">

                                        <div class="form-group rating-field-wrapper">
                                            <span class="title">Your Rating:</span>
                                            <div class="rating-field">
                                                <button type="button"><i class="flaticon-star-1"></i></button>
                                                <button type="button"><i class="flaticon-star-1"></i></button>
                                                <button type="button"><i class="flaticon-star-1"></i></button>
                                                <button type="button"><i class="flaticon-star-1"></i></button>
                                                <button type="button"><i class="flaticon-star-1"></i></button>
                                            </div>
                                        </div>

                                        <div class="form-group mt-3">
                                            <button type="submit" class="btn btn-primary">Submit Rating</button>
                                        </div>
                                    </form>
                                    <div id="review-message" class="mt-3"></div>
                                </div>
                            @endif
                        @elseif(auth()->check() && auth()->id() === $user->id)
                            <div class="alert alert-secondary mt-4">
                                You cannot rate yourself.
                            </div>
                        @else
                            <div class="alert alert-warning mt-4">
                                Please <a href="{{ route('login') }}">login</a> to submit a rating.
                            </div>
                        @endif

                        
                    </div>

                    
                    <!-- right sidebar -->
                    <div class="col-lg-4">
                        <div class="ul-project-details-block wow animate__fadeIn">
                            <div class="row ul-bs-row row-cols-lg-2 row-cols-md-3 row-cols-3 row-cols-xxs-1">
                                @forelse($service->professionals as $professional)
                                @php
                                    $averageRating = round($professional->serviceReviews->avg('rating'), 1);
                                    $filledStars = floor($averageRating);
                                    $halfStar = ($averageRating - $filledStars) >= 0.5;
                                    $emptyStars = 5 - $filledStars - ($halfStar ? 1 : 0);
                                @endphp
                                    <!-- single team -->
                                    <div class="col">
                                        <div class="ul-team-card">
                                            <div class="ul-team-card-img">
                                                <a href="{{ route('professional.show', $professional) }}">
                                                    <img src="{{ $professional->profile_image_url }}" alt="{{ $professional->name }}">
                                                </a>
                                            </div>

                                            <div class="ul-team-card-txt">
                                                <h5 class="ul-team-card-title"><a href="{{ route('professional.show', $professional) }}"> {{ $professional->name }} </a></h5>
                                                <span class="ul-team-card-subtitle"><a href="tel:01236547890"> {{ $professional->phone }} </a></span>
                                                <span class="ul-team-card-subtitle d-block mt-1">
                                                Rating:
                                                <!-- <span class="stars">
                                                    {{-- filled stars --}}
                                                    @for($i = 0; $i < $filledStars; $i++)
                                                        <i class="flaticon-star-1 text-warning"></i>
                                                    @endfor

                                                    {{-- half star --}}
                                                    @if($halfStar)
                                                        <i class="flaticon-star-half text-warning"></i>
                                                    @endif

                                                    {{-- empty stars --}}
                                                    @for($i = 0; $i < $emptyStars; $i++)
                                                        <i class="flaticon-star-1 text-muted"></i>
                                                    @endfor
                                                </span> -->
                                                <small>({{ $averageRating }}/5)</small>
                                                </span>
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
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</main>

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

// Map functionality (you can integrate with Google Maps or other map services)
function initMap() {
    // Initialize map here
    console.log('Map initialized');
}

// Load map when page loads
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('property-map')) {
        initMap();
    }
});
</script>



<script>
document.addEventListener('DOMContentLoaded', function() {

    // -----------------------
    // 1) Make .rating (display) clickable + hover preview
    // -----------------------
    document.querySelectorAll('.rating').forEach(function(ratingEl) {
        const icons = ratingEl.querySelectorAll('i');
        icons.forEach(function(icon, idx) {
            // click
            icon.addEventListener('click', function() {
                icons.forEach(i => i.classList.remove('active'));
                for (let i = 0; i <= idx; i++) icons[i].classList.add('active');
            });
            // hover preview
            icon.addEventListener('mouseover', function() {
                icons.forEach(i => i.classList.remove('hover'));
                for (let i = 0; i <= idx; i++) icons[i].classList.add('hover');
            });
            icon.addEventListener('mouseout', function() {
                icons.forEach(i => i.classList.remove('hover'));
            });
        });
    });

    // -----------------------
    // 2) Make .rating-field (form buttons) interactive and store value
    // -----------------------
    document.querySelectorAll('.rating-field').forEach(function(field) {
        const buttons = field.querySelectorAll('button');
        const hidden = document.getElementById('review-rating'); // the hidden input
        buttons.forEach(function(btn, idx) {
            // click: set active up to clicked
            btn.addEventListener('click', function() {
                buttons.forEach(b => b.classList.remove('active'));
                for (let i = 0; i <= idx; i++) buttons[i].classList.add('active');

                // store rating (1-based)
                field.dataset.rating = (idx + 1);
                if (hidden) hidden.value = idx + 1;
            });

            // hover preview
            btn.addEventListener('mouseover', function() {
                buttons.forEach(b => b.classList.remove('hover'));
                for (let i = 0; i <= idx; i++) buttons[i].classList.add('hover');
            });
            btn.addEventListener('mouseout', function() {
                buttons.forEach(b => b.classList.remove('hover'));
            });
        });
    });
    document.getElementById('reviewForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = this;
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            const msgDiv = document.getElementById('review-message');
            if (data.success) {
                msgDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                // form.reset();
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
                document.querySelectorAll('.rating-field button').forEach(btn => btn.classList.remove('active'));
            } else {
                msgDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
            }
        })
        .catch(err => {
            console.error(err);
            document.getElementById('review-message').innerHTML = `<div class="alert alert-danger">Something went wrong.</div>`;
        });
    });

});
</script>

@endsection
