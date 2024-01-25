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

    <div id="layout-q" class="theme-cyan">

        <!-- Navigation -->
        <div class="top-header">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <a href="#" class="logo d-flex align-items-center me-md-4 me-2">

                        <img src="{{ asset('/admin/assets/images/devi-logo-devi.png') }}" class="img-fluid" />
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