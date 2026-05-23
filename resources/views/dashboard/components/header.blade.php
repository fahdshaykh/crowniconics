<!--start header-->
  <header class="top-header">
    <nav class="navbar navbar-expand align-items-center gap-4" style="justify-content: space-between;">
      <div class="btn-toggle">
        <a href="javascript:;"><i class="material-icons-outlined">menu</i></a>
      </div>
      <ul class="navbar-nav gap-1 nav-right-links align-items-center">
        <li class="nav-item dropdown">
          <a href="javascript:;" class="dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
             <img src="{{ auth()->user()->profile_image_url ?? asset('dashboard/assets/images/avatars/01.png') }}" 
                  class="rounded-circle p-1 border" width="45" height="45" alt="{{ auth()->user()->name ?? '' }}">
          </a>
          <div class="dropdown-menu dropdown-user dropdown-menu-end shadow">
            <a class="dropdown-item gap-2 py-2" href="javascript:;">
              <div class="text-center">
                <img src="{{ auth()->user()->profile_image_url ?? asset('dashboard/assets/images/avatars/01.png') }}" 
                     class="rounded-circle p-1 shadow mb-3" width="90" height="90" alt="{{ auth()->user()->name ?? '' }}">
                <h5 class="user-name mb-0 fw-bold">Hello, {{ auth()->user()->first_name ?? auth()->user()->name }}</h5>
                <small class="text-muted">{{ auth()->user()->email }}</small>
                <div class="mt-2">
                  <span class="badge bg-{{ auth()->user()->role === 'admin' ? 'danger' : (auth()->user()->role === 'agent' ? 'warning' : 'success') }}">
                    {{ ucfirst(auth()->user()->role) }}
                  </span>
                </div>
              </div>
            </a>
            <hr class="dropdown-divider">
            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('dashboard') }}">
              <i class="material-icons-outlined">dashboard</i>Dashboard
            </a>
            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('profile.edit') }}">
              <i class="material-icons-outlined">person_outline</i>Profile
            </a>
            <hr class="dropdown-divider">
            <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display: none;">
              @csrf
            </form>
            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="material-icons-outlined">power_settings_new</i>Logout
            </a>
          </div>
        </li>
      </ul>
    </nav>
  </header>
  <!--end top header-->