<form class="row g-4" method="POST"
    action="{{ isset($category) ? route('category.update', $category->id) : route('category.store') }}"
    enctype="multipart/form-data">
    @csrf
    @if (isset($category))
        @method('PUT')
    @endif

    <div class="col-md-12">
        <label for="main_category_id" class="form-label">Select Main Category</label>
        <select id="main_category_id" name="main_category_id" class="form-select @error('parent_id') is-invalid @enderror">
            <option value="">Choose...</option>
            @foreach ($categories as $main_category)
                <option value="{{ $main_category->id }}"
                    {{ old('main_category', $category->id ?? '') == $main_category->id ? 'selected' : '' }}>
                    {{ $main_category->name }}
                </option>
            @endforeach
        </select>
        @error('parent_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    <div class="col-md-12">
        <label for="name" class="form-label">Category Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
            value="{{ old('name', $category->name ?? '') }}" placeholder="Enter category name" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>



    <div class="col-md-12">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
            rows="4" placeholder="Enter category description">{{ old('description', $category->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12">
        <div class="d-md-flex d-grid align-items-center gap-3">
            <button type="submit" class="btn btn-grd-primary px-4 text-white">
                Save
            </button>
            <a href="{{ route('categories.index') }}" class="btn btn-light px-4">Cancel</a>
        </div>
    </div>
</form>
