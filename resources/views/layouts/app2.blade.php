<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MABALACAT DORM: A WEB APPLICATION FOR ENHANCED TENANT MONITORING AND MANAGEMENT') }}</title>

    <!-- Fonts and CSS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="shortcut icon" href="{{ asset('admin_assets/assets/images/logo/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('admin_assets/assets/images/logo/logo.png') }}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- FullCalendar CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('admin_assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('admin_assets/assets/css/fontawesome.css')}}">
    <link rel="stylesheet" href="{{ asset('admin_assets/assets/css/templatemo-villa-agency.css')}}">
    <link rel="stylesheet" href="{{ asset('admin_assets/assets/css/owl.css')}}">
    <link rel="stylesheet" href="{{ asset('admin_assets/assets/css/animate.css')}}">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    @yield('styles')

    <!-- Vite Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <!-- ***** Header Area Start ***** -->
    <div class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- Logo -->
                        <a href="/" class="logo">
                            <h1>APARTMENT</h1>
                        </a>

                        <!-- Menu -->
                        <ul class="nav">
                            <li><a href="/" class="{{ request()->is('/') ? 'active' : '' }}">HOME</a></li>
                            <li><a href="{{ route('booking.forms') }}" class="{{ request()->is('booking-forms') ? 'active' : '' }}">RENT APARTMENT</a></li>
                            <li><a href="{{ route('nav-contents.about_us') }}" class="{{ request()->is('nav-contents.about_us') ? 'active' : '' }}">ABOUT US</a></li>
                            <!-- <li><a href="#contact-form" class="{{ request()->is('#contact-form') ? 'active' : '' }}">CONTACT US</a></li> -->
                            @if(Auth::check())
                                <!-- Display user name and email if logged in -->
                                <li class="px-2">
                                    <div onclick="window.location.href='{{ route('dashboard') }}'"
                                        class="font-bold bg-orange-400 text-gray-800 py-2 px-2 text-base
                                                cursor-pointer transition duration-300 ease-in-out transform
                                                hover:bg-orange-600 hover:text-white hover:border-orange-600 rounded-md">
                                        {{ Auth::user()->name }}
                                    </div>
                                </li>
                            @else
                                <!-- Show Sign In link if not logged in -->
                                <li>
                                    <a href="{{ route('login') }}" class="{{ request()->is('login') ? 'active' : '' }}">
                                        <i class="bi bi-person-circle"></i> SIGN IN
                                    </a>
                                </li>
                            @endif
                        </ul>
                        <!-- Mobile Menu Trigger -->
                        <a class="menu-trigger">
                            <span>Menu</span>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    @yield('contents')

    <!-- Footer -->
    <div class="tap-to-top">
        <a href="#page-top">
            <i class="fas fa-chevron-up"></i>
        </a>
    </div>
    <div class="bg-overlay"></div>
    <!-- This is for Inquaries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- jQuery (full version) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Other Scripts -->
    <script src="{{ asset('admin_assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('admin_assets/assets/js/isotope.min.js')}}"></script>
    <script src="{{ asset('admin_assets/assets/js/owl-carousel.js')}}"></script>
    <script src="{{ asset('admin_assets/assets/js/counter.js')}}"></script>
    <script src="{{ asset('admin_assets/assets/js/custom.js')}}"></script>

    <!-- Additional Custom Scripts -->
    @yield('scripts')
</body>
</html>
