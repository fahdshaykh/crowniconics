@extends('dashboard.layouts.app')
@section('title', 'users') 
@section('content')

  <!--start main wrapper-->
  <main class="main-wrapper">
    <div class="main-content">
     <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Users</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Users</li>
                    </ol>
                </nav>
            </div>
        </div>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row row-cols-auto g-3">
            <div class="col">
                <button type="button" class="btn btn-grd-primary">All users <span class="badge bg-dark">{{ $users->total() }}</span>
                </button>
            </div> 
            <div class="col">
                <button type="button" class="btn btn-grd-danger">Agents <span class="badge bg-dark">{{ $users->where('role', 'agent')->count() }}</span>
                </button>
            </div>
            <div class="col">
                <button type="button" class="btn btn-grd-success">Users <span class="badge bg-dark">{{ $users->where('role', 'user')->count() }}</span>
                </button>
            </div>
            <div class="col">
                <button type="button" class="btn btn-grd-warning">Active Users <span class="badge bg-dark">{{ $users->where('status', 'active')->count() }}</span>
                </button>
            </div>
            <div class="col">
                <button type="button" class="btn btn-grd-info">Admins <span class="badge bg-dark">{{ $users->where('role', 'admin')->count() }}</span>
                </button>
            </div>
        </div>

		<hr>
				<div class="card">
					<div class="card-body">
                         <div class="d-flex align-items-center gap-2 justify-content-lg-end" style="margin-bottom:10px">
                    <a href="{{ route('user.create') }}" class="btn btn-outline-primary px-5"><i class="bi bi-plus-lg me-2"></i>Add User</a>
                </div>
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								  <thead class="table-light">     
                                <tr>
                                   
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
								<tbody>
                                    @forelse($users as $user)
                                        <tr>
                                            <td>
                                                <a class="d-flex align-items-center gap-3" href="javascript:;">
                                                    <div class="customer-pic">
                                                        <img src="{{ $user->profile_image_url }}" class="rounded-circle" width="40" height="40" alt="{{ $user->full_name }}">
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <p class="mb-0 customer-name fw-bold">{{ $user->full_name }}</p>
                                                <small class="text-muted">{{ $user->city }}, {{ $user->country }}</small>
                                            </td>
                                                <td><a href="mailto:{{ $user->email }}" class="font-text1">{{ $user->email }}</a></td>
                                            <td>{{ $user->phone ?? 'N/A' }}</td>
                                                    <td>
                                                <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'agent' ? 'warning' : 'success') }}">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $user->status === 'active' ? 'success' : ($user->status === 'inactive' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($user->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                                            <!-- actions -->
                                             <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                        </svg>
                                                    </a>
                                                    
                                                    <form action="{{ route('users.toggle-status', $user->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-outline-{{ $user->status === 'active' ? 'warning' : 'success' }}" title="{{ $user->status === 'active' ? 'Deactivate' : 'Activate' }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-{{ $user->status === 'active' ? 'pause' : 'play' }}">
                                                                @if($user->status === 'active')
                                                                    <rect x="6" y="4" width="4" height="16"></rect>
                                                                    <rect x="14" y="4" width="4" height="16"></rect>
                                                                @else
                                                                    <polygon points="5,3 19,12 5,21"></polygon>
                                                                @endif
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                                                <polyline points="3,6 5,6 21,6"></polyline>
                                                                <path d="M19,6v14a2,2 0 0,1 -2,2H7a2,2 0 0,1 -2,-2V6m3,0V4a2,2 0 0,1 2,-2h4a2,2 0 0,1 2,2v2"></path>
                                                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
							</table>
						</div>
					</div>
				</div>
            


    </div>
  </main>
  

@endsection

