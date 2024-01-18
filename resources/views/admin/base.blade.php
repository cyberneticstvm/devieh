<!doctype html>
<html class="no-js " lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Devi Eye Hospital and Opticians">
    <meta name="keyword" content="Devi Eye Hospital Admin">
    <title>Devi Eye Hospitals & Opticians</title>
    <link rel="icon" href="{{ asset('/admin/assets/images/favicon.ico') }}" type="image/x-icon"> <!-- Favicon-->

    <!-- project css file  -->
    <link rel="stylesheet" href="{{ asset('/admin/assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin/assets/css/al.style.min.css') }}">

    <link rel="stylesheet" href="{{ asset('/admin/assets/css/dataTables.min.css') }}">

    <!-- project layout css file -->
    <link rel="stylesheet" href="{{ asset('/admin/assets/css/layout.q.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin/assets/css/style.css') }}">
</head>

<body>

    <div id="layout-q" class="theme-blue">

        <!-- Navigation -->
        <div class="top-header">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <a href="#" class="logo d-flex align-items-center me-md-4 me-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" viewBox="0 0 64 80" fill="none">
                            <path d="M58.8996 22.7L26.9996 2.2C23.4996 -0.0999999 18.9996 0 15.5996 2.5C12.1996 5 10.6996 9.2 11.7996 13.3L15.7996 26.8L3.49962 39.9C-3.30038 47.7 3.79962 54.5 3.89962 54.6L3.99962 54.7L36.3996 78.5C36.4996 78.6 36.5996 78.6 36.6996 78.7C37.8996 79.2 39.1996 79.4 40.3996 79.4C42.9996 79.4 45.4996 78.4 47.4996 76.4C50.2996 73.5 51.1996 69.4 49.6996 65.6L45.1996 51.8L58.9996 39.4C61.7996 37.5 63.3996 34.4 63.3996 31.1C63.4996 27.7 61.7996 24.5 58.8996 22.7ZM46.7996 66.7V66.8C48.0996 69.9 46.8996 72.7 45.2996 74.3C43.7996 75.9 41.0996 77.1 37.9996 76L5.89961 52.3C5.29961 51.7 1.09962 47.3 5.79962 42L16.8996 30.1L23.4996 52.1C24.3996 55.2 26.5996 57.7 29.5996 58.8C30.7996 59.2 31.9996 59.5 33.1996 59.5C35.0996 59.5 36.9996 58.9 38.6996 57.8C38.7996 57.8 38.7996 57.7 38.8996 57.7L42.7996 54.2L46.7996 66.7ZM57.2996 36.9C57.1996 36.9 57.1996 37 57.0996 37L44.0996 48.7L36.4996 25.5V25.4C35.1996 22.2 32.3996 20 28.9996 19.3C25.5996 18.7 22.1996 19.8 19.8996 22.3L18.2996 24L14.7996 12.3C13.8996 8.9 15.4996 6.2 17.3996 4.8C18.4996 4 19.8996 3.4 21.4996 3.4C22.6996 3.4 23.9996 3.7 25.2996 4.6L57.1996 25.1C59.1996 26.4 60.2996 28.6 60.2996 30.9C60.3996 33.4 59.2996 35.6 57.2996 36.9Z" fill="black" />
                        </svg>
                        <span class="fs-4 fw-bold ms-2">DEVI</span>
                    </a>
                    <div class="d-flex">
                        <div class="dropdown mx-lg-3 mx-1">
                            <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle after-none" data-bs-toggle="dropdown">
                                <img src="{{ asset('/admin/assets/images/profile_av.png') }}" alt="mdo" width="32" height="32" class="rounded-circle">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end border-0 shadow">
                                <div class="card border-0 w240">
                                    <div class="card-body border-bottom">
                                        <div class="d-flex">
                                            <img class="avatar rounded-circle" src="{{ asset('/admin/assets/images/profile_av.png') }}" alt="">
                                            <div class="flex-fill ms-3">
                                                <p class="mb-0"><span class="fw-bold">{{ Auth::user()->name }}</span></p>
                                                <small class="text-muted">{{ Auth::user()->roles?->first()?->name }}</small>
                                                <a href="{{ route('logout') }}" class="d-block">Sign out</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="nav-link pe-0 d-block d-xl-none menu-toggle" href="#" title=""><i class="fa fa-navicon"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @include("admin.nav")
        <!-- main body area -->
        <div class="main px-lg-5 px-md-2">

            <!-- Body: Header -->
            <div class="body-header d-flex py-3">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <h1 class="fs-4 mt-1 mb-0">Hello, <span class="text-info"> {{ Auth::user()->name }}!</span></h1>
                            @if(Session::has('branch'))
                            <small class="text-muted">You are currently logged into in <span class="text-info">{{ currentBranch()->name }}</span> branch.</small>
                            @endif
                        </div>
                        <div class="col d-flex justify-content-lg-end mt-2 mt-md-0">
                            <div class="p-2 me-md-3">
                                <div><span class="h6 mb-0 fw-bold">8.18K</span> <small class="text-success"><i class="fa fa-angle-up"></i> 1.3%</small></div>
                                <small class="text-muted text-uppercase">Income</small>
                            </div>
                            <div class="p-2 me-md-3">
                                <div><span class="h6 mb-0 fw-bold">1.11K</span> <small class="text-success"><i class="fa fa-angle-up"></i> 4.1%</small></div>
                                <small class="text-muted text-uppercase">Expense</small>
                            </div>
                            <div class="p-2 pe-lg-0">
                                <div><span class="h6 mb-0 fw-bold">3.66K</span> <small class="text-danger"><i class="fa fa-angle-down"></i> 7.5%</small></div>
                                <small class="text-muted text-uppercase">Revenue</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @yield("content")
            <!-- Body: Footer -->
            <div class="body-footer d-flex">
                <div class="container">
                    <div class="col-12">
                        <div class="card mb-3 border-0">
                            <div class="card-body">
                                <div class="row justify-content-between align-items-center">
                                    <div class="col">
                                        <p class="font-size-sm mb-0">© DEVI. <span class="d-none d-sm-inline-block">
                                                <script>
                                                    document.write(/\d{4}/.exec(Date())[0])
                                                </script> Devi Eye Hospitals and Opticians.
                                            </span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Jquery Core Js -->
    <script src="{{ asset('/admin/assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('/admin/assets/bundles/dataTables.bundle.js') }}"></script>
    <script src="{{ asset('/admin/assets/bundles/select2.bundle.js') }}"></script>

    <!-- Plugin Js -->

    <!-- Jquery Page Js -->
    <script src="{{ asset('/admin/assets/js/template.js') }}"></script>
    <script src="{{ asset('/admin/assets/js/script.js') }}"></script>
    @include("admin.message")
</body>

</html>