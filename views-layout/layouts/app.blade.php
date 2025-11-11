<!DOCTYPE html>
<html lang="pt-BR" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />

    <!-- Core Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}?v=2" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}?v=3" />

    <title>{{ config('app.name', 'RFID Escolar') }} - @yield('title', 'Dashboard')</title>

    @stack('styles')
</head>

<body>

    <!-- Preloader -->
    <div class="preloader">
        <img src="{{ asset('assets/images/logos/favicon.png') }}" alt="loader" class="lds-ripple img-fluid" />
    </div>

    <div id="main-wrapper">
        <!-- Sidebar Start -->
        @include('layouts.partials.sidebar')
        <!-- Sidebar End -->

        <div class="page-wrapper">
            <!-- Header Start -->
            @include('layouts.partials.header')
            <!-- Header End -->

            <div class="body-wrapper">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            <!-- Search Modal -->
            @include('layouts.partials.search-modal')
        </div>
    </div>

    <div class="dark-transparent sidebartoggler"></div>

    <!-- Import Js Files -->
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme/app.init.js') }}"></script>
    <script src="{{ asset('assets/js/theme/theme.js') }}"></script>
    <script src="{{ asset('assets/js/theme/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme/sidebarmenu.js') }}"></script>

    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

    @stack('scripts')
</body>

</html>