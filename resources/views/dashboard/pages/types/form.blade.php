 <form class="row g-4" method="POST" action="{{ isset($type) ? route('types.update', $type->id) : route('types.store') }}"
     enctype="multipart/form-data">
     @csrf
     @if (isset($type))
         @method('PUT')
     @endif

     <div class="col-md-12">
         <label for="name" class="form-label">Name</label>
         <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
             value="{{ old('name', $type->name ?? '') }}" placeholder="Enter type name" required>
         @error('name')
             <div class="invalid-feedback">{{ $message }}</div>
         @enderror
     </div>

     <div class="col-md-12">
         <label for="description" class="form-label">Description</label>
         <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
             rows="4" placeholder="Enter type description">{{ old('description', $type->description ?? '') }}</textarea>
         @error('description')
             <div class="invalid-feedback">{{ $message }}</div>
         @enderror
     </div>

     <div class="col-md-6">
         <label for="category_id" class="form-label">Select Category</label>
         <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror"
             required>
             <option value="">Choose...</option>
             @foreach ($categories as $category)
                 <option value="{{ $category->id }}"
                     {{ (string) old('category_id', $type->category_id ?? '') === (string) $category->id ? 'selected' : '' }}>
                     {{ $category->name }}
                 </option>
             @endforeach
         </select>
         @error('category_id')
             <div class="invalid-feedback">{{ $message }}</div>
         @enderror
     </div>


     <div class="col-md-12">
         <div class="d-md-flex d-grid align-items-center gap-3">
             <button type="submit" class="btn btn-grd-primary px-4 text-white">
                 {{ isset($type) ? 'Update Type' : 'Create Type' }}
             </button>
             <a href="{{ route('types.index') }}" class="btn btn-light px-4">Cancel</a>
         </div>
     </div>
 </form>
