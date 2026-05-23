@foreach ($properties as $property)
    <div class="col wow animate__fadeInUp">
        <div class="ul-project">
            <div class="ul-project-img">
                <a href="{{ route('properties.show', $property) }}"> <img src="{{ $property->featured_image_url }}"
                        alt="{{ $property->title }}"></a>
            </div>
            <div class="ul-project-txt">
                <span class="ul-project-tag"> {{ $property->category?->name ?? 'N/A' }} </span>
                <div class="top">
                    <div class="left">
                        <span class="ul-project-price">
                            <span class="number">{{ $property->formatted_price }}</span>
                        </span>
                        <a href="{{ route('properties.show', $property) }}"
                            class="ul-project-title">{{ Ucfirst($property->title) }}</a>
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
@endforeach