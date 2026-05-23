@extends('dashboard.layouts.app')

@section('title', 'create service')

@section('content')
<main class="main-wrapper">
    <div class="main-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Services</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('services.index') }}">Services</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Create service
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
                                    Create service
                                </h5>
                            </div>
                            <div class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle-nocaret options dropdown-toggle"
                                    data-bs-toggle="dropdown">
                                    <span class="material-icons-outlined fs-5">more_vert</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('services.index') }}">Back to
                                            Services</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('services.create') }}">Create New
                                            service</a></li>
                                </ul>
                            </div>
                        </div>



                        <form class="row g-4" method="POST"
                            action="{{ route('services.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <!-- Title -->
                            <div class="col-md-12">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title', $service->title ?? '') }}"
                                    placeholder="Service Title" required>
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
                                        {{ old('category_id', $service->category_id ?? '') == $category->id ? 'selected' : '' }}>
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
                                    @foreach ($types as $type)
                                    <option value="{{ $type->id }}"
                                        {{ old('type_id', $service->type_id ?? '') == $type->id ? 'selected' : '' }}>
                                        {{ ucfirst($type->name) }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Featured Image -->
                            <div class="col-md-12">
                                <label for="image" class="form-label">Service Image</label>
                                <input class="form-control @error('image') is-invalid @enderror"
                                    type="file" id="image" name="image" accept="image/*">
                                @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <!-- Description -->
                            <div class="col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    placeholder="Service description..." rows="4" required>{{ old('description', $service->description ?? '') }}</textarea>
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
                                    <a href="{{ route('services.index') }}" class="btn btn-light px-4">Cancel</a>
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

        // addBtn.addEventListener('click', function () {
        //     alert('Button clicked!');
        // });

        // Hidden input ka initial value → array bana lo
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

<!-- <script>
    document.addEventListener("DOMContentLoaded", function () {
        const categorySelect = document.getElementById("category_id");
        const typeSelect = document.getElementById("type_id");

        categorySelect.addEventListener("change", function () {
            const categoryId = this.value;

            // Clear types dropdown first
            typeSelect.innerHTML = '<option value="">-- Select Type --</option>';

            if (categoryId) {
                const url = "{{ route('services.getTypes', ':id') }}".replace(':id', categoryId);

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(type => {
                            let option = document.createElement("option");
                            option.value = type.id;
                            option.textContent = type.name;
                            typeSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error("Error fetching types:", error));
            }
        });
    });
</script>    -->

@endsection