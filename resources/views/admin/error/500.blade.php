@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <h5 class="text-danger">{{ $exception->getMessage() }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection