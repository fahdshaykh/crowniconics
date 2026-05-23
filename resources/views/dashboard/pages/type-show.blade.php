@extends('dashboard.layouts.app')
@section('content')

<main class="main-wrapper">
    <div class="main-content">
        <div class="container">
            <h2 class="mb-4">Type Details</h2>
            <div class="card">
                <div class="card-body">
                    <h4>{{ $type->name }}</h4>
                    <p><strong>Category:</strong> {{ $type->categoryDetail->name }}</p>
                    <p><strong>Description:</strong> {{ $type->description }}</p>
                    <p><strong>Created At:</strong> {{ $type->created_at->format('d M, Y h:i A') }}</p>
                    <p><strong>Updated At:</strong> {{ $type->updated_at->format('d M, Y h:i A') }}</p>
                    <p><strong>Status:</strong> 
                        @if($type->status)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('types.index') }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('type.edit', $type->id) }}" class="btn btn-primary">Edit</a>
            </div>
        </div>
    </div>
</main>

@endsection
