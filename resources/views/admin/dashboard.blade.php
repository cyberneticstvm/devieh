@extends("admin.base")
@section("content")
<!-- Body: Body -->
<div class="body d-flex py-lg-4 py-3">
    <div class="container">

        <div class="row">
            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-body text-center p-5">
                        <img src="{{ asset('/admin/assets/images/no-data.svg') }}" class="w120" alt="No Data">
                        <div class="mt-4 mb-3">
                            <span class="text-muted">No data to show</span>
                        </div>
                        <button type="button" class="btn btn-white border lift">Get Started</button>
                        <button type="button" class="btn btn-primary border lift">Back to Home</button>
                    </div>
                </div>

            </div>
        </div> <!-- .row end -->
    </div>
</div>
@if(!Session::has('branch'))
<div class="modal fade" id="branchSelector" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="branchSelector" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-toggle-wrapper">
                    <h4 class="text-center pb-2">Select Branch!</h4>
                    <form method="post" action="{{ route('user.branch.update') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                {{ html()->select($name = 'branch', $value = $branches, NULL)->class('form-control')->placeholder('Select Branch')->required() }}
                                @error('branches')
                                <small class="text-danger">{{ $errors->first('branches') }}</small>
                                @enderror
                            </div>
                        </div>
                        <button class="btn btn-secondary d-flex m-auto mt-3 btn-submit" type="submit">Update Branch</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection