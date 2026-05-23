@extends('dashboard.layouts.app')
@section('content')
<main class="main-wrapper">
    <div class="main-content">
        <div class="container">
            <h2 class="mb-4">Category Details</h2>

            <div class="card">
                <div class="card-body">
                    <h4>{{ $category->name }}</h4>
                    <p><strong>Main Category:</strong> {{ $category->mainCategory->name  ?? '-' }}</p>
                    <p><strong>Description:</strong> {{ $category->description }}</p>
                    <p><strong>Created At:</strong> {{ $category->created_at->format('d M, Y h:i A') }}</p>
                    <p><strong>Updated At:</strong> {{ $category->updated_at->format('d M, Y h:i A') }}</p>
                    <p><strong>Status:</strong>
                        @if ($category->status->value)
                        <span class="badge bg-success">Active</span>
                        @else
                        <span class="badge bg-danger">Inactive</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('category.edit', $category->id) }}" class="btn btn-primary">Edit</a>
            </div>
        </div>
    </div>
</main>
@endsection