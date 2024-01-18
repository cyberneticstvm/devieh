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

    <div id="layout-q" class="theme-green">

        <!-- main body area -->
        <div class="main auth-div p-2 py-3 p-xl-5">

            <!-- Body: Body -->
            <div class="body d-flex p-0 p-xl-5">
                <div class="container-fluid">

                    <div class="row g-0">
                        <div class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center rounded-lg auth-h100">

                        </div>

                        <div class="col-lg-6 d-flex justify-content-center align-items-center border-0 rounded-lg auth-h100">
                            <div class="w-100 p-4 p-md-5 card border-0" style="max-width: 32rem;">
                                <!-- Form ->acceptsFiles()-->
                                {{ html()->form('POST', route('signin'))->class('')->open() }}
                                <div class="col-12 text-center mb-5">
                                    <h1>Sign in</h1>
                                    <span>Devi Eye Hospitals & Opticians.</span>
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
                                    <button type="submit" class="btn btn-block btn-success btn-submit lift text-uppercase">SIGN IN</button>
                                </div>
                                </form>
                                <!-- End Form -->
                            </div>
                        </div>
                    </div> <!-- End Row -->

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