@extends('dashboard.layouts.app')

@section('title', isset($property) ? 'update Property' : 'Create Property')

@section('content')

    <main class="main-wrapper">
        <div class="main-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Properties</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('properties') }}">Properties</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ isset($property) ? 'Edit Property' : 'Create Property' }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-1 col-xl-1"></div>
                <div class="col-10 col-xl-10">
                    <div class="card rounded-4 border-top border-4 border-primary border-gradient-1">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <div>
                                    <h5 class="mb-0 fw-bold">
                                        {{ isset($property) ? 'Edit Property' : 'Create Property' }}
                                    </h5>
                                </div>
                                <div class="dropdown">
                                    <a href="javascript:;" class="dropdown-toggle-nocaret options dropdown-toggle"
                                        data-bs-toggle="dropdown">
                                        <span class="material-icons-outlined fs-5">more_vert</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('properties') }}">Back to
                                                Properties</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>



                            <form class="row g-4" method="POST"
                                action="{{ isset($property) ? route('property.update', $property->id) : route('properties.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                @if (isset($property))
                                    @method('PUT')
                                @endif

                                <!-- Parent Property -->
                                <div class="col-md-12">
                                    <label for="parent_id" class="form-label">Parent Property</label>
                                    <select id="parent_id" name="parent_id"
                                        class="form-select @error('parent_id') is-invalid @enderror">
                                        <option value="">None</option>
                                        @foreach ($properties as $parent)
                                            <option value="{{ $parent->id }}"
                                           
                                                {{ old('parent_id', $property->parent_id ?? '') == $parent->id ? 'selected' : '' }}>
                                                {{ $parent->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Title -->
                                <div class="col-md-12">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        id="title" name="title" value="{{ old('title', $property->title ?? '') }}"
                                        placeholder="Property Title" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>



                                <div class="col-md-6">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select name="category_id" id="category_id"
                                        class="form-select @error('category_id') is-invalid @enderror" required>
                                        <option value="">-- Select Category --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', $property->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                {{ ucfirst($category->name) }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="type_id" class="form-label">Type</label>
                                    <select name="type_id" id="type_id"
                                        class="form-select @error('type_id') is-invalid @enderror" required>
                                        <option value="">-- Select Type --</option>
                                    </select>
                                    @error('type_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Country -->
                                <div class="col-md-6">
                                    <label for="country_id" class="form-label">Country</label>
                                    <select name="country_id" id="country_id"
                                        class="form-select @error('country_id') is-invalid @enderror" required>
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}"
                                                {{ old('country_id', $property->country_id ?? '') == $country->id ? 'selected' : '' }}>
                                                {{ ucfirst($country->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('country_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="state_id" class="form-label">State</label>
                                    <select name="state_id" id="state_id"
                                        class="form-select @error('state_id') is-invalid @enderror" required>
                                        <option value="">Select State</option>
                                    </select>
                                    @error('state_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="city_id" class="form-label">City</label>
                                    <select name="city_id" id="city_id"
                                        class="form-select @error('city_id') is-invalid @enderror" required>
                                        <option value="">Select City</option>
                                    </select>
                                    @error('city_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- ZIP Code -->
                                <div class="col-md-6">
                                    <label for="zip_code" class="form-label">ZIP Code</label>
                                    <input type="text" class="form-control @error('zip_code') is-invalid @enderror"
                                        id="zip_code" name="zip_code"
                                        value="{{ old('zip_code', $property->zip_code ?? '') }}" placeholder="ZIP Code">
                                    @error('zip_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Address -->
                                <div class="col-md-12">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                                        placeholder="Full address..." rows="3" required>{{ old('address', $property->address ?? '') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Price -->
                                <div class="col-md-6">
                                    <label for="price" class="form-label">Price (USD)</label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror"
                                        id="price" name="price" value="{{ old('price', $property->price ?? '') }}"
                                        placeholder="Price in USD" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="price_type" class="form-label">Price Type</label>
                                    <select name="price_type" id="price_type"
                                        class="form-select @error('price_type') is-invalid @enderror" required>
                                        @foreach (App\Enums\PriceTypeEnum::cases() as $ptype)
                                            <option value="{{ $ptype->value }}"
                                                {{ old('price_type', $property->price_type ?? '') === $ptype->value ? 'selected' : '' }}>
                                                {{ $ptype->label() }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('price_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Area -->
                                <div class="col-md-6">
                                    <label for="area_sqft" class="form-label">Area (sq ft)</label>
                                    <input type="number" class="form-control @error('area_sqft') is-invalid @enderror"
                                        id="area_sqft" name="area_sqft"
                                        value="{{ old('area_sqft', $property->area_sqft ?? '') }}"
                                        placeholder="Area in square feet" required>
                                    @error('area_sqft')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-6">
                                    <label for="beds" class="form-label">Bed Rooms</label>
                                    <input type="number" class="form-control @error('beds') is-invalid @enderror"
                                        id="beds" name="beds" value="{{ old('beds', $property->beds ?? '') }}"
                                        placeholder="Bed Rooms" required>
                                    @error('beds')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="bathrooms" class="form-label">Bath Rooms</label>
                                    <input type="number" class="form-control @error('bathrooms') is-invalid @enderror"
                                        id="bathrooms" name="bathrooms"
                                        value="{{ old('bathrooms', $property->beds ?? '') }}" placeholder="Bath Rooms"
                                        required>
                                    @error('bathrooms')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="parking" class="form-label">Parking</label>
                                    <input type="number" name="parking" id="parking"
                                        value="{{ old('parking', $property->parking ?? '') }}"
                                        class="form-control @error('parking') is-invalid @enderror"
                                        placeholder="Enter number of parking slots">
                                    @error('parking')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <!-- Featured Image -->
                                <div class="col-md-6">
                                    <label for="featured_image" class="form-label">Featured Image</label>
                                    <input class="form-control @error('featured_image') is-invalid @enderror"
                                        type="file" id="featured_image" name="featured_image" accept="image/*">
                                    @error('featured_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if (isset($property) && $property->featured_image)
                                        <div class="mt-2">
                                            <small class="text-muted">Current image:</small>
                                            <img src="{{ $property->featured_image_url }}" alt="Property" class="ms-2"
                                                style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                                        </div>
                                    @endif
                                </div>

                                <!-- Multiple Images -->
                                <div class="col-md-6">
                                    <label for="images" class="form-label">Additional Images</label>
                                    <input class="form-control @error('images.*') is-invalid @enderror" type="file"
                                        id="images" name="images[]" accept="image/*" multiple>
                                    @error('images.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if (isset($property) && $property->hasImages())
                                        <div class="mt-2">
                                            <small class="text-muted">Current images:</small>
                                            <div class="d-flex flex-wrap gap-1 mt-1">
                                                @foreach ($property->images_urls as $image)
                                                    <img src="{{ $image }}" alt="Property"
                                                        style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>

                               {{-- <div class="col-md-6">
                                    <label for="video_url" class="form-label">Video Link (YouTube/Vimeo)</label>
                                    <input type="url" name="video_url" id="video_url"
                                        value="{{ old('video_url', $property->video_url ?? '') }}"
                                        class="form-control @error('video_url') is-invalid @enderror"
                                        placeholder="https://youtube.com/...">
                                    @error('video_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>--}}


                                <div class="col-md-12">
                                    <label class="form-label">Features</label>
                                    <div class="input-group mb-2">
                                        <input type="text" id="featureInput" class="form-control"
                                            placeholder="Enter a feature">
                                        <button type="button" id="addFeatureBtn"
                                            class="btn btn-outline-primary">+</button>
                                    </div>

                                    <div id="featureList" class="d-flex flex-wrap gap-2">
                                        {{-- Already saved features (edit mode) --}}
                                        @php
                                            $featuresValue = old(
                                                'features',
                                                isset($property) && $property->features ? $property->features : '',
                                            );
                                            $oldFeatures = $featuresValue ? explode(',', $featuresValue) : [];
                                        @endphp

                                        @foreach ($oldFeatures as $f)
                                            <span class="badge bg-secondary feature-item d-flex align-items-center gap-1">
                                                <span class="feature-text">{{ $f }}</span>
                                                <button type="button"
                                                    class="btn-close btn-close-white btn-sm remove-feature"></button>
                                            </span>
                                        @endforeach

                                    </div>

                                    {{-- Hidden input to actually submit --}}
                                    <input type="hidden" name="features" id="featuresField"
                                        value="{{ implode(',', $oldFeatures) }}">
                                </div>




                                <!-- Description -->
                                <div class="col-md-12">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                        placeholder="Property description..." rows="4" required>{{ old('description', $property->description ?? '') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Buttons -->
                                <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" class="btn btn-grd-primary px-4 text-white">
                                            Save
                                        </button>
                                        <a href="{{ route('properties') }}" class="btn btn-light px-4">Cancel</a>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-1 col-xl-1"></div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let addBtn = document.getElementById('addFeatureBtn');
            let input = document.getElementById('featureInput');
            let list = document.getElementById('featureList');
            let hidden = document.getElementById('featuresField');

            let features = hidden.value ? hidden.value.split(',') : [];

            // 🔹 Feature Add karna
            addBtn.addEventListener('click', function() {
                let val = input.value.trim();
                if (val !== '' && !features.includes(val)) {
                    features.push(val);

                    // Badge banani
                    let badge = document.createElement('span');
                    badge.className = "badge bg-secondary feature-item d-flex align-items-center gap-1";
                    badge.innerHTML = `
            <span class="feature-text">${val}</span>
            <button type="button" class="btn-close btn-close-white btn-sm remove-feature"></button>
        `;

                    // List me add karo
                    list.appendChild(badge);

                    // Hidden input update karo
                    hidden.value = features.join(',');

                    // Input clear
                    input.value = '';
                }
            });

            // 🔹 Feature Remove karna (event delegation)
            list.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-feature')) {
                    let badge = e.target.closest('.feature-item');
                    let val = badge.querySelector('.feature-text').textContent;

                    // Array se remove
                    features = features.filter(f => f !== val);

                    // Hidden input update
                    hidden.value = features.join(',');

                    // UI se remove
                    badge.remove();
                }
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let countrySelect = document.getElementById('country_id');
            let stateSelect = document.getElementById('state_id');
            let citySelect = document.getElementById('city_id');
            let initialStateId = "{{ old('state_id', $property->state_id ?? '') }}";
            let initialCityId = "{{ old('city_id', $property->city_id ?? '') }}";
            let categorySelect = document.getElementById('category_id');
            let typeSelect = document.getElementById('type_id');
            let initialTypeId = "{{ old('type_id', $property->type_id ?? '') }}";

            // Country change event
            countrySelect.addEventListener('change', function() {
                let countryId = this.value;
                stateSelect.innerHTML = '<option value="">Select State</option>';
                citySelect.innerHTML = '<option value="">Select City</option>';

                if (countryId) {
                    fetch(`/get-states/${countryId}`)
                        .then(res => res.json())
                        .then(data => {
                            data.forEach(state => {
                                let option = new Option(state.name, state.id);
                                stateSelect.add(option);
                            });
                            if (initialStateId && countrySelect.value) {
                                stateSelect.value = initialStateId;
                                initialStateId = null; // Clear after first use
                                stateSelect.dispatchEvent(new Event('change')); // Trigger state change
                            }
                        });
                }
            });

            // State change event
            stateSelect.addEventListener('change', function() {
                let stateId = this.value;
                citySelect.innerHTML = '<option value="">Select City</option>';

                if (stateId) {
                    fetch(`/get-cities/${stateId}`)
                        .then(res => res.json())
                        .then(data => {
                            data.forEach(city => {
                                let option = new Option(city.name, city.id);
                                citySelect.add(option);
                            });
                            // Pre-select city if initial value exists
                            if (initialCityId && stateSelect.value) {
                                citySelect.value = initialCityId;
                                initialCityId = null; // Clear after first use
                            }
                        });
                }
            });

            categorySelect.addEventListener('change', function() {
            let categoryId = this.value;
            typeSelect.innerHTML = '<option value="">Select Type</option>';

            if (categoryId) {
                fetch(`/get-types/${categoryId}`)
                    .then(res => {
                        if (!res.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return res.json();
                    })
                    .then(data => {
                        if (data.length === 0) {
                            let option = new Option('No types available', '');
                            typeSelect.add(option);
                        } else {
                            data.forEach(type => {
                                let option = new Option(type.name, type.id);
                                typeSelect.add(option);
                            });
                            
                            // Pre-select type if initial value exists
                            if (initialTypeId) {
                                typeSelect.value = initialTypeId;
                                initialTypeId = null;
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching types:', error);
                        let option = new Option('Error loading types', '');
                        typeSelect.add(option);
                    });
            }
        });

        // Auto-trigger category change if category is pre-selected
        if (categorySelect.value) {
            categorySelect.dispatchEvent(new Event('change'));
        }

            // Trigger change if country is pre-selected (for edit or validation fail)
            @if ((isset($property) && $property->country_id) || old('country_id'))
                countrySelect.value = "{{ old('country_id', $property->country_id ?? '') }}";
                countrySelect.dispatchEvent(new Event('change'));
            @endif
        });


        // Role-based professional fields toggle (unchanged)
        document.addEventListener("DOMContentLoaded", function() {
            let roleSelect = document.getElementById("role");
            let professionalFields = document.getElementById("professional-fields");

            function toggleProfessionalFields() {
                if (roleSelect.value === "professional") {
                    professionalFields.style.display = "block";
                } else {
                    professionalFields.style.display = "none";
                }
            }

            roleSelect.addEventListener("change", toggleProfessionalFields);
            toggleProfessionalFields(); // Run on page load
        });
    </script>
@endsection
