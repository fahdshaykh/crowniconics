$(document).ready(function() {
    // Initialize Swiper for wishlist slider
    var wishlistSwiper = new Swiper('.ul-sidebar-slider', {
        slidesPerView: 1,
        spaceBetween: 10,
        navigation: {
            nextEl: '.ul-sidebar-slider-nav .next',
            prevEl: '.ul-sidebar-slider-nav .prev',
        },
    });

    // Create login modal
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

    // Initialize wishlist buttons
    function initializeWishlistButtons() {
        $('.ul-project-add-to-favorites-btn').off('click').each(function() {
            var $button = $(this);
            var propertyId = $button.data('property-id');

            // Check initial wishlist status
            if (propertyId) {
                $.ajax({
                    url: '/wishlist/check/' + propertyId,
                    type: 'GET',
                    success: function(response) {
                        if (response.in_wishlist) {
                            $button.addClass('added-to-wishlist ul-project-add-to-favorites-btn-done');
                            $button.find('i').removeClass('flaticon-heart').addClass('flaticon-heart-filled').css('color', '#FFD700');
                            $button.attr('title', 'Remove from Wishlist');
                        } else {
                            $button.removeClass('added-to-wishlist ul-project-add-to-favorites-btn-done');
                            $button.find('i').removeClass('flaticon-heart-filled').addClass('flaticon-heart').css('color', '');
                            $button.attr('title', 'Add to Wishlist');
                        }
                    },
                    error: function() {
                        console.error('Failed to check wishlist status for property ' + propertyId);
                    }
                });
            }

            $button.on('click', function() {
                var isAdded = $button.hasClass('added-to-wishlist');
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
                            $button.removeClass('added-to-wishlist ul-project-add-to-favorites-btn-done');
                            $button.find('i').removeClass('flaticon-heart-filled').addClass('flaticon-heart').css('color', '');
                            $button.attr('title', 'Add to Wishlist');
                            // Remove from wishlist slider if in sidebar
                            var $slide = $button.closest('.swiper-slide');
                            if ($slide.length) {
                                wishlistSwiper.removeSlide($slide.index());
                                // Update "No items" message if wishlist is empty
                                if (wishlistSwiper.slides.length === 0) {
                                    $('.ul-sidebar-slider').html('<p>No items in your wishlist.</p>');
                                }
                            }
                            // alert(response.message);
                        } else {
                            $button.addClass('added-to-wishlist ul-project-add-to-favorites-btn-done');
                            $button.find('i').removeClass('flaticon-heart').addClass('flaticon-heart-filled').css('color', '#FFD700');
                            $button.attr('title', 'Remove from Wishlist');
                            // Refresh wishlist slider if added
                            if ($button.closest('.ul-sidebar-slider').length) {
                                refreshWishlist();
                            }
                            // alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 401) {
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
    }

    // Initialize buttons on page load
    initializeWishlistButtons();

    // Function to refresh wishlist slider
    function refreshWishlist() {
        $.ajax({
            url: '/wishlist',
            type: 'GET',
            success: function(response) {
                const $swiperWrapper = $('.ul-sidebar-slider .swiper-wrapper');
                $swiperWrapper.empty();
                if (response.wishlist.length > 0) {
                    response.wishlist.forEach(item => {
                        const wishlistItemHtml = `
                            <div class="swiper-slide">
                                <div class="ul-project">
                                    <div class="ul-project-img">
                                        <a href="${item.property_url}">
                                            <img src="${item.featured_image_url}" alt="${item.title}">
                                        </a>
                                    </div>
                                    <div class="ul-project-txt">
                                        <span class="ul-project-tag">${item.category_name}</span>
                                        <div class="top">
                                            <div class="left">
                                                <span class="ul-project-price">
                                                    <span class="number">${item.formatted_price}</span>
                                                </span>
                                                <a href="${item.property_url}" class="ul-project-title">${item.title}</a>
                                                <p class="ul-project-location">${item.location_display}</p>
                                            </div>
                                            <div class="right">
                                                <button class="ul-project-add-to-favorites-btn ul-project-add-to-favorites-btn-done" data-property-id="${item.property_id}" title="Remove from Wishlist">
                                                    <i class="flaticon-heart-filled" style="color: #FFD700;"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="ul-project-infos ul-featured-property-infos">
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bed-color"></i></span>
                                                <span class="text">${item.beds} Beds</span>
                                            </div>
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-bath"></i></span>
                                                <span class="text">${item.bathrooms} Bathrooms</span>
                                            </div>
                                            <div class="ul-project-info ul-featured-property-info">
                                                <span class="icon"><i class="flaticon-scale"></i></span>
                                                <span class="text">${item.area_sqft} sqft</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        $swiperWrapper.append(wishlistItemHtml);
                    });
                    // Reinitialize Swiper
                    wishlistSwiper.update();
                    // Reinitialize buttons for new slides
                    initializeWishlistButtons();
                } else {
                    $('.ul-sidebar-slider').html('<p>No items in your wishlist.</p>');
                }
            },
            error: function() {
                console.error('Failed to refresh wishlist');
            }
        });
    }
});