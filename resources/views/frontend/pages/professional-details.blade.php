@extends('frontend.layouts.app')
@section('title', $user->services->first()->title)
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
            <h2 class="ul-breadcrumb-title">{{ $user->services->first()->title }}</h2>
            <div class="ul-breadcrumb-nav">
                <a href="{{route('home')}}">Home</a>
                <span class="separator"><i class="flaticon-aro-left"></i></span>
                {{-- <a href="{{ route('properties.' . $service->category) }}">{{ ucfirst($service->category) }} Properties</a> --}}
                <span class="separator"><i class="flaticon-aro-left"></i></span>
                <span class="current-page">{{ $user->services->first()->title }}</span>
            </div>
        </div>
    </div>
    <!-- BREADCRUMB SECTION END -->


    <!-- TEAM MEMBER DETAILS SECTION START -->
        <div class="ul-inner-page-content-wrapper">
            <div class="ul-container">

                @if(session('review_message'))
                <div class="alert alert-success">
                    {{ session('review_message') }}
                </div>
                @endif

                @php
                    $averageRating = round($user->serviceReviews->avg('rating'), 1);
                    $filledStars = floor($averageRating);
                    $halfStar = ($averageRating - $filledStars) >= 0.5;
                    $emptyStars = 5 - $filledStars - ($halfStar ? 1 : 0);
                @endphp

                <div class="ul-team-details">
                    <div class="ul-team-details-img wow animate__fadeInUp">
                        <img src="{{ $user->profile_image_url }}" alt="team member image">
                    </div>

                    <!-- txt -->
                    <div class="txt wow animate__fadeInUp">
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
                                                
                        <h3 class="ul-team-details-name"> {{ Ucfirst($user->name) }} </h3>
                        <h6 class="ul-team-details-role"> {{ Ucfirst($user->services->first()->title) }} </h6>
                        <p class="ul-team-details-descr"> {{ $user->services->first()->pivot->personal_information}} </p>
                        <ul class="ul-team-details-infos">
                            <li class="ul-team-details-info"> <span class="key">Phone Number:</span> <a href="tel:{{$user->phone}}"> {{ $user->phone }} </a></li>
                            <li class="ul-team-details-info"><span class="key">Email:</span> <a href="mailto:{{$user->email}}">{{ $user->email }}</a></li>
                            <li class="ul-team-details-info"><span class="key">Experience:</span> {{ $user->services->first()->pivot->experience_years }} Years </li>
                        </ul>

                        <!-- social links -->
                        
                    </div>
                </div>




                @php
                    $images = json_decode($user->services->first()->pivot->images, true);
                @endphp
            
                @if(!empty($images))
                <div class="container">
                    <h3 class="ul-project-details-title mt-5">Professional Works</h3>

                    <div class="swiper ul-project-details-img-slider-thumb">
                        <div class="swiper-wrapper">
                            @foreach($images as $image)
                                <div class="swiper-slide">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Service Image" class="img-fluid rounded thumbnail">
                                </div>
                            @endforeach
                        </div>

                        <!-- navigation -->
                        <div class="ul-slider-nav ul-project-details-img-slider-thumb-nav">
                            <button class="prev"><i class="flaticon-arrow"></i></button>
                            <button class="next"><i class="flaticon-right-arrow"></i></button>
                        </div>
                    </div>
                </div>
                @endif








                <!-- customer review -->
                <!-- <div class="ul-project-details-block wow animate__fadeIn mt-5">
                    <h3 class="ul-project-details-title">Customer Review</h3>
                    <div class="wow animate__fadeInUp">
                        
                        @forelse($user->services->first()->reviews as $review)
                        <div class="ul-project-details-review">
                            <div class="ul-project-details-review-reviewer-img">
                                
                            @if($review->user && $review->user->profile_image_url)
                                <img src="{{ $review->user->profile_image_url }}" alt="Reviewer Image">
                            @else
                                <img src="{{ asset('assets/img/reviewer-img-1.png') }}" alt="Reviewer Image">
                            @endif

                            </div>
                            <div class="ul-project-details-review-txt">
                                <div class="header">
                                    <div class="left">
                                        <h4 class="reviewer-name">{{ $review->name }}</h4>
                                        <h5 class="review-date">{{ $review->created_at->format('F d, Y') }}</h5>
                                    </div>
                                    <div class="right">
                                        <div class="rating">
                                            @for($i=1; $i<=5; $i++)
                                                <i class="flaticon-star {{ $i <= $review->rating ? 'active' : '' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <p>{{ $review->message }}</p>
                            </div>
                        </div>

                        @empty

                        <p>No reviews exists</p>

                        @endforelse
                        
                    </div>
                </div> -->

                <!-- Add a review -->
                @if(auth()->check() && auth()->id() !== $user->id)
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
                            <input type="hidden" name="professional_id" value="{{ $user->id }}"> 
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

            
            

            
            <!-- <div class="ul-team-more-details ul-section-spacing">
                <div class="ul-container wow animate__fadeInUp">
                    <h3 class="ul-team-more-details-title">Personal Information</h3>
                    <p class="ul-team-details-descr"> {{ $user->services->first()->pivot->personal_information}} </p>
                </div>
            </div> -->


            
        </div>
        <!-- TEAM MEMBER DETAILS SECTION END -->
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
