@extends('dashboard.layouts.app')
@section('title', 'contacts query') 
@section('content')

  <!--start main wrapper-->
  <main class="main-wrapper">
    <div class="main-content">
     <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Contact </div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Queries  </li>
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


						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								  <thead class="table-light">     
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
								<tbody>
                                    @forelse($contacts as $contact)
                                        <tr>
                                            <td>
                                                <p class="mb-0 customer-name fw-bold">{{ $contact->first_name }}</p>
                                            </td>
                                                <td><a href="mailto:{{ $contact->email }}" class="font-text1">{{ $contact->email }}</a></td>
                                            <td>{{ $contact->phone ?? 'N/A' }}</td>
                                            <td>{{ $contact->created_at->format('M d, Y') }}</td>
                                            <!-- actions -->
                                             <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('contacts.show', $contact->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                  <i class="material-icons-outlined">visibility</i>
                                                    </a>

                                                    
                                                
                                                    
                                                    <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                           <i class="material-icons-outlined">delete</i>
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

