<!--start sidebar-->
<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div class="logo-icon">
            <img src="{{ asset('assets/img/logo.png') }}" class="logo-img" alt="Crown Iconics">
        </div>
        <div class="logo-name flex-grow-1">
            <h5 class="mb-0">CrownIconics</h5>
        </div>
        <div class="sidebar-close">
            <span class="material-icons-outlined">close</span>
        </div>
    </div>
    <div class="sidebar-nav">

        <ul class="metismenu" id="sidenav">
            <li>
                <!-- <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" icon="fas fa-home">
                    Dashboard
                </x-nav-link> -->

                <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                    <div class="menu-title"><i class="material-icons-outlined">home</i></div>
                    <div class="menu-title">Dashboard </div>
                </a>

            </li>
            <li>
                <a href="{{ route('wishlist.index') }}" class="{{ request()->is('admin/wishlist*') ? 'active' : '' }}">
                    <div class="menu-title"><i class="material-icons-outlined">list</i></div>
                    <div class="menu-title"> Wishlist </div>
                </a>
            </li>
            @hasanyrole('admin|agent')
            <li>
                <a href="{{ route('properties') }}" class="{{ request()->is('admin/properties*') ? 'active' : '' }}">
                    <div class="menu-title"><i class="material-icons-outlined">business</i></div>
                    <div class="menu-title">Properties </div>
                </a>
            </li>
            @endhasanyrole
            
            @role('admin')
            <li>
                <a href="{{ route('services.index') }}" class="{{ request()->is('admin/services*') ? 'active' : '' }}">
                    <div class="menu-title"><i class="material-icons-outlined">gavel</i></div>
                    <div class="menu-title">Services </div>
                </a>
            </li>
            <li>
                <a href="{{ route('types.index') }}" class="{{ request()->is('admin/types*') ? 'active' : '' }}">
                    <div class="menu-title"><i class="material-icons-outlined">layers</i></div>
                    <div class="menu-title">Types</div>
                </a>
            </li>

            <li>
                <a href="{{ route('categories.index') }}"
                    class="{{ request()->is('admin/categories*') ? 'active' : '' }}">
                    <div class="menu-title"><i class="material-icons-outlined">category</i></div>
                    <div class="menu-title">Categories</div>
                </a>
            </li>
            <li>
                <a href="{{ route('subscription-plans.index') }}"
                    class="{{ request()->is('admin/subscription-plans*') ? 'active' : '' }}">
                    <div class="menu-title"><i class="material-icons-outlined">subscriptions</i></div>
                    <div class="menu-title">Subscription Plans</div>
                </a>
            </li>
            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon"><i class="material-icons-outlined">person</i>
                    </div>
                    <div class="menu-title">Users</div>
                </a>
                <ul>
                    <li><a href="{{ route('users.index') }}"><i class="material-icons-outlined">arrow_right</i>All Users</a>
                    </li>
                    <li><a href="{{ route('user.create') }}"><i class="material-icons-outlined">arrow_right</i>Create
                            User</a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon"><i class="material-icons-outlined">security</i>
                    </div>
                    <div class="menu-title">Authorization</div>
                </a>
                <ul>
                    <li><a href="{{ route('roles.index') }}"><i
                                class="material-icons-outlined">arrow_right</i>Roles</a>
                    </li>
                    <li><a href="{{ route('permissions.index') }}"><i
                                class="material-icons-outlined">arrow_right</i>Permissions</a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon"><i class="material-icons-outlined">home</i>
                    </div>
                    <div class="menu-title">CMS</div>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('sliders.index') }}"><i class="material-icons-outlined">arrow_right</i>Sliders</a>
                    </li>
                    <li>
                        <a href="{{ route('partners.index') }}"><i class="material-icons-outlined">arrow_right</i>Partners</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('contacts.index') }}" class="{{ request()->is('admin/contacts*') ? 'active' : '' }}">
                    <div class="menu-title"><i class="material-icons-outlined">contacts</i></div>
                    <div class="menu-title">Contact us</div>
                </a>
            </li>
            @endrole
        </ul>
    </div>
</aside>
<!--end sidebar-->