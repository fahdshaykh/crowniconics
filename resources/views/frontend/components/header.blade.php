    <!-- HEADER SECTION START -->
    <header class="ul-header ul-header--home">
        <div class="ul-header-bottom">
            <div class="ul-header-bottom-wrapper">
                <!-- header left -->
                <div class="header-bottom-left">
                    <div class="logo-container">
                        <a href="{{route('home')}}" class="d-inline-block"><img src="{{ asset('assets') }}/img/logo.png" alt="logo" class="logo"></a>
                    </div>
                </div>

                <!-- header nav -->
                <div class="ul-header-nav-wrapper">
                    <div class="to-go-to-sidebar-in-mobile">
                        <nav class="ul-header-nav">
                            <a href="{{route('home')}}">Home</a>
                            <div class="has-sub-menu">
                                <a role="button" href="{{route('allpropertise')}}">Properties</a>
                                <div class="ul-header-submenu">
                                    <ul>
                                        <li><a href="{{route('buy')}}">Buy</a></li>
                                        <li><a href="{{route('rent')}}">Rent</a></li>
                                    </ul>
                                </div>
                            </div>
                            <a href="{{route('services')}}">Professional Services</a>
                            <a href="{{route('about')}}">About</a>
                            <a href="{{route('contact')}}">Contact</a>

                            <!-- <div class="has-sub-menu">
                                <a role="button">Home</a>

                                <div class="ul-header-submenu">
                                    <ul>
                                        <li><a href="index.html">Home 1</a></li>
                                        <li><a href="index-2.html">Home 2</a></li>
                                    </ul>
                                </div>
                            </div> -->

                            <!-- <div class="has-sub-menu">
                                <a role="button">Property</a>

                                <div class="ul-header-submenu">
                                    <ul>
                                        <li><a href="projects.html">Properties</a></li>
                                        <li><a href="project-details.html">Property Details</a></li>
                                    </ul>
                                </div>
                            </div> -->

                            <!-- <div class="has-sub-menu">
                                <a role="button">Pages</a>

                                <div class="ul-header-submenu">
                                    <ul>
                                        <li><a href="services.html">Services</a></li>
                                        <li><a href="service-details.html">Service Details</a></li>
                                        <li><a href="team.html">Team</a></li>
                                        <li><a href="team-details.html">Team Details</a></li>
                                        <li><a href="how-it-works.html">How it works Page</a></li>
                                        <li><a href="pricing.html">Pricing Page</a></li>
                                    </ul>
                                </div>
                            </div> -->
                            <!-- <div class="has-sub-menu">
                                <a role="button">Blog</a>

                                <div class="ul-header-submenu">
                                    <ul>
                                        <li><a href="blog.html">Blogs</a></li>
                                        <li><a href="blog-2.html">Blog layout 2</a></li>
                                        <li><a href="blog-details.html">Blog Details</a></li>
                                    </ul>
                                </div>
                            </div> -->

                        </nav>
                    </div>
                </div>

                <!-- actions -->
                @if (Auth()->check())

                    @if (Auth()->user()->role === 'agent')
                        <div class="ul-header-actions">
                            <!-- <button class="ul-header-search-opener"><i class="flaticon-search"></i></button> -->
                            <a href="{{route('login')}}" class="add-property-btn d-xxs-none"><i class="flaticon-home"></i> Add Property</a>
                        </div>
                    @else

                    <div class="ul-header-actions">
                        <a href="{{route('login')}}" class="add-property-btn d-xxs-none"><i class="flaticon-home"></i> Dashboard</a>
                    </div>

                    @endif

                <div class="ul-header-actions">
                    <button class="ul-header-sidebar-opener"><i class="flaticon-menu-button"></i></button>
                </div>
            
                @else

                <div class="ul-header-actions">
                    <!-- <button class="ul-header-search-opener"><i class="flaticon-search"></i></button> -->
                    <a href="{{route('login')}}"><i class="flaticon-user"></i></a>
                    <!-- <button class="ul-header-sidebar-opener"><i class="flaticon-menu-button"></i></button> -->
                </div>


                @endif

                <!-- sidebar opener -->
                <div class="d-none">
                    <button class="ul-header-sidebar-opener"><i class="flaticon-menu-button"></i></button>
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER SECTION END -->