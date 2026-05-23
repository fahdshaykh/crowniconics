<style>
    /* When there’s only one slide */
.swiper-wrapper:only-child,
.swiper-wrapper .swiper-slide:only-child {
  display: flex !important;
  justify-content: center;
  width: 100% !important;
  transform: none !important;
}

.swiper-slide:only-child {
  max-width: 100% !important;
  flex: 1 1 100% !important;
}

</style>
<!-- SIDEBAR SECTION START -->
<div class="ul-sidebar">
    <!-- header -->
    <div class="ul-sidebar-header">
        <div class="ul-sidebar-header-logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets') }}/img/logo.png" alt="logo" class="logo">
            </a>
        </div>
        <!-- sidebar closer -->
        <button class="ul-sidebar-closer"><i class="flaticon-close"></i></button>
    </div>

    <div class="ul-sidebar-header-nav-wrapper d-block d-lg-none"></div>

    <p class="ul-sidebar-descr d-none d-lg-flex">
        Discover your favorite properties right here! Your wishlist showcases all the homes you've saved, making it easy to keep track of the places you love. Browse through your selections, revisit their details, and remove any you no longer want, all from this convenient sidebar on every page!
    </p>

    <!-- Wishlist Slider -->
    <div class="ul-sidebar-slider-wrapper d-none d-lg-flex">
        <div class="ul-sidebar-slider-nav ul-slider-nav">
            <button class="prev"><i class="flaticon-arrow"></i></button>
            <button class="next"><i class="flaticon-right-arrow"></i></button>
        </div>

        <div class="slider-wrapper">
            <div class="ul-sidebar-slider swiper">
                @if (!empty($wishlist))
                    <div class="swiper-wrapper">
                        @forelse ($wishlist as $item)
                            <div class="swiper-slide">
                                <div class="ul-project">
                                    <div class="ul-project-img">
                                        <a href="{{ $item['property_url'] }}">
                                            <img src="{{ $item['featured_image_url'] }}" alt="{{ $item['title'] }}">
                                        </a>
                                    </div>
                                    <div class="ul-project-txt">
                                        <span class="ul-project-tag">{{ $item['category_name'] }}</span>
                                        <div class="top">
                                            <div class="left">
                                                <span class="ul-project-price">
                                                    <span class="number">{{ $item['formatted_price'] }}</span>
                                                </span>
                                                <a href="{{ $item['property_url'] }}" class="ul-project-title">{{ $item['title'] }}</a>
                                                <p class="ul-project-location">{{ $item['location_display'] }}</p>
                                            </div>
                                            <div class="right">
                                                <button class="ul-project-add-to-favorites-btn {{ auth()->check() && auth()->user()->wishlists()->where('property_id', $item['property_id'])->exists() ? 'ul-project-add-to-favorites-btn-done' : '' }}" 
                                                        data-property-id="{{ $item['property_id'] }}" 
                                                        title="{{ auth()->check() && auth()->user()->wishlists()->where('property_id', $item['property_id'])->exists() ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
                                                    <i class="{{ auth()->check() && auth()->user()->wishlists()->where('property_id', $item['property_id'])->exists() ? 'flaticon-heart-filled' : 'flaticon-heart' }}" 
                                                       style="{{ auth()->check() && auth()->user()->wishlists()->where('property_id', $item['property_id'])->exists() ? 'color: #FFD700;' : '' }}"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="ul-project-infos ul-featured-property-infos">
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bed-color"></i></span>
                                                <span class="text">{{ $item['beds'] }} Beds</span>
                                            </div>
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bath"></i></span>
                                                <span class="text">{{ $item['bathrooms'] }} Bathrooms</span>
                                            </div>
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-scale"></i></span>
                                                <span class="text">{{ $item['area_sqft'] }} sqft</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>No items in your wishlist.</p>
                        @endforelse
                    </div>
                @else
                    <p>No items in your wishlist.</p>
                @endif
            </div>
        </div>
    </div>

    <input type="hidden" id="csrf-token" value="{{ csrf_token() }}">

    <!-- sidebar footer -->
    <!-- <div class="ul-sidebar-footer">
        <span class="ul-sidebar-footer-title">Follow us</span>
        <div class="ul-sidebar-footer-social">
            <a href="#"><i class="flaticon-facebook"></i></a>
            <a href="#"><i class="flaticon-twitter"></i></a>
            <a href="#"><i class="flaticon-instagram"></i></a>
            <a href="#"><i class="flaticon-linkedin"></i></a>
        </div>
    </div> -->
</div>
<!-- SIDEBAR SECTION END -->