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
    <link rel="stylesheet" href="{{ asset('/admin/assets/css/al.style.min.css') }}">

    <!-- project layout css file -->
    <link rel="stylesheet" href="{{ asset('/admin/assets/css/layout.q.min.css') }}">
</head>

<body>

    <div id="layout-n" class="theme-blue">

        <!-- main body area -->
        <div class="main auth-div6">

            <!-- Body: Body -->
            <div class="body">
                <div class="login-form custom_scroll">
                    <!-- Form -->
                    {{ html()->form('POST', route('signin'))->class('row g-3')->open() }}
                    <div class="col-12 text-center mb-4">
                        <h1><span class="text-gradient fw-bold">DEVI EYE HOSPITALS & OPTICIANS</span></h1>
                        <h3>LOG IN</h3>
                    </div>
                    <div class="col-12">
                        <div class="mb-2">
                            <label class="form-label">Username</label>
                            {{ html()->text('username', old('username'))->class('form-control form-control-lg')->placeholder('Username') }}
                        </div>
                        @error('username')
                        <small class="text-danger">{{ $errors->first('username') }}</small>
                        @enderror
                    </div>
                    <div class="col-12">
                        <div class="mb-2">
                            <label class="form-label">Password</label>
                            {{ html()->password('password', old('password'))->class('form-control form-control-lg')->placeholder('******')}}
                        </div>
                        @error('password')
                        <small class="text-danger">{{ $errors->first('password') }}</small>
                        @enderror
                    </div>
                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-lg btn-block btn-dark btn-submit lift text-uppercase">LET ME IN</button>
                    </div>
                    {{ html()->form()->close() }}
                    <!-- End Form -->
                </div>
                <div class="login-text d-none d-md-flex">
                    <div>
                        <h2 class="bg-text fw-bold">Make a Dream.</h2>
                        <p class="lead">Most trusted and affordable eye care center.</p>
                        <a href="https://devieyecare.com" class="btn btn-lg bg-secondary text-uppercase lift">View more</a>
                    </div>
                    <svg class="svg-1" version="1.1" viewBox="0 0 146.6 134.7">
                        <circle class="st0" cx="7.3" cy="129.6" r="2.9" />
                        <circle class="st0" cx="26.2" cy="129.6" r="2.9" />
                        <circle class="st0" cx="45" cy="129.6" r="2.9" />
                        <circle class="st0" cx="63.9" cy="129.6" r="2.9" />
                        <circle class="st0" cx="82.7" cy="129.6" r="2.9" />
                        <circle class="st0" cx="101.6" cy="129.6" r="2.9" />
                        <circle class="st0" cx="120.5" cy="129.6" r="2.9" />
                        <circle class="st0" cx="139.3" cy="129.6" r="2.9" />
                        <circle class="st0" cx="7.3" cy="111.8" r="2.9" />
                        <circle class="st0" cx="26.2" cy="111.8" r="2.9" />
                        <circle class="st0" cx="45" cy="111.8" r="2.9" />
                        <circle class="st0" cx="63.9" cy="111.8" r="2.9" />
                        <circle class="st0" cx="82.7" cy="111.8" r="2.9" />
                        <circle class="st0" cx="101.6" cy="111.8" r="2.9" />
                        <circle class="st0" cx="120.5" cy="111.8" r="2.9" />
                        <circle class="st0" cx="139.3" cy="111.8" r="2.9" />
                        <circle class="st0" cx="7.3" cy="94" r="2.9" />
                        <circle class="st0" cx="26.2" cy="94" r="2.9" />
                        <circle class="st0" cx="45" cy="94" r="2.9" />
                        <circle class="st0" cx="63.9" cy="94" r="2.9" />
                        <circle class="st0" cx="82.7" cy="94" r="2.9" />
                        <circle class="st0" cx="101.6" cy="94" r="2.9" />
                        <circle class="st0" cx="120.5" cy="94" r="2.9" />
                        <circle class="st0" cx="139.3" cy="94" r="2.9" />
                        <circle class="st0" cx="7.3" cy="76.3" r="2.9" />
                        <circle class="st0" cx="26.2" cy="76.3" r="2.9" />
                        <circle class="st0" cx="45" cy="76.3" r="2.9" />
                        <circle class="st0" cx="63.9" cy="76.3" r="2.9" />
                        <circle class="st0" cx="82.7" cy="76.3" r="2.9" />
                        <circle class="st0" cx="101.6" cy="76.3" r="2.9" />
                        <circle class="st0" cx="120.5" cy="76.3" r="2.9" />
                        <circle class="st0" cx="139.3" cy="76.3" r="2.9" />
                        <circle class="st0" cx="7.3" cy="58.5" r="2.9" />
                        <circle class="st0" cx="26.2" cy="58.5" r="2.9" />
                        <circle class="st0" cx="45" cy="58.5" r="2.9" />
                        <circle class="st0" cx="63.9" cy="58.5" r="2.9" />
                        <circle class="st0" cx="82.7" cy="58.5" r="2.9" />
                        <circle class="st0" cx="101.6" cy="58.5" r="2.9" />
                        <circle class="st0" cx="120.5" cy="58.5" r="2.9" />
                        <circle class="st0" cx="139.3" cy="58.5" r="2.9" />
                        <circle class="st0" cx="7.3" cy="40.7" r="2.9" />
                        <circle class="st0" cx="26.2" cy="40.7" r="2.9" />
                        <circle class="st0" cx="45" cy="40.7" r="2.9" />
                        <circle class="st0" cx="63.9" cy="40.7" r="2.9" />
                        <circle class="st0" cx="82.7" cy="40.7" r="2.9" />
                        <circle class="st0" cx="101.6" cy="40.7" r="2.9" />
                        <circle class="st0" cx="120.5" cy="40.7" r="2.9" />
                        <circle class="st0" cx="139.3" cy="40.7" r="2.9" />
                        <circle class="st0" cx="7.3" cy="22.9" r="2.9" />
                        <circle class="st0" cx="26.2" cy="22.9" r="2.9" />
                        <circle class="st0" cx="45" cy="22.9" r="2.9" />
                        <circle class="st0" cx="63.9" cy="22.9" r="2.9" />
                        <circle class="st0" cx="82.7" cy="22.9" r="2.9" />
                        <circle class="st0" cx="101.6" cy="22.9" r="2.9" />
                        <circle class="st0" cx="120.5" cy="22.9" r="2.9" />
                        <circle class="st0" cx="139.3" cy="22.9" r="2.9" />
                        <circle class="st0" cx="7.3" cy="5.1" r="2.9" />
                        <circle class="st0" cx="26.2" cy="5.1" r="2.9" />
                        <circle class="st0" cx="45" cy="5.1" r="2.9" />
                        <circle class="st0" cx="63.9" cy="5.1" r="2.9" />
                        <circle class="st0" cx="82.7" cy="5.1" r="2.9" />
                        <circle class="st0" cx="101.6" cy="5.1" r="2.9" />
                        <circle class="st0" cx="120.5" cy="5.1" r="2.9" />
                        <circle class="st0" cx="139.3" cy="5.1" r="2.9" />
                    </svg>
                    <svg class="svg-2" version="1.1" viewBox="0 0 58 58">
                        <path d="M29,57.1c-0.1,0-0.1,0-0.2-0.1L1,29.2c-0.1-0.1-0.1-0.3,0-0.4L28.8,1c0.1-0.1,0.3-0.1,0.4,0    L57,28.8c0.1,0.1,0.1,0.3,0,0.4L29.2,57C29.1,57.1,29.1,57.1,29,57.1z M1.6,29L29,56.4L56.4,29L29,1.6L1.6,29z" />
                        <path d="M29,47.7c-0.1,0-0.1,0-0.2-0.1L10.4,29.2c-0.1-0.1-0.1-0.3,0-0.4l18.4-18.4    c0.1-0.1,0.3-0.1,0.4,0l18.4,18.4c0.1,0.1,0.1,0.3,0,0.4L29.2,47.6C29.1,47.6,29.1,47.7,29,47.7z M11,29l18,18l18-18L29,11L11,29z" />
                        <path d="M29,38.3c-0.1,0-0.1,0-0.2-0.1l-9-9c-0.1-0.1-0.1-0.3,0-0.4l9-9c0.1-0.1,0.3-0.1,0.4,0l9,9    c0.1,0.1,0.1,0.1,0.1,0.2s0,0.1-0.1,0.2l-9,9C29.1,38.2,29.1,38.3,29,38.3z M20.4,29l8.6,8.6l8.6-8.6L29,20.4L20.4,29z" />
                    </svg>
                </div>
            </div>

        </div>

    </div>

    <!-- Jquery Core Js -->
    <script src="{{ asset('/admin/assets/bundles/libscripts.bundle.js') }}"></script>

    <!-- Plugin Js -->

    <!-- Jquery Page Js -->
    <script src="{{ asset('/admin/assets/js/template.js') }}"></script>
    @include("admin.message")

</body>

</html>